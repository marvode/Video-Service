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
    <div class="col-lg-8">
        <?php
        $videoId = $_GET["id"];
        $video = new Video($con, $videoId, $userLoggedInObj);

        if(!isset($_SESSION["userLoggedIn"])) {
            echo "";
        }

        else {
            
            $videoPlayer = new VideoPlayer($video, $userLoggedInObj);
            echo $videoPlayer->create(true);
            echo "<br>";

        //     else {
        //         echo "<div class='col-sm-12 bg-dark d-flex' style='height:30em; text-align:center;'>
        //                 <div class='my-auto mx-auto'>
        //                 <h1>Insufficient Funds</h1>
        //                 <h5>Please recharge to view this video</h5>
        //                 </div>
        //             </div>";
        //     }
        }

        $videoPlayer = new VideoInfoSection($con, $video, $userLoggedInObj);
        echo $videoPlayer->create();

        ?>
    </div>

</div>

<script src="assets/js/videoPlayerAction.js"></script>


<?php require_once("include/footer.php"); ?>
