<?php
class Transaction {
    private $con, $video, $userLoggedInObj, $userLoggedIn;
    private $percentage = 0.7;

    public function __construct($con, $video, $userLoggedInObj) {
        $this->con = $con;
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
        $this->userLoggedIn = $userLoggedInObj->getUsername();
    }

    public function initiateSubscribe($amount) {
        $amount = (int)$amount;
        if($this->debitUser($amount)) {
            $this->creditUserTo($amount);
            $this->creditAdmin($amount);

            return true;
        }
        return false;
    }

    private function getAdminBalance() {
        $adminId = 1;
        $query = $this->con->prepare("SELECT * FROM admin WHERE id=:id");
        $query->bindParam(":id", $adminId);
        $query->execute();

        $sqlData = $query->fetch(PDO::FETCH_ASSOC);
        return (float)$sqlData["balance"];
    }

    private function getUserToBalance() {
        $userTo = $this->video->getUploadedBy();
        $query = $this->con->prepare("SELECT * FROM users WHERE user_name=:userTo");
        $query->bindParam(":userTo", $userTo);
        $query->execute();

        $sqlData = $query->fetch(PDO::FETCH_ASSOC);
        return (float)$sqlData["balance"];
    }

    private function creditUserTo($amount) {

        $uploaderProfit = $this->percentage * $amount;
        $userTo = $this->video->getUploadedBy();
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
        $balance = $this->getAdminBalance() + $adminProfit;


        $query = $this->con->prepare("UPDATE admin SET balance=:balance WHERE id=:admin");
        $query->bindParam(":balance", $balance);
        $query->bindParam(":admin", $admin);

        $query->execute();

        $userLoggedIn = $this->userLoggedIn;
        $this->recordTransaction($adminProfit, $userLoggedIn, 'admin');
    }

    private function debitUser($amount) {
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

    private function recordTransaction($amount, $userFrom, $userTo) {
        $query = $this->con->prepare("INSERT INTO transactions (userFrom, userTo, amount) VALUES (:userFrom, :userTo, :amount)");
        $query->bindParam(":userFrom", $userFrom);
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":amount", $amount);

        $query->execute();
    }
}
?>
