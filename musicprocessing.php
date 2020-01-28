<?php
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/AudioUploadData.php");
require_once("include/classes/AudioProcessor.php");

if(!isset($_POST["musicUploadButton"])) {
    echo "No file sent to page.";
    exit();
}

// create file upload data
$audioUploadData = new AudioUploadData(
                            $_FILES["musicFileInput"],
                            $_POST["musicTitleInput"],
                            $_POST["musicDescriptionInput"],
                            $_POST["genreInput"],
                            $userLoggedInObj->getUsername(),
                            $_POST["musicLanguageInput"],
                            $_FILES["musicPicInput"]
                        );

// Process video data (upload)
$audioProcessor = new AudioProcessor($con);
$wasSuccessful = $audioProcessor->upload($audioUploadData);

if ($wasSuccessful) {
    echo "Upload successfully.";
}

?>
