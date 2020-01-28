<?php
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/Request.php");

$requestObj = new Request($con, $userLoggedInObj);

if(isset($_POST["submit"])) {
    $requestAmount = $_POST["amount"];
    $bankName = $_POST["paymentMedium"];
    $accountName = $_POST["paymentId"];

    if($requestObj->requestWithdrawal($requestAmount, $accountName, "null", $bankName, 1)) {
        echo "<h3>Request Submitted Successfully</h3>";
        exit();
    }
    else {
        echo "<h3>Insufficient Balance</h3>";
        exit();
    }
}
else {
    echo $requestObj->getAllRequest();
}
?>
<?php require_once("include/footer.php"); ?>
