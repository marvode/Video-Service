<?php
class SearchResultsProvider {
    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function getVideos($term, $orderBy) {
        if($this->convertCategory($term)) {
            $term = $this->convertCategory($term);

            $query = $this->con->prepare("SELECT * FROM videos WHERE category=:term ORDER BY $orderBy DESC");
            $query->bindParam(":term", $term);
            $query->execute();

            $videos = array();

            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $video = new Video($this->con, $row, $this->userLoggedInObj);
                array_push($videos, $video);
            }

            return $videos;
        }
        $query = $this->con->prepare("SELECT * FROM videos WHERE title LIKE CONCAT('%', :term, '%')
                                    OR uploadedBy LIKE CONCAT('%', :term, '%') OR language LIKE CONCAT('%', :term, '%') ORDER BY $orderBy DESC");
        $query->bindParam(":term", $term);
        $query->execute();

        $videos = array();

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            array_push($videos, $video);
        }

        return $videos;
    }

    private function convertCategory($category) {
        $query = $this->con->prepare("SELECT * FROM categories WHERE name LIKE CONCAT('%', :category, '%')");
        $query->bindParam(":category", $category);

        $query->execute();

        if($query->rowCount() == 1) {
            $row = $query->fetch(PDO::FETCH_ASSOC);

            return $row["id"];
        }
        return false;
    }
}

?>
