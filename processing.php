<?php
require_once("include/header.php");
require_once("include/classes/VideoUploadData.php");
require_once("include/classes/VideoProcessor.php");

if(!isset($_POST["uploadButton"])) {
    echo "No file sent to page.";
    exit();
}

// create file upload data
$videoUploadData = new VideoUploadData(
                            $_FILES["fileInput"],
                            $_POST["titleInput"],
                            $_POST["descriptionInput"],
                            "REPLACE-THIS"
                        );

// Process video data (upload)
$videoProcessor = new VideoProcessor($con);
$wasSuccessful = $videoProcessor->upload($videoUploadData);

if ($wasSuccessful) {
    echo "Upload successfully.";
}

?>
