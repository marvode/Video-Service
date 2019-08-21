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
$video->incrementViews();
echo $video->getViews() . " views";
echo "<br>";
echo $video->getUploadedBy();
echo "<br><br>";
echo $video->getDescription();
echo "<br><br>";
?>


<?php require_once("include/footer.php"); ?>
