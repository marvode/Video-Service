<?php
class VideoGrid {
    private $con, $userLoggedInObj;
    private $largeMode = false;
    private $gridClass = "row";

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create($videos, $title, $showFilter, $contentType, $user) {
        if($videos == null) {
            $gridItems = $this->generateItems($contentType);
        }
        else if($user != "") {
            $gridItems = $this->generateVideosFromUser($user);
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

    public function createSubscriptions($videos, $title, $showFilter) {
        $gridItems = $this->generateItemsFromVideos($videos);
        $header = $this->createGridHeader($title, $showFilter);

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

    public function createLatest($videos, $title, $showFilter, $contentType) {
        if($videos == null) {
            $gridItems = $this->generateLatestItems($contentType);
        }
        else {
            $gridItems = $this->generateLatestItemsFromVideos($videos);
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

    public function createFilter($videos, $title, $showFilter, $contentType) {
        if($videos == null) {
            $gridItems = $this->generateFilterItems($title, $contentType);
        }

        return "<div class='col-lg-12'>
                    <div class='container-fluid'>
                        <div class='row'>
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
        return "<div class='container-fluid'>
                    <div>
                        $gridItems
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

    public function generateItems($contentType) {
        $query = $this->con->prepare("SELECT * FROM videos WHERE contentType=:contentType ORDER BY RAND() LIMIT 6");
        $query->bindParam(":contentType", $contentType, PDO::PARAM_INT);
        $query->execute();

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create($this->largeMode);
        }

        return $elementsHtml;
    }

    public function generateItemsNew($noOfItems, $contentType) {
        $query = $this->con->prepare("SELECT * FROM videos WHERE contentType=:contentType ORDER BY RAND() LIMIT :noOfItems");
        $noOfItems = (int)$noOfItems;
        $query->bindParam(":noOfItems", $noOfItems, PDO::PARAM_INT);
        $query->bindParam(":contentType", $contentType, PDO::PARAM_INT);
        $query->execute();

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create($this->largeMode);
        }

        return $elementsHtml;
    }

    public function generateVideosFromUser($user) {
        $query = $this->con->prepare("SELECT * FROM videos WHERE uploadedBy=:user ORDER BY id DESC");
        $query->bindParam(":user", $user);
        $query->execute();

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create($this->largeMode);
        }

        return $elementsHtml;
    }

    public function generateLatestItems($contentType) {
        $query = $this->con->prepare("SELECT * FROM videos WHERE contentType=:contentType ORDER BY RAND() LIMIT 8");
        $query->bindParam(":contentType", $contentType, PDO::PARAM_INT);
        $query->execute();

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->createLatest($this->largeMode);
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

    public function generateFilterItems($category, $contentType) {
        $query = $this->con->prepare("SELECT * FROM videos WHERE contentType=:contentType AND category=:category ORDER BY RAND() LIMIT 15");
        $query->bindParam(":contentType", $contentType, PDO::PARAM_INT);
        $query->bindParam(":category", $category);
        $query->execute();

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->createLatest($this->largeMode);
        }

        return $elementsHtml;
    }

    public function generateItemsFromVideos($videos) {
        $elementsHtml = "";

        foreach($videos as $video) {
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->create($this->largeMode);
        }

        return $elementsHtml;
    }

    public function generateLatestItemsFromVideos($videos) {
        $elementsHtml = "";

        foreach($videos as $video) {
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->createLatest($this->largeMode);
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

    public function contentCategory() {
        $request = "SELECT DISTINCT name FROM categories";
        $query = $this->con->prepare($request);
        $query->execute();

        $categories = "<div class='row d-flex justify-content-center'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $row = $row['name'];
            $categories .= "<a class='btn btn-red align-self-center text-light col-lg-12' href='filter.php?category=$row' style='background-color: #000; border-radius: 0px; margin-bottom: 1px;'>$row</a>";
        }
        $categories .= "</div>";
        return $categories;
    }

    public function languageVideos($category, $language, $contentType) {
        $query = $this->con->prepare("SELECT * FROM videos WHERE category=:category AND contentType=:contentType AND language=:language");
        $query->bindParam(":category", $category);
        $query->bindParam(":language", $language);
        $query->bindParam(":contentType", $contentType);
        $query->execute();

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->createLatest($this->largeMode);
        }

        return $elementsHtml;
    }

    public function languageCategory($category, $contentType) {
        $query = $this->con->prepare("SELECT DISTINCT language FROM videos WHERE category=:category AND contentType=:contentType");
        $query->bindParam(":category", $category);
        $query->bindParam(":contentType", $contentType);
        $query->execute();

        $categories = "<div class='row d-flex justify-content-center'><h5> Available in the Following languages:</h5>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $row = $row['language'];
            $categories .= "<a class='languageHover align-self-center text-light col-lg-1 col-md-2' href='filter.php?language=$row&category=$category' style='text-decoration: none;'><h5> $row </h5></a>";
        }
        $categories .= "</div>";
        return $categories;
    }
}
?>
