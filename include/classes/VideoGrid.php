<?php
class VideoGrid {
    private $con, $userLoggedInObj;
    private $largeMode = false;
    private $gridClass = "row";

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
                        <div class='$this->gridClass'>
                            $gridItems
                        </div>
                    </div>
                </div>

                <hr>";
    }

    public function createSuggestions($videos, $title, $showFilter) {
        if($videos == null) {
            $gridItems = $this->generateSuggestionsItems();
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
                        <div class=''>
                            $gridItems
                        </div>
                    </div>
                </div>

                <hr>";
    }

    public function createAttraction($videos, $title, $showFilter) {
        if($videos == null) {
            $gridItems = $this->generateAttractionItem();
        }
        else {
            $gridItems = $this->generateItemsFromVideos($videos);
        }
        $header = "";

        if($title != null) {
            $header = $this->createGridHeader($title, $showFilter);
        }
        return "<h5></h5>
                <div class='pt-2 col-sm-12'>
                    <div class='container-fluid'>
                        <div>
                        $gridItems
                        </div>
                    </div>
                </div>";
    }

    public function generateAttractionItem() {
        $query = $this->con->prepare("SELECT * FROM videos ORDER BY RAND() LIMIT 1");
        $query->execute();

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->createAttractionItem($this->largeMode);
        }

        return $elementsHtml;
    }

    public function generateItems() {
        $query = $this->con->prepare("SELECT * FROM videos ORDER BY RAND() LIMIT 15");
        $query->execute();

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create($this->largeMode);
        }

        return $elementsHtml;
    }

    public function generateSuggestionsItems() {
        $query = $this->con->prepare("SELECT * FROM videos ORDER BY RAND() LIMIT 15");
        $query->execute();

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->createSuggestions($this->largeMode);
        }

        return $elementsHtml;
    }

    public function generateItemsFromVideos($videos) {
        $elementsHtml = "";

        foreach($videos as $video) {
            $item = new VideoGridItem($video, $this->largeMode);
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

    public function createLarge($videos, $title, $showFilter) {
        $this->gridClass .= " large";
        $this->largeMode = true;
        return $this->create($videos, $title, $showFilter);
    }
}
?>
