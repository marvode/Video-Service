<?php
class VideoHistory {
    private $con, $userLoggedIn, $videoId, $userLoggedInObj, $video;

    public function __construct($con, $video, $userLoggedInObj) {
        $this->con = $con;
        $this->video = $video;
        $this->userLoggedInObj = $userLoggedInObj;
        $this->videoId = $video->getId();
        $this->userLoggedIn = $userLoggedInObj->getUsername();
    }

    public function create() {
        $uploadedBy = $this->video->getUploadedBy();

        $query = $this->con->prepare("INSERT INTO video_history (videoId, uploadedBy, viewedBy) VALUES (:videoId, :uploadedBy, :userLoggedIn)");
        $query->bindParam(":videoId", $this->videoId);
        $query->bindParam(":uploadedBy", $uploadedBy);
        $query->bindParam(":userLoggedIn", $this->userLoggedIn);

        $query->execute();
    }

    public function alreadyWatched() {
        $query = $this->con->prepare("SELECT * FROM video_history WHERE videoId=:videoId AND viewedBy=:userLoggedIn");
        $query->bindParam(":videoId", $this->videoId);
        $query->bindParam(":userLoggedIn", $this->userLoggedIn);

        $query->execute();

        if($query->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
?>
