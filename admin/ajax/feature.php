<?php
require_once("../include/config.php");

if(isset($_POST['videoId'])) {
    
    $videoId = $_POST['videoId'];

    if(!isFeature($con, $videoId)) {
        $query = $con->prepare("UPDATE videos SET featureVideo=1 WHERE id=:videoId");
    }
    else {
        $query = $con->prepare("UPDATE videos SET featureVideo=0 WHERE id=:videoId");
    }

    $query->bindParam(":videoId", $videoId);
    $query->execute();
}


function isFeature($con, $videoId) {
    $query = $con->prepare("SELECT * FROM videos WHERE featureVideo=1 AND id=:videoId");
    $query->bindParam(":videoId", $videoId);
    $query->execute();

    if($query->rowCount() == 1) {
        return true;
    }
    return false;
}

?>