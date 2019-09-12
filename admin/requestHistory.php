<?php 
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/RequestApproval.php");


$requests = new RequestView($con);

if(User::isLoggedIn()) {
    echo $requests->getRequestHistory();
}

require_once("include/footer.php")
?>