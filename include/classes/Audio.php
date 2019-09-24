<?php
class Audio {
    private $con, $sqlData, $userLoggedInObj;

    public function __construct($con, $input, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;

        if(is_array($input)) {
            $this->sqlData = $input;
        }
        else {
            $query = $this->con->prepare("SELECT * FROM audio WHERE id=:id");
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

    public function getThumbnail() {
        return $this->sqlData["picPath"];
    }

    public function getUploadedBy() {
        return $this->sqlData["uploadedBy"];
    }

    public function getFilePath() {
        return $this->sqlData["filePath"];
    }
    public function getGenre() {
        return $this->sqlData["genre"];
    }

    public function getLanguage() {
        return $this->sqlData["language"];
    }

    public function getUploadDate() {
        $date = $this->sqlData["uploadDate"];
        return date("M j, Y", strtotime($uploadDate));
    }

    public function getListens() {
        return $this->sqlData["listens"];
    }

    public function incrementListenss() {
        $query = $this->con->prepare("UPDATE audio SET listens=listens+1 WHERE id=:id");
        $query->bindParam(":id", $videoId);
        $videoId = $this->getId();

        $query->execute();

        $this->sqlData["listens"] = $this->sqlData["listens"] + 1;
    }
}




?>
