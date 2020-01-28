<?php
require_once("../include/config.php");

if(isset($_POST['videoId'])) {

    $videoId = $_POST['videoId'];

    if(delete($con, $videoId)) {
        deleteThumbnail($con, $videoId);
        deleteVideo($con, $videoId);
        header("Refresh:0");
    }
}

if(isset($_POST['messageId'])) {
    $messageId = $_POST['messageId'];

    $query = $con->prepare("DELETE FROM contact WHERE id=:messageId");
    $query->bindParam(":messageId", $messageId);
    $query->execute();
}

if(isset($_POST['audioId'])) {
    $audioId = $_POST['audioId'];
    echo "Count";
    if(deleteAudio($con, $audioId)) {
        $query = $con->prepare("DELETE FROM audio WHERE id=:audioId");
        $query->bindParam(":audioId", $audioId);
        $query->execute();
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
    }

    return true;
}

function getAudioFilePath($con, $audioId){
    $query = $con->prepare("SELECT filePath FROM audio WHERE id=:audioId");
    $query->bindParam(":audioId", $audioId);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    return "../" .$result["filePath"];
}

function deleteAudio($con, $audioId) {
    $filePath = "../" . getAudioFilePath($con, $audioId);
    if(!unlink($filePath)) {
        echo "Could not delete file\n";
        return false;
    }

    return true;
}

?>
