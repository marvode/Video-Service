<?php
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/SearchResultsProvider.php");

if(!isset($_GET["search"]) || $_GET["search"] == "") {
    echo "You must enter a search term";
    exit();
}

$term = $_GET["search"];

if(!isset($_GET["orderBy"]) || $_GET["orderBy"] == "views") {
    $orderBy = "views";
}
else {
    $orderBy = "uploadDate";
}

$searchResultsProvider = new SearchResultsProvider($con, $userLoggedInObj);
$videos = $searchResultsProvider->getVideos($term, $orderBy);

$videoGrid = new VideoGrid($con, $userLoggedInObj);

?>

<div class="">
    <?php
    if(sizeof($videos) > 0) {
        echo $videoGrid->createLarge($videos, sizeof($videos) . " results found", true);
    }
    else {
        echo "No result found";
    }
    ?>
</div>

<?php require_once("include/footer.php");?>
