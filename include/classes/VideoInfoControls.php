<?php
require_once("include/classes/ButtonProvider.php");

class VideoInfoControls {
    private $video, $userLoggedInObj;

    public function __construct($video, $userLoggedInObj) {
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create() {
        $likeButton = $this->createLikeButton();
        $dislikeButton = $this->createDislikeButton();

        return "<div class='d-flex justify-content-end btn-group' style='display:inline;'>
                    $likeButton
                    $dislikeButton
                </div>";
    }

    private function createLikeButton() {
        $text = $this->video->getLikes();
        $videoId = $this->video->getId();
        $action = "likeVideo(this, $videoId)";
        $class = "likeButton btn";

        $imageSrc = "assets/images/icons/thumb-up.png";

        if($this->video->wasLikedBy()) {
            $imageSrc = "assets/images/icons/thumb-up-active.png";
        }

        return ButtonProvider::createButton($text, $imageSrc, $action, $class);
    }

    private function createDislikeButton() {
        $text = $this->video->getDislikes();
        $videoId = $this->video->getId();
        $action = "dislikeVideo(this, $videoId)";
        $class = "dislikeButton btn";

        $imageSrc = "assets/images/icons/thumb-down.png";

        if($this->video->wasDislikedBy()) {
            $imageSrc = "assets/images/icons/thumb-down-active.png";
        }

        return ButtonProvider::createButton($text, $imageSrc, $action, $class);
    }
}
?>
