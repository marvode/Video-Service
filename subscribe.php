<?php
require_once("include/header.php");
require_once("include/afterNav.php");

$userTo = $_GET["userTo"];

function subscription($con, $userLoggedInObj, $userTo) {
    //check if user is SUBSCRIBED
    $userFrom = $userLoggedInObj->getUsername();
    $query = $con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
    $query->bindParam(":userTo", $userTo);
    $query->bindParam(":userFrom", $userFrom);

    $query->execute();

    // insert if user not subscribed
    if($query->rowCount() == 0) {
        if($subscriptionCost != 0) {
            $transaction = new Transaction($con, $userTo, $userLoggedInObj);

            if($transaction->initiateSubscribe()){
                $query = $con->prepare("INSERT INTO subscribers(userTo, userFrom) VALUES(:userTo, :userFrom)");
                $query->bindParam(":userTo", $userTo);
                $query->bindParam(":userFrom", $userFrom);
                $query->execute();

                return true;
            }
            else {
                return false;
            }
        }
        else {
            $query = $con->prepare("INSERT INTO subscribers(userTo, userFrom) VALUES(:userTo, :userFrom)");
            $query->bindParam(":userTo", $userTo);
            $query->bindParam(":userFrom", $userFrom);
            $query->execute();

            return true;
        }
    }
    //delete if user subscribed
    else {
        $query = $con->prepare("DELETE FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
        $query->bindParam(":userTo", $userTo);
        $query->bindParam(":userFrom", $userFrom);
        $query->execute();

        return true;
    }
}


if(User::isLoggedIn()) {
    if(subscription($con, $userLoggedInObj, $userTo)) {
        echo "Success";
    }
    else {
        echo "Insufficient Funds";
    }
}
else{
    echo "Login to Subscribe";
}

 ?>

<?php
require_once("include/footer.php");
?>
