<?php
require_once("include/classes/VideoInfoControls.php");

class VideoInfoSection {
    private $con, $video, $userLoggedInObj;

    public function __construct($con, $video, $userLoggedInObj) {
        $this->con = $con;
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create() {
        return $this->createPrimaryInfo() . $this->createSecondaryInfo(). "<hr>";
    }

    private function createPrimaryInfo() {
        $title = $this->video->getTitle();
        $views = $this->video->getViews();

        // $videoInfoControls = new VideoInfoControls($this->video, $this->userLoggedInObj);
        // $controls = $videoInfoControls->create();

        return "<div class=''>
                    <br>
                    <h5>$title</h5>
                    <span class=''>$views views</span>
                    <hr>
                </div>";
    }

    private function createSecondaryInfo() {
        $description = $this->video->getDescription();
        $uploadDate = $this->video->getUploadDate();
        $uploadedBy = $this->video->getUploadedBy();
        $profileButton = ButtonProvider::createUserProfilePic($this->con, $uploadedBy);

        if($uploadedBy == $this->userLoggedInObj->getUsername() && false) {
            return "";
        }
        else {
            $userToObject = new User($this->con, $uploadedBy);
            $videoId = $this->video->getId();
            
        }

        return "<div class=''>
                    <div class='text-light'>
                        $uploadedBy
                        <div class=''>
                            <span class=''>Uploaded $uploadDate</span>
                        </div>
                       
                    </div>
                    <hr>
                    <div class=''>
                        <h5>Description</h5>
                        $description
                    </div>
                </div>";
    }
}
?>
