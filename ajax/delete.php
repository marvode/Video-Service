<?php
require_once("../include/config.php");

if(isset($_POST['videoId'])) {

    $videoId = $_POST['videoId'];

    if(delete($con, $videoId)) {
        $query = $con->prepare("DELETE FROM videos WHERE id=:videoId");
        $query->bindParam(":videoId", $videoId);
        $query->execute();
    }
}

function getFilePath($con, $videoId){
    $query = $con->prepare("SELECT filePath WHERE id=:videoId");
    $query->bindParam(":videoId", $videoId);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result["filePath"];
}

function delete($con, $videoId) {
    $filePath = getFilePath($con, $videoId);
    if(!unlink($filePath)) {
        echo "Could not delete file\n";
        return false;
    }

    return true;
}

?>
