<?php
class AudioSearch {
    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function getAudio($term, $start_from, $record_per_page) {
        $query = $this->con->prepare("SELECT * FROM audio WHERE title LIKE CONCAT('%', :term, '%')
                                    OR uploadedBy LIKE CONCAT('%', :term, '%') OR genre LIKE CONCAT('%', :term, '%') OR language LIKE CONCAT('%', :term, '%') ORDER BY id DESC");
        $query->bindParam(":term", $term);
        $query->execute();

        $videos = array();

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Audio($this->con, $row, $this->userLoggedInObj);
            array_push($videos, $video);
        }

        return $videos;
    }
}
?>
