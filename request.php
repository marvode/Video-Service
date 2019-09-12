<?php
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/Request.php");

$requestObj = new Request($con, $userLoggedInObj);

if(isset($_POST["submit"])) {
    $requestAmount = $_POST["amount"];
    $accountName = $_POST["accountName"];
    $accountNo = $_POST["accountNo"];
    $bankName = $_POST["bankName"];

    if($requestObj->requestWithdrawal($requestAmount, $accountName, $accountNo, $bankName)) {
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
