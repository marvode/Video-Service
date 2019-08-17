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

    public function getName() {
        return $this->sqlData["first_name"] . " " . $this->sqlData["last_name"];
    }

    public function getFirstName() {
        return $this->sqlData["first_name"];
    }

    public function getLastName() {
        return $this->sqlData["last_name"];
    }

    public function getEmailName() {
        return $this->sqlData["email"];
    }

    public function getProfilePic() {
        return $this->sqlData["profilePic"];
    }

    public function getSignUpDate() {
        return $this->sqlData["signUpDate"];
    }
}

?>
