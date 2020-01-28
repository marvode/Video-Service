<?php
class Account {
    private $con;
    private $errorArray = array();

    public function __construct($con){
        $this->con = $con;
    }

    public function login($uname, $pword) {
        $pword = sha1($pword);
        // locating user in database
        $query = $this->con->prepare("SELECT * FROM admin WHERE user_name=:uname AND password=:pword");
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
