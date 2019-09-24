<?php
require_once("../include/config.php");
require_once("../include/classes/User.php");
require_once("../include/classes/Transactions.php");


if(isset($_POST["username"])) {
    $username = $_POST["username"];
    $user = new User($con, $username);
    if($user->upgrade()) {
        echo "1";
    }
    else {
        echo "Insufficient Funds to Upgrade";
    }
}
?>
