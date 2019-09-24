<?php
require_once("../include/config.php");

if(isset($_POST['videoId'])) {

    $videoId = $_POST['videoId'];

    if(delete($con, $videoId)) {
        deleteThumbnail($con, $videoId);
        deleteVideo($con, $videoId);
        
    }
}

function getFilePath($con, $videoId){
    $query = $con->prepare("SELECT filePath FROM videos WHERE id=:videoId");
    $query->bindParam(":videoId", $videoId);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    return "../" .$result["filePath"];
}

function getThumbnailFilePath($con, $videoId) {
    $query = $con->prepare("SELECT filePath FROM thumbnails WHERE videoId=:videoId");
    $query->bindParam(":videoId", $videoId);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    return "../" .$result["filePath"];
}

function deleteThumbnailFile($con, $videoId) {
    $filePath = "../" . getThumbnailFilePath($con, $videoId);
    if(!unlink($filePath)) {
        echo "Could not delete file\n";
        return false;
    }

    return true;
}

function deleteThumbnail($con, $videoId) {
    deleteThumbnailFile($con, $videoId);
    $query = $con->prepare("DELETE FROM thumbnails WHERE videoId=:videoId");
    $query->bindParam(":videoId", $videoId);
    $query->execute();
}

function deleteVideo($con, $videoId) {
    $query = $con->prepare("DELETE FROM videos WHERE id=:videoId");
    $query->bindParam(":videoId", $videoId);
    $query->execute();
}

function delete($con, $videoId) {
    $filePath = "../" . getFilePath($con, $videoId);
    if(!unlink($filePath)) {
        echo "Could not delete file\n";
        return false;
    }

    return true;
}

?>
