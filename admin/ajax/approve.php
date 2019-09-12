<?php
require_once("../include/config.php");

if(isset($_POST['requestId'])) {
    
    $requestId = $_POST['requestId'];

    $query = $con->prepare("UPDATE withdrawals SET withdrawalStatus=1 WHERE id=:requestId");
    $query->bindParam(":requestId", $requestId);
    $query->execute();

}

?>