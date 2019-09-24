<?php
require_once("../include/config.php");
require_once("../include/classes/User.php");
require_once("../include/classes/Transactions.php");

if(isset($_POST["username"]) &&  isset($_POST["amount"])){
    $amount = $_POST["amount"];
    $username = $_POST["username"];

    if($amount != "") {
        $user = new User($con, $username);
        $wasSuccessful = $user->setSubscriptionCost($amount);

        echo "Value Set";
    }
    else {
        echo "No value entered";
    }

}
?>
