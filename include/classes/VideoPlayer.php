<?php
class VideoPlayer {
    private $video;

    public function __construct($video, $userLoggedInObj) {
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create($autoPlay) {
        if($autoPlay) {
            $autoPlay = "autoplay";
        }
        else {
            $autoPlay = "";
        }

        $filePath = $this->video->getFilePath();

        return "<video class='col-sm-12' controls controlsList='nodownload' $autoPlay>
                    <source src='$filePath' type='video/mp4'>
                </video>";
    }
}
?>
