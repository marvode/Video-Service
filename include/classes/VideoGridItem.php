<?php
class VideoGridItem {
    private $video, $largeMode;

    public function __construct($video, $largeMode) {
        $this->video = $video;
        $this->largeMode = $largeMode;
    }

    public function create() {

        $url = "watch.php?id=".$this->video->getId();

        return "<a href='$url'>
                    <div class=''>
                    </div>
                </a>";
    }

    private function createDetails() {
        $title = $this->video->getTitle();
        $username = $this->video->getUploadedBy();
        $description = $this->createDescription();

        return "<div class=''>
                    <h3 class=''>$title</h3>
                    <span class=''>$username</span>
                    $description
                </div>";
    }
}
?>
