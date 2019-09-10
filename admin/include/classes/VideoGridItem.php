<?php
class VideoGridItem {
    private $video, $largeMode;


    public function __construct($video, $largeMode) {
        $this->video = $video;
        $this->largeMode = $largeMode;
    }

    public function create($largeMode) {
        $thumbnail = $this->createThumbnail();
        $details = $this->createDetails($largeMode);
        $duration = $this->video->getDuration();
        $url = "watch.php?id=".$this->video->getId();

        return "<div class='col-lg-4'>
                    <a class='text-light' href='$url' style='text-decoration:none;'>
                    <div class='thumbnail'>$thumbnail</div>
                    <div class='p-1 mousehover'>$details</div>
                    </a>
                </div>";
    }

    public function createLatest($largeMode) {
        $thumbnail = $this->createThumbnail();
        $details = $this->createDetails($largeMode);
        $duration = $this->video->getDuration();
        $url = "watch.php?id=".$this->video->getId();

        return "<div class='col-lg-3 mt-3'>
                    <a class='text-light' href='$url' style='text-decoration:none;'>
                    <div class='thumbnail'>$thumbnail</div>
                    <div class='p-1 mousehover'>$details</div>
                    </a>
                </div>";
    }

    public function createSuggestions($largeMode) {
        $thumbnail = $this->createThumbnail();
        $details = $this->createDetails($largeMode);
        $duration = $this->video->getDuration();
        $url = "watch.php?id=".$this->video->getId();

        return "<div class='col mt-3'>
                    <a class='text-light' href='$url' style='text-decoration:none;'>
                    <div class=''>$thumbnail</div>
                    <div class='p-1 mousehover'>$details</div>
                    </a>
                </div>";
    }

    public function createAttractionItem($largeMode) {
        $thumbnail = $this->createThumbnail();
        $title = $this->video->getTitle();
        $details = $this->createDetails($largeMode);
        $url = "watch.php?id=".$this->video->getId();

        return "<div class='row'>
                    <a class='text-light col-md-8' href='$url' style='text-decoration:none; padding:0px;'>
                    <div class='img-hover-zoom'>$thumbnail</div>
                    </a>
                    <div class='col-md-4 bg-dark text-light d-flex' style='padding:0px;text-align:center;'>
                        <div class='my-auto mx-auto'>
                            <h3 class='pb-5'>$title</h3>
                            <a id='attractionBtn' class='btn btn-info btn-lg mb-2' href='$url'>WATCH NOW</a>
                        </div>

                    </div>
                </div>";
    }

    private function createThumbnail() {
        $thumbnail = $this->video->getThumbnail();


        return "<img class='col-sm-12' src='$thumbnail' width:'100%'>";
    }

    private function createDetails($homepage) {
        $title = $this->video->getTitle();
        $username = $this->video->getUploadedBy();
        $description = $this->createDescription();
        $views = $this->video->getViews();
        $timestamp = $this->video->getTimeStamp();

        if($homepage == false) {
            return "<div class='pr-1 pl-1'>
                        <h6 class=''>$title</h6>
                        <div class=''>
                            <span class=''>$username</span>
                            <span class='d-flex justify-content-end'>$views views</span>
                        </div>
                    </div>";
        }


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
