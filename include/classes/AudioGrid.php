<?php
class AudioGrid {
    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create($videos, $title, $showFilter) {
        if($videos == null) {
            $gridItems = $this->generateItems();
        }
        else {
            $gridItems = $this->generateItemsFromVideos($videos);
        }
        $header = "";

        if($title != null) {
            $header = $this->createGridHeader($title, $showFilter);
        }

        //returns the main container in the homepage
        return "<h5>$header</h5>
                <div class='col-lg-12'>
                    <div class='container-fluid'>
                        <div class='row'>
                            $gridItems
                        </div>
                    </div>
                </div>

                <hr>";
    }

    public function generateItems() {
        $query = $this->con->prepare("SELECT * FROM audio ORDER BY id DESC LIMIT 10");
        $query->execute();

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $audio = new Audio($this->con, $row, $this->userLoggedInObj);
            $item = new AudioItem($audio);
            $elementsHtml .= $item->create();
        }

        return $elementsHtml;
    }

    public function createGridHeader($title, $showFilter) {
        $filter = "";

        if($showFilter) {
            $link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            $urlArray = parse_url($link);
            $query = $urlArray["query"];

            parse_str($query, $params);

            unset($params["orderBy"]);

            $newQuery = http_build_query($params);

            $newUrl = basename($_SERVER["PHP_SELF"]) . "?" . $newQuery;

            $filter = "<div class='right'>
                            <span>Ordey by:</span>
                            <a href='$newUrl&orderBy=uploadDate'>Upload date</a>
                            <a href='$newUrl&orderBy=views'>Most viewed</a>
                        </div>";
        }

        return "<div class=''>
                    <div class='text-light'>
                        $title
                    </div>
                    $filter
                </div>";
    }
}
?>
