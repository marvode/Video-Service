<?php
class Transaction {
    $percentage = 0.7;

    public __contruct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    private function getAdminBalance() {
        $adminId = 1;
        $query = $this->con->prepare("SELECT * FROM users WHERE id=:id")
        $query->bindParam(":id", $adminId);
        $query->execute()

        $sqlData = $query->fetch(PDO::FETCH_ASSOC);
        return $sqlData["balance"];
    }

    public function creditUser($amount, $userToObj) {

        $uploaderProfit = $percentage * $amount;
        $userTo = $this->userTo
        $balance = $userToObj->getBalance() + $uploaderProfit;


        $query = $this->con->prepare("UPDATE user SET balance=:balance WHERE id=:id");
        $query->bindParam(":balance", $balance);
        $query->bindParam(":id", $userToObj->getId());

        $query->execute();
    }

    public function creditAdmin($amount) {

        $adminProfit = (1 - $percentage) * $amount;
        $admin = "admin";
        $balance = getAdminBalance() + $adminProfit;


        $query = $this->con->prepare("UPDATE user SET balance=:balance WHERE user_name=:username");
        $query->bindParam(":balance", $balance);
        $query->bindParam(":username", $admin);

        $query->execute();
    }

    public function debitUser($amount) {
        $balance
        if($balance >= $amount) {
            $query = $this->con->prepare("UPDATE user SET balance=:balance where user_name=:username");
            $query->bindParam(":balance", $balance);
            $query->bindParam(":username", $userLoggedIn);

            $query->execute();
            return true;
        }
        return false;
    }

}
?>
