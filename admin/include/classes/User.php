<?php
class User {
    private $con, $sqlData;

    public function __construct($con, $username) {
        $this->con = $con;

        $query = $this->con->prepare("SELECT * FROM admin WHERE user_name=:username");
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

    public function getBalance() {
        return (int)$this->sqlData["balance"];
    }
}

?>
