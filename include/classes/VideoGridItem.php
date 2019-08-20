<?php
class VideoGridItem {
    private $video, $largeMode;

    public function __construct($video, $largeMode) {
        $this->video = $video;
        $this->largeMode = $largeMode;
    }

    public function create() {
        $thumbnail = $this->createThumbnail();
        $details = $this->createDetails();
        $duration = $this->video->getDuration();
        $url = "watch.php?id=".$this->video->getId();

        return "<div class='col-lg-3 col-md-4 mt-3' style='min-width:210px;'>
                <div class='card'>
                    <a class='text-dark' href='$url'>
                    <div class=''>$thumbnail</div>
                    <span>$duration</span>
                    <div class='p-1'>$details</div>
                    </a>
                </div>
                </div>";
    }

    private function createThumbnail() {
        $thumbnail = $this->video->getThumbnail();


        return "<img class='card-img-top' src='$thumbnail'>";
    }

    private function createDetails() {
        $title = $this->video->getTitle();
        $username = $this->video->getUploadedBy();
        $description = $this->createDescription();
        $views = $this->video->getViews();
        $timestamp = $this->video->getTimeStamp();

        return "<div class='pr-1 pl-1'>
                    <h6 class=''>$title</h6>
                    <span class=''>$username</span>
                    <div class=''>
                        <span class=''>$views views</span>
                        <span class=''>$timestamp</span>
                    </div>
                    $description
                </div>";
    }

    private function createDescription() {
        if(!$this->largeMode) {
            return "";
        }
        else {
            $description = $this->video->getDescription();
            $description = (strlen($description) > 350) ? substr($description, 0, 347) . "..." : $description;
            return "<span class='description'>$description</span>";
        }
    }
}
?>
