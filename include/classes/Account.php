<?php
class Account {
    private $con;
    private $errorArray = array();

    public function __construct($con){
        $this->con = $con;
    }

    public function login($uname, $pword) {
        $pword = hash("sha512", $pword);

        // locating user in database
        $query = $this->con->prepare("SELECT * FROM users WHERE user_name=:uname AND password=:pword");
        $query->bindParam(":uname", $uname);
        $query->bindParam(":pword", $pword);

        $query->execute();

        // validating username and password
        if($query->rowCount() == 1) {
            return true;
        }
        else {
            array_push($this->errorArray, Constants::$loginFailed);
            return false;
        }
    }

    public function register($first_name, $last_name, $user_name, $email, $email2, $pass_word, $pass_word2) {
        $this->validateFirstName($first_name);
        $this->validateLastName($last_name);
        $this->validateUsername($user_name);
        $this->validateEmails($email, $email2);
        $this->validatePasswords($pass_word, $pass_word2);

        if(empty($this->errorArray)) {
            return $this->insertUserDetails($first_name, $last_name, $user_name, $email, $pass_word);
        }
        else {
            return false;
        }
    }

    public function updateDetails($first_name, $last_name, $user_name, $email, $pass_word) {
        $this->validateFirstName($first_name);
        $this->validateLastName($last_name);
        $this->validateNewEmail($email, $user_name);

        if(empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET firstName=:first_name, last_name=:last_name, email=:email WHERE user_name=:user_name");

            $query->bindParam(":first_name", $first_name);
            $query->bindParam(":last_name", $last_name);
            $query->bindParam(":email", $email);
            $query->bindParam(":user_name", $user_name);

            return $query->execute();
        }
        else {
            return false;
        }
    }

    public function updatePassword($oldPw, $pw, $pw2, $user_name) {
        $this->validateoldPassword($oldPw, $user_name);
        $this->validatePasswords($pw, $pw2);

        if(empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET password=:pw WHERE user_name=:user_name");
            $pw = hash("sha512", $pw);
            $query->bindParam(":pw", $pw);
            $query->bindParam(":user_name", $user_name);

            return $query->execute();
        }
        else {
            return false;
        }
    }

    private function validateOldPassword($oldPw, $user_name) {
        $pw = hash("sha512", $oldPw);

        $query = $this->con->prepare("SELECT * FROM users WHERE user_name=:user_name AND password=:pw");
        $query->bindParam(":user_name", $user_name);
        $query->bindParam(":pw", $pw);

        $query->execute();

        if($query->rowCount() == 0) {
            array_push($this->errorArray, Constants::$passwordIncorrect);
        }
    }

    public function insertUserDetails($first_name, $last_name, $user_name, $email, $pass_word) {
        $pass_word = hash("sha512", $pass_word);
        $profilePic = "assets/images/profilePictures/default.png";

        $query = $this->con->prepare("INSERT INTO users (first_name, last_name, user_name, email, password, profilePic) VALUES(:first_name, :last_name, :user_name, :email, :password, :pic)");

        $query->bindParam(":first_name", $first_name);
        $query->bindParam(":last_name", $last_name);
        $query->bindParam(":user_name", $user_name);
        $query->bindParam(":email", $email);
        $query->bindParam(":password", $pass_word);
        $query->bindParam(":pic", $profilePic);

        return $query->execute();
    }

    private function validateFirstName($first_name) {
        if(strlen($first_name) > 25 || strlen($first_name) < 2) {
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($last_name) {
        if(strlen($last_name) > 25 || strlen($last_name) < 2) {
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    private function validateUsername($user_name) {
        if(strlen($user_name) > 25 || strlen($user_name) < 2) {
            array_push($this->errorArray, Constants::$usernameCharacters);
            return;
        }

        $query = $this->con->prepare("SELECT user_name FROM users WHERE user_name=:user_name");
        $query->bindParam(":user_name", $user_name);

        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$usernameTaken);
        }
    }

    private function validateEmails($email, $email2) {
        if($email != $email2) {
            array_push($this->errorArray, Constants::$emailsDoNotMatch);
            return;
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT email FROM users WHERE email=:email");
        $query->bindParam(":email", $email);

        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validateNewEmail($email, $username) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT email FROM users WHERE email=:email AND user_name!=:username");
        $query->bindParam(":email", $email);
        $query->bindParam(":username", $username);

        $query->execute();

        if($query->rowCount() != 0) {
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validatePasswords($password, $password2) {
        if($password != $password2) {
            array_push($this->errorArray, Constants::$passwordsDoNotMatch);
            return;
        }

        if(preg_match("/[^A-Za-z0-9]/", $password)) {
            array_push($this->errorArray, Constants::$passwordNotAlphanumeric);
            return;
        }

        if(strlen($password) < 5 || strlen($password) > 30) {
            array_push($this->errorArray, Constants::$passwordLength);
            return;
        }
    }

    public function getError($error) {
        if(in_array($error, $this->errorArray)) {
            return "<span class='errorMessage'>$error</span>";
        }
    }

    public function getFirstError() {
        if(!empty($this->errorArray)) {
            return $this->errorArray[0];
        }
        else {
            return "";
        }
    }

}
?>
