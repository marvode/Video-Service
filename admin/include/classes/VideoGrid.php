<?php
class VideoGrid {
    private $con, $userLoggedInObj;
    private $largeMode = false;
    private $gridClass = "row";

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }


    public function createFeatureSelect($title, $start_from, $record_per_page) {
        $query = $this->con->prepare("SELECT * FROM videos ORDER BY id DESC");
        $query->execute();
        $total_records = $query->rowCount();
        $total_pages = ceil($total_records/$record_per_page);

        $elementsHtml = "<div class='row d-flex justify-content-center pt-5'><ul class='pagination'>";
        for($i = 1; $i <= $total_pages; $i++) {
            $elementsHtml .= ButtonProvider::createPaginationButton($i);
        }
        $elementsHtml .= "</ul></div>";

        $gridItems = $this->generateFeatureSelect($start_from, $record_per_page);

        return "<h5>$title</h5>
                <div class='col-md-12'>
                    <div class='row' id='pagination-data'>
                        $gridItems
                    </div>
                    $elementsHtml
                </div>
                <hr>";
    }

    public function generateFeatureSelect($start_from, $record_per_page) {
        $query = $this->con->prepare("SELECT * FROM videos ORDER BY id DESC LIMIT :start_from, :record_per_page");
        $query->bindParam(":start_from", $start_from, PDO::PARAM_INT);
        $query->bindParam(":record_per_page", $record_per_page, PDO::PARAM_INT);
        $query->execute();

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            $item = new VideoGridItem($video, $this->largeMode, $this->con);
            $elementsHtml .= $item->createFeatureSelect($this->largeMode);
        }

        // $query = $this->con->prepare("SELECT * FROM videos ORDER BY id DESC");
        // $query->execute();
        // $total_records = $query->rowCount();
        // $total_pages = ceil($total_records/$record_per_page);
        //
        // $elementsHtml .= "<div class='row d-flex justify-content-center'><ul class='pagination'>";
        // for($i = 1; $i <= $total_pages; $i++) {
        //     $elementsHtml .= ButtonProvider::createPaginationButton($i);
        // }
        // $elementsHtml .= "</ul></div>";
        return $elementsHtml;
    }
}
?>
