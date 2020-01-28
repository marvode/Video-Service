<?php
require_once("../include/config.php");
require_once("../include/classes/Video.php");
require_once("../include/classes/VideoGrid.php");
require_once("../include/classes/VideoGridItem.php");
require_once("../include/classes/ButtonProvider.php");
require_once("../include/classes/User.php");

$username = isset($_SESSION["userLoggedIn"]) ? $_SESSION["userLoggedIn"] : "";
$userLoggedInObj = new User($con, $username);

$record_per_page = 16;
$page = "";
$output = "";

if(isset($_POST["page"])) {
    $page = $_POST["page"];
}
else {
    $page = 1;
}
$start_from = ($page-1)*$record_per_page;

if(isset($_POST["category"]) && !isset($_POST["language"])) {
    $category = $_POST["category"];
    $videoGrid = new VideoGrid($con, $userLoggedInObj);
    echo $videoGrid->createFilter($category, $start_from, $record_per_page);
    echo $videoGrid->languageCategory($category);
}
elseif(isset($_POST["category"]) && isset($_POST["language"])) {
    $category = $_POST["category"];
    $language = $_POST["language"];
    $videoGrid = new VideoGrid($con, $userLoggedInObj);
    echo $videoGrid->languageVideos($category, $language, $start_from, $record_per_page);
}
else {
    echo "Invalid Entry";
    exit();
}
?>
