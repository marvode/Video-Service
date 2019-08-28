<?php
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/VideoPlayer.php");
require_once("include/classes/VideoInfoSection.php");

if(!isset($_GET["id"])) {
    echo "No url passed into page";
    exit();
}
?>
<div class="row">
    <div class="col-lg-8">
        <?php
        $video = new Video($con, $_GET["id"], $userLoggedInObj);

        $videoPlayer = new VideoPlayer($video, $userLoggedInObj);
        echo $videoPlayer->create(true);
        echo "<br>";
        $video->incrementViews();

        $videoPlayer = new VideoInfoSection($con, $video, $userLoggedInObj);
        echo $videoPlayer->create();

        ?>
    </div>

    <div class="col-lg-4">
        <?php
        $videoGrid = new VideoGrid($con, $userLoggedInObj);
        echo $videoGrid->createSuggestions(null, "Suggested Videos", false);
        ?>
    </div>
</div>

<script src="assets/js/videoPlayerAction.js"></script>


<?php require_once("include/footer.php"); ?>
