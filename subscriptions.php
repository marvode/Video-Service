<?php require_once("include/header.php");
require_once("include/afterNav.php");

if(!User::isLoggedIn()) {
    header("Location: sign_in.php");
}

$subscriptionsProvider = new SubscriptionsProvider($con, $userLoggedInObj);
$videos = $subscriptionsProvider->getVideos();

$videoGrid = new VideoGrid($con, $userLoggedInObj);
 ?>

 <div class="">
    <?php
    if(sizeof($videos) > 0) {
        echo $videoGrid->createSubscriptions($videos, "New from your subscriptions", false);
    }
    else {
        echo "No videos to show";
    }
    ?>

 </div>
<?php require_once("include/footer.php"); ?>
