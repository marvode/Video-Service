<?php
require_once("../include/config.php");
require_once("../include/classes/Audio.php");
require_once("../include/classes/AudioGrid.php");
require_once("../include/classes/User.php");
require_once("../include/classes/AudioItem.php");
require_once("../include/classes/ButtonProvider.php");
require_once("../include/classes/AudioSearch.php");

$username = $_SESSION["userLoggedIn"];
$userLoggedInObj = new User($con, $username);

$record_per_page = 15;
$page = "";
$output = "";

if(isset($_POST["search"])) {
    $term = $_POST["search"];

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

$searchResultsProvider = new AudioSearch($con, $userLoggedInObj);
$audio = $searchResultsProvider->getAudio($term, $start_from, $record_per_page);

$audioGrid = new AudioGrid($con, $userLoggedInObj);

if(sizeof($audio) > 0) {
    echo $audioGrid->generateItemsFromAudio($audio, sizeof($audio) . " results found", $start_from, $record_per_page);
}
else {
    echo "No result found";
}
?>
