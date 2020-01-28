<?php
require_once("../include/config.php");
require_once("../include/classes/User.php");
require_once("../include/classes/Video.php");
require_once("../include/classes/VideoGrid.php");
require_once("../include/classes/VideoGridItem.php");
require_once("../include/classes/ButtonProvider.php");
require_once("../include/classes/SubscriptionsProvider.php");

$username = $_SESSION["userLoggedIn"];
$userLoggedInObj = new User($con, $username);

$record_per_page = 15;
$page = "";
$output = "";

if(isset($_POST["page"])) {
    $page = $_POST["page"];
}
else {
    $page = 1;
}
$start_from = ($page-1)*$record_per_page;

$subscriptionsProvider = new SubscriptionsProvider($con, $userLoggedInObj);
$videos = $subscriptionsProvider->getVideos();

if(sizeof($videos) > 0) {
    $videoGrid = new VideoGrid($con, $userLoggedInObj);
    echo $videoGrid->createSubscriptions($videos, "New from your subscriptions", false, $start_from, $record_per_page);
}
else {
    echo "No videos to show";
}
?>
