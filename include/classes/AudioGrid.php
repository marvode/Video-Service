<?php
class AudioGrid {
    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create($audio, $title, $start_from, $record_per_page) {
        $gridItems = $this->generateItems($start_from, $record_per_page);

        $query = $this->con->prepare("SELECT * FROM audio");
        $query->execute();
        $total_records = $query->rowCount();
        $total_pages = ceil($total_records/$record_per_page);

        $elementsHtml = "<div class='row d-flex justify-content-center pt-5'><ul class='pagination'>";
        if($total_pages > 1) {
            for($i = 1; $i <= $total_pages; $i++) {
                $elementsHtml .= ButtonProvider::createPaginationButton($i);
            }
        }
        $elementsHtml .= "</ul></div>";
        //returns the main container in the homepage
        return "<h5>$title</h5>
                <div class='col-md-12'>
                    <div class='container-fluid'>
                        <div class='row'>
                            $gridItems
                        </div>
                        $elementsHtml
                    </div>
                </div>

                <hr>";
    }

    public function generateItems($start_from, $record_per_page) {
        $query = $this->con->prepare("SELECT * FROM audio ORDER BY id DESC LIMIT :start_from, :record_per_page");
        $query->bindParam(":start_from", $start_from, PDO::PARAM_INT);
        $query->bindParam(":record_per_page", $record_per_page, PDO::PARAM_INT);
        $query->execute();

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $audio = new Audio($this->con, $row, $this->userLoggedInObj);
            $item = new AudioItem($audio);
            $elementsHtml .= $item->create();
        }

        return $elementsHtml;
    }

    public function generateItemsFromAudio($audio, $title, $start_from, $record_per_page) {
        $total_records = count($audio);

        $total_pages = ceil($total_records/$record_per_page);

        $elementsHtml = "<div class='row d-flex justify-content-center pt-5'><ul class='pagination'>";
        if($total_pages > 1) {
            for($i = 1; $i <= $total_pages; $i++) {
                $elementsHtml .= ButtonProvider::createPaginationButton($i);
            }
        }
        $elementsHtml .= "</ul></div>";

        $gridItem = "";

        for ($i=$start_from; $i < ($start_from + $record_per_page) && $i < count($audio); $i++) {
            $item = new AudioItem($audio[$i]);
            $gridItem .= $item->create();
        }

        return "<h4>$title</h4><hr>
                <div class='col-md-12'>
                    <div class='container-fluid'>
                        <div class=''>
                            $gridItem
                        </div>
                        $elementsHtml
                    </div>
                </div>

                <hr>";
    }
}
?>
