<?php
require_once("../include/config.php");
require_once("../include/classes/Video.php");
require_once("../include/classes/User.php");

$username = $_SESSION["userLoggedIn"];
$videoId = $_POST["videoId"];

$userLoggedInObj = new User($con, $username);
$video = new Video($con, $videoId, $userLoggedInObj);

echo $video->like();
?>
