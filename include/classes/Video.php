<?php
class Video {
    private $con, $sqlData, $userLoggedInObj;

    public function __construct($con, $input, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

        if(is_array($input)) {
            $this->sqlData = $input;
        }
        else {
            $query = $this->con->prepare("SELECT * FROM videos WHERE id=:id");
            $query->bindParam(":id", $input);
            $query->execute();

            $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function getId() {
        return $this->sqlData["id"];
    }

    public function getTitle() {
        return $this->sqlData["title"];
    }

    public function getDescription() {
        return $this->sqlData["description"];
    }

    public function getUploadedBy() {
        return $this->sqlData["uploadedBy"];
    }

    public function getFilePath() {
        return $this->sqlData["filePath"];
    }
    public function getCategory() {
        return $this->sqlData["category"];
    }

    public function getUploadDate() {
        $date = $this->sqlData["uploadDate"];
        return date("M j, Y", strtotime($date));
    }

    public function getTimeStamp() {
        $date = $this->sqlData["uploadDate"];
        return date("M jS, Y", strtotime($date));
    }

    public function getViews() {
        return $this->sqlData["views"];
    }

    public function getDuration() {
        return $this->sqlData["duration"];
    }

    public function getThumbnail() {
        $query = $this->con->prepare("SELECT filePath FROM thumbnails WHERE videoId=:videoId AND selected=1");
        $query->bindParam(":videoId", $videoId);
        $videoId = $this->getId();

        $query->execute();

        return $query->fetchColumn();
    }

    public function incrementViews() {
        $query = $this->con->prepare("UPDATE videos SET views=views+1 WHERE id=:id");
        $query->bindParam(":id", $videoId);
        $videoId = $this->getId();

        $query->execute();

        $this->sqlData["views"] = $this->sqlData["views"] + 1;
    }
}




?>
