<?php
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/VideoUploadData.php");
require_once("include/classes/VideoProcessor.php");

if(!isset($_POST["uploadButton"])) {
    echo "No file sent to page.";
    exit();
}

$contentInput = $userLoggedInObj->isPremium() ? $_POST["contentInput"] : 0;
// create file upload data
$videoUploadData = new VideoUploadData(
                            $_FILES["fileInput"],
                            $_FILES["videoPicInput"],
                            $_POST["titleInput"],
                            $_POST["descriptionInput"],
                            $_POST["categoryInput"],
                            $userLoggedInObj->getUsername(),
                            $_POST["languageInput"],
                            $contentInput
                        );

// Process video data (upload)
$videoProcessor = new VideoProcessor($con);
$wasSuccessful = $videoProcessor->upload($videoUploadData);

if ($wasSuccessful) {
    echo "Upload successfully.";
}

?>
