<?php
require_once("../include/config.php");
require_once("../include/classes/User.php");
require_once("../include/classes/Transactions.php");

if(isset($_POST["amount"]) && isset($_POST["user"])) {
    $amount = $_POST["amount"];
    $user = $_POST["user"];

    $userLoggedInObj = new User($con, $user);

    Transaction::creditUser($amount, $userLoggedInObj, $con);
}
?>
