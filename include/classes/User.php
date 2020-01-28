<?php
class User {
    private $con, $sqlData;

    public function __construct($con, $username) {
        $this->con = $con;

        $query = $this->con->prepare("SELECT * FROM users WHERE user_name=:username");
        $query->bindParam(":username", $username);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        // var_dump($this->sqlData);
    }

    public static function isLoggedIn() {
        return isset($_SESSION["userLoggedIn"]);
    }

    public function getUsername() {
        return $this->sqlData["user_name"];
    }

    public function getUserId() {
        return (int)$this->sqlData["id"];
    }

    public function getName() {
        return $this->sqlData["first_name"] . " " . $this->sqlData["last_name"];
    }

    public function getFirstName() {
        return $this->sqlData["first_name"];
    }

    public function getLastName() {
        return $this->sqlData["last_name"];
    }

    public function getEmail() {
        return $this->sqlData["email"];
    }

    public function getProfilePic() {
        return $this->sqlData["profilePic"];
    }

    public function getBalance() {
        return (float)$this->sqlData["balance"];
    }

    public function getSubscriptionCost() {
        return (float)$this->sqlData["subscriptionCost"];
    }

    public function setSubscriptionCost($amount) {
        $query = $this->con->prepare("UPDATE users SET subscriptionCost=:amount WHERE id=:id");
        $query->bindParam(":amount", $amount);
        $query->bindParam(":id", $id);
        $id = $this->getUserId();
        $query->execute();
        return true;
    }

    public function getSignUpDate() {
        return $this->sqlData["signUpDate"];
    }

    public function getUpgradeDate() {
        $query = $this->con->prepare("SELECT upgradeDate FROM premiumUsers WHERE userId=:id ORDER BY id DESC");
        $query->bindParam(":id", $id);
        $id = $this->getUserId();
        $query->execute();
        if($query->rowCount() > 0) {
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $datetime = explode(" ", $row["upgradeDate"]);
            $date = explode("-", $datetime[0]);
            $time = explode(":", $datetime[1]);

            return mktime((int)$time[0], (int)$time[1], (int)$time[2], (int)$date[1], (int)$date[2], (int)$date[0]);
        }
    }

    public function isSubscribedTo($userTo) {
        $query = $this->con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $username);

        $username = $this->getUsername();
        $query->execute();
        return $query->rowCount() > 0;
    }

    public function getSubscriberCount() {
        $query = $this->con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo");
        $query->bindParam(":userTo", $username);
        $username = $this->getUsername();
        $query->execute();
        return $query->rowCount();
    }

    public function getSubscriptions() {
        $query = $this->con->prepare("SELECT userTo FROM subscribers WHERE userFrom=:userFrom");
        $username = $this->getUsername();
        $query->bindParam(":userFrom", $username);
        $query->execute();

        $subs = array();

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($this->con, $row["userTo"]);
            array_push($subs, $user);
        }
        return $subs;
    }

    private function setUpgrade($accountType) {
        $query = $this->con->prepare("UPDATE users SET accountType=:accountType WHERE user_name=:user");
        $query->bindParam(":accountType", $accountType);
        $query->bindParam(":user", $username);
        $username = $this->getUsername();

        $query->execute();
    }

    public function recordUpgrade($upgrade) {
        if($upgrade == true){
            $this->setUpgrade("Premium");
            $query = $this->con->prepare("INSERT INTO premiumUsers (userId) VALUES (:userId)");
        }
        else {
            $this->setUpgrade("Basic");
            $query = $this->con->prepare("DELETE FROM premiumUsers WHERE userId=:userId");
        }

        $query->bindParam(":userId", $userId);
        $userId = $this->getUserId();

        $query->execute();
    }

    public function isPremium() {
        $query = $this->con->prepare("SELECT * FROM users WHERE id=:userId");
        $query->bindParam(":userId", $userId);
        $userId = $this->getUserId();
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC)["accountType"];

        if($data == "Premium") {
            return true;
        }
        return false;
    }

    public function upgrade() {
        if(Transaction::debitUser(10, $this, $this->con)) {
            $this->recordUpgrade(true);
            return true;
        }
        return false;
    }

    public function downgrade() {
        if(((int)time() >= $this->getDowngradeDate()) && !$this->upgrade()) {
            $this->recordUpgrade(false);
            $this->setSubscriptionCost(0);
        }
    }

    private function getSubscriptionDate($userTo, $userFrom) {
        $query = $this->con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $userFrom);
        $query->execute();

        $date =  $query->fetch(PDO::FETCH_ASSOC)["date"];
        return strtotime($date);
    }

    public function unsubscribe($userTo, $userFrom) {
        $query = $this->con->prepare("DELETE FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $userFrom);

        $query->execute();
    }

    public function subscriptionCheck($userFrom) {
        $thirtyDays = 30 * 24 * 60 * 60;
        $subscriptions = $this->getSubscriptions();
        $subarray = array();
        foreach($subscriptions as $num) {
            array_push($subarray, $num->getUsername());
        }
        foreach ($subarray as $subscribeTo) {
            $expiryDate = $this->getSubscriptionDate($subscribeTo, $userFrom) + $thirtyDays;
            $currentDate = time();

            if($currentDate >= $expiryDate) {
                echo date("d M Y", $currentDate);
                $this->unsubscribe($subscribeTo, $userFrom);
            }
        }
    }

    public function getDowngradeDate() {
        return (int)$this->getUpgradeDate() + (60 * 60 * 24 * 366);
    }
}

?>
