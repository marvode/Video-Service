<?php
require_once("include/header.php");
require_once("include/classes/VideoPlayer.php");

if(!isset($_GET["id"])) {
    echo "No url passed into page";
    exit();
}

$video = new Video($con, $_GET["id"], $userLoggedInObj);

$videoPlayer = new VideoPlayer($video);
echo $videoPlayer->create(true);
echo "<br>";
echo $video->getUploadedBy();
echo "<br><br>";
echo $video->getDescription();


?>


<?php require_once("include/footer.php"); ?>
