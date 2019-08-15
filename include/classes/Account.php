<?php
class Account {
    private $con;
    private $errorArray = array();

    public function __construct($con){
        $this->con = $con;
    }

    public function login($uname, $pword) {
        $password = hash("sha512", $password);

        // locating user in database
        $query = $this->con->prepare("SELECT * FROM users WHERE username=:uname AND password:=pw");
        $query->bindParam(":uname", $uname);
        $query->bindParam(":pword", $pword);

        $query->execute():

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
            return $this->insertUserDetails($first_name, $last_name, $user_name, $email, $pass_word)
        }
        else {
            return false;
        }
    }
}
?>
