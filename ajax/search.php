<?php
require_once("../include/config.php");
require_once("../include/classes/Video.php");
require_once("../include/classes/VideoGrid.php");
require_once("../include/classes/User.php");
require_once("../include/classes/VideoGridItem.php");
require_once("../include/classes/ButtonProvider.php");
require_once("../include/classes/SearchResultsProvider.php");

$username = $_SESSION["userLoggedIn"];
$userLoggedInObj = new User($con, $username);

$record_per_page = 15;
$page = "";
$output = "";

if(isset($_POST["search"]) && isset($_POST["orderBy"])) {
    $term = $_POST["search"];
    $orderBy = $_POST["orderBy"];

    if(isset($_POST["page"])) {
        $page = $_POST["page"];
    }
    else {
        $page = 1;
    }
}
else {
    echo "Enter a search term";
    exit();
}

$start_from = ($page-1)*$record_per_page;

$searchResultsProvider = new SearchResultsProvider($con, $userLoggedInObj);
$videos = $searchResultsProvider->getVideos($term, $orderBy, $start_from, $record_per_page);

$videoGrid = new VideoGrid($con, $userLoggedInObj);

if(sizeof($videos) > 0) {
    echo $videoGrid->createLarge($videos, sizeof($videos) . " results found", "", $start_from, $record_per_page);
}
else {
    echo "No result found";
}
?>
