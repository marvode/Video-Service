<?php
require_once("../include/config.php");
require_once("../include/classes/Transactions.php");
require_once("../include/classes/User.php");

if(isset($_POST["userTo"]) && isset($_POST["userFrom"])) {
    $userTo = $_POST["userTo"];
    $userFrom = $_POST["userFrom"];

    $userLoggedInObj = new User($con, $userFrom);

    //check if user is SUBSCRIBED
    $query = $con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
    $query->bindParam(":userTo", $userTo);
    $query->bindParam(":userFrom", $userFrom);

    $query->execute();

    // insert if user not subscribed
    if($query->rowCount() == 0) {
        $transaction = new Transaction($con, $userTo, $userLoggedInObj);

        if($transaction->initiateSubscribe()){
            $query = $con->prepare("INSERT INTO subscribers(userTo, userFrom) VALUES(:userTo, :userFrom)");
            $query->bindParam(":userTo", $userTo);
            $query->bindParam(":userFrom", $userFrom);
            $query->execute();

            echo "success";
        }
        else {
            echo "Unable to subscribe to this Channel: Insufficient Funds";
        }
    }
    //delete if user subscribed
    else{
        $query = $con->prepare("DELETE FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $userFrom);
        $query->execute();

        echo "success";
    }

    // $query = $con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo");
    // $query->bindParam(":userTo", $userTo);
    // $query->execute();
    //
    // echo $query->rowCount();
}
?>
