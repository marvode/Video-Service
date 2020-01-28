<?php
class Transaction {
    private $con, $userTo, $userLoggedInObj, $userLoggedIn;
    private $percentage = 0.7;

    public function __construct($con, $userTo, $userLoggedInObj) {
        $this->con = $con;
        $this->userTo = $userTo;
        $this->userLoggedInObj = $userLoggedInObj;
        $this->userLoggedIn = $userLoggedInObj->getUsername();
    }

    public function initiateSubscribe() {
        $userToObj = new User($this->con, $this->userTo);
        $amount = (float)$userToObj->getSubscriptionCost();
        if($this->debitUserForSubscription($amount)) {
            $this->creditUserTo($amount);
            $this->creditAdmin($amount);

            return true;
        }
        return false;
    }

    public static function getAdminBalance($con) {
        $adminId = 1;
        $query = $con->prepare("SELECT * FROM admin WHERE id=:id");
        $query->bindParam(":id", $adminId);
        $query->execute();

        $sqlData = $query->fetch(PDO::FETCH_ASSOC);
        return (float)$sqlData["balance"];
    }

    private function getUserToBalance() {
        $userTo = $this->userTo;
        $query = $this->con->prepare("SELECT * FROM users WHERE user_name=:userTo");
        $query->bindParam(":userTo", $userTo);
        $query->execute();

        $sqlData = $query->fetch(PDO::FETCH_ASSOC);
        return (float)$sqlData["balance"];
    }

    private function creditUserTo($amount) {

        $uploaderProfit = $this->percentage * $amount;
        $userTo = $this->userTo;
        $balance = $this->getUserToBalance() + $uploaderProfit;


        $query = $this->con->prepare("UPDATE users SET balance=:balance WHERE user_name=:username");
        $query->bindParam(":balance", $balance);
        $query->bindParam(":username", $userTo);

        $query->execute();

        $userLoggedIn = $this->userLoggedIn;
        $this->recordTransaction($uploaderProfit, $userLoggedIn, $userTo);
    }

    private function creditAdmin($amount) {

        $adminProfit = (1 - $this->percentage) * $amount;
        $admin = 1;
        $balance = Transaction::getAdminBalance($this->con) + $adminProfit;


        $query = $this->con->prepare("UPDATE admin SET balance=:balance WHERE id=:admin");
        $query->bindParam(":balance", $balance);
        $query->bindParam(":admin", $admin);

        $query->execute();

        $userLoggedIn = $this->userLoggedIn;
        $this->recordTransaction($adminProfit, $userLoggedIn, 'admin');
    }

    private function debitUserForSubscription($amount) {
        $balance = $this->userLoggedInObj->getBalance();
        if($balance >= $amount) {
            $balance = $balance - $amount;
            $id = $this->userLoggedInObj->getUserId();
            $query = $this->con->prepare("UPDATE users SET balance=:balance where id=:id");
            $query->bindParam(":balance", $balance);
            $query->bindParam(":id", $id);

            $query->execute();
            return true;
        }
        return false;
    }

    public static function debitUser($amount, $userLoggedInObj, $con) {
        $balance = $userLoggedInObj->getBalance();
        if($balance >= $amount) {
            $balance = $balance - $amount;
            $id = $userLoggedInObj->getUserId();
            $query = $con->prepare("UPDATE users SET balance=:balance where id=:id");
            $query->bindParam(":balance", $balance);
            $query->bindParam(":id", $id);

            $query->execute();
            Transaction::creditAdmin2($amount, $con, $userLoggedInObj->getUsername());
            return true;
        }
        return false;
    }

    public static function creditUser($amount, $userLoggedInObj, $con) {
        $balance = $userLoggedInObj->getBalance();
        $balance = $balance + $amount;
        $id = $userLoggedInObj->getUserId();
        $query = $con->prepare("UPDATE users SET balance=:balance where id=:id");
        $query->bindParam(":balance", $balance);
        $query->bindParam(":id", $id);
        $query->execute();
    }

    public static function creditAdmin2($amount, $con, $usernameLoggedIn) {
        $admin = 1;
        $balance = Transaction::getAdminBalance($con) + $amount;
        $query = $con->prepare("UPDATE admin SET balance=:balance WHERE id=:admin");
        $query->bindParam(":balance", $balance);
        $query->bindParam(":admin", $admin);
        $query->execute();

        Transaction::recordTransaction2($amount, $usernameLoggedIn, 'admin', $con);
    }

    public static function recordTransaction2($amount, $userFrom, $userTo, $con) {
        $query = $con->prepare("INSERT INTO transactions (userFrom, userTo, amount) VALUES (:userFrom, :userTo, :amount)");
        $query->bindParam(":userFrom", $userFrom);
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":amount", $amount);

        $query->execute();
    }

    private function recordTransaction($amount, $userFrom, $userTo) {
        $query = $this->con->prepare("INSERT INTO transactions (userFrom, userTo, amount) VALUES (:userFrom, :userTo, :amount)");
        $query->bindParam(":userFrom", $userFrom);
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":amount", $amount);

        $query->execute();
    }

    public static function recordWithdrawal($con, $amount, $userId, $withdrawalStatus, $accountName, $accountNo, $bankName, $others) {
        if($others !=0) {
            $query = $con->prepare("INSERT INTO withdrawals (userId, amount, withdrawalStatus, accountName, accountNo, bankName) VALUES (:userId, :amount, :withdrawalStatus, :accountName, :accountNo, :bankName)");
            $query->bindParam(":userId", $userId);
            $query->bindParam(":amount", $amount);
            $query->bindParam(":accountName", $accountName);
            $query->bindParam(":accountNo", $accountNo);
            $query->bindParam(":bankName", $bankName);
            $query->bindParam(":withdrawalStatus", $withdrawalStatus);

            $query->execute();
        }
        else {
            $query = $con->prepare("INSERT INTO withdrawals (userId, amount, withdrawalStatus, accountName, accountNo, bankName, others) VALUES (:userId, :amount, :withdrawalStatus, :accountName, :accountNo, :bankName, :others)");
            $query->bindParam(":userId", $userId);
            $query->bindParam(":amount", $amount);
            $query->bindParam(":accountName", $accountName);
            $query->bindParam(":accountNo", $accountNo);
            $query->bindParam(":bankName", $bankName);
            $query->bindParam(":withdrawalStatus", $withdrawalStatus);
            $query->bindParam(":others", $others);

            $query->execute();
        }
    }

    public function withdrawalRequest($amount) {
        return Transaction::recordWithdrawal($this->con, $amount, $this->userLoggedInObj->getId, 0);
    }

    public function withdrawalApproval($amount) {
        return Transaction::recordWithdrawal($this->con, $amount, $this->userLoggedInObj->getId, 1);
    }
}
?>
