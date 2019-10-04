<?php
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/VideoPlayer.php");
require_once("include/classes/VideoInfoSection.php");
require_once("include/classes/VideoHistory.php");

if(!isset($_GET["id"])) {
    echo "No url passed into page";
    exit();
}
?>

<div class="row">
    <div class="col-md-8">
        <?php
        $videoId = $_GET["id"];
        $video = new Video($con, $videoId, $userLoggedInObj);
        $contentType = $video->getContentType();

        if(!isset($_SESSION["userLoggedIn"])) {
            if($contentType == 0){
                $videoPlayer = new VideoPlayer($video, $userLoggedInObj);
                echo $videoPlayer->create(true);
                echo "<br>";
                $video->incrementViews();
            }
            else {
                echo "<div class='col-sm-12 bg-dark d-flex' style='height:30em; text-align:center;'>
                        <div class='my-auto mx-auto'>
                        <h1>This is a paid content</h1>
                        <h5>Please login to view this video</h5>
                        </div>
                    </div>";
            }

        }

        else {
            if($contentType == 0 || $_SESSION["userLoggedIn"] == $video->getUploadedBy()){
                $videoHistory = new VideoHistory($con, $video, $userLoggedInObj);
                $videoHistory->create();
                $videoPlayer = new VideoPlayer($video, $userLoggedInObj);
                echo $videoPlayer->create(true);
                echo "<br>";
                if($_SESSION["userLoggedIn"] != $video->getUploadedBy()) {
                    $video->incrementViews();
                }
            }
            elseif($contentType == 1 && $userLoggedInObj->isSubscribedTo($video->getUploadedBy())) {
                $videoHistory = new VideoHistory($con, $video, $userLoggedInObj);
                $videoHistory->create();
                $videoPlayer = new VideoPlayer($video, $userLoggedInObj);
                echo $videoPlayer->create(true);
                echo "<br>";
                $video->incrementViews();
            }

            else {
                echo "<div class='col-sm-12 bg-dark d-flex' style='height:30em; text-align:center;'>
                        <div class='my-auto mx-auto'>
                        <h1>Not Subscribed to this channel</h1>
                        <h5>Please subscribe to view this video</h5>
                        </div>
                    </div>";
            }
        }

        $videoPlayer = new VideoInfoSection($con, $video, $userLoggedInObj);
        echo $videoPlayer->create();

        ?>
    </div>

    <div class="col-md-4">
        <?php
        $videoGrid = new VideoGrid($con, $userLoggedInObj);
        echo $videoGrid->createSuggestions(null, "Suggested Videos", false);
        ?>
    </div>
</div>

<script src="assets/js/videoPlayerAction.js"></script>


<?php require_once("include/footer.php"); ?>
