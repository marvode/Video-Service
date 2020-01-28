<?php
class VideoGrid {
    private $con, $userLoggedInObj;
    private $largeMode = false;
    private $gridClass = "row";

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create($videos, $title, $showFilter, $contentType, $user, $start_from, $record_per_page) {
        $elementsHtml = "";
        if($videos == null) {
            $gridItems = $this->generateItems($contentType);
        }
        else if($user != "") {
            $query = $this->con->prepare("SELECT * FROM videos WHERE uploadedBy=:user ORDER BY id DESC");
            $query->bindParam(":user", $user);
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

            $gridItems = $this->generateVideosFromUser($user, $start_from, $record_per_page);
        }
        else {
            $total_records = count($videos);
            $total_pages = ceil($total_records/$record_per_page);

            $elementsHtml = "<div class='row d-flex justify-content-center pt-5'><ul class='pagination'>";
            if($total_pages > 1) {
                for($i = 1; $i <= $total_pages; $i++) {
                    $elementsHtml .= ButtonProvider::createPaginationButton($i);
                }
            }
            $elementsHtml .= "</ul></div>";

            $gridItems = $this->generateItemsFromVideos($videos, $start_from, $record_per_page);
        }
        $header = "";

        if($title != null) {
            $header = $this->createGridHeader($title, $showFilter);
        }

        //returns the main container in the homepage
        return "<h5>$header</h5>
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

    public function createSubscriptions($videos, $title, $showFilter, $start_from, $record_per_page) {
        $total_records = count($videos);
        $total_pages = ceil($total_records/$record_per_page);

        $elementsHtml = "<div class='row d-flex justify-content-center pt-5'><ul class='pagination'>";
        if($total_pages > 1) {
            for($i = 1; $i <= $total_pages; $i++) {
                $elementsHtml .= ButtonProvider::createPaginationButton($i);
            }
        }
        $elementsHtml .= "</ul></div>";

        $gridItems = $this->generateItemsFromVideos($videos, $start_from, $record_per_page);
        $header = $this->createGridHeader($title, $showFilter);

        return "<h5>$header</h5>
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
                <div class='col-md-12'>
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
                <div class='col-md-12'>
                    <div class='container-fluid'>
                        <div class=''>
                            $gridItems
                        </div>
                    </div>
                </div>

                <hr>";
    }

    public function createFilter($category, $start_from, $record_per_page) {
        $gridItems = $this->generateFilterItems($category, $start_from, $record_per_page);

        $query = $this->con->prepare("SELECT * FROM videos WHERE category=:category");
        $query->bindParam(":category", $category);
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

        return "<div class='col-md-12'>
                    <div class='container-fluid'>
                        <div class='row'>
                            $gridItems
                        </div>
                        $elementsHtml
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
        $query = $this->con->prepare("SELECT * FROM videos WHERE featureVideo=1 ORDER BY RAND() LIMIT 1");
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
        $query = $this->con->prepare("SELECT * FROM videos WHERE contentType=:contentType ORDER BY id DESC LIMIT :noOfItems");
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

    public function generateVideosFromUser($user, $start_from, $record_per_page) {
        $query = $this->con->prepare("SELECT * FROM videos WHERE uploadedBy=:user ORDER BY id DESC LIMIT :start_from, :record_per_page");
        $query->bindParam(":start_from", $start_from, PDO::PARAM_INT);
        $query->bindParam(":record_per_page", $record_per_page, PDO::PARAM_INT);
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
        $query = $this->con->prepare("SELECT * FROM videos WHERE contentType=:contentType ORDER BY id DESC LIMIT 8");
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

    public function generateFilterItems($category, $start_from, $record_per_page) {
        $query = $this->con->prepare("SELECT * FROM videos WHERE category=:category ORDER BY id DESC LIMIT :start_from, :record_per_page");
        $query->bindParam(":category", $category);
        $query->bindParam(":start_from", $start_from, PDO::PARAM_INT);
        $query->bindParam(":record_per_page", $record_per_page, PDO::PARAM_INT);
        $query->execute();

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->createLatest($this->largeMode);
        }

        return $elementsHtml;
    }

    public function generateItemsFromVideos($videos, $start_from, $record_per_page) {
        $elementsHtml = "";

        for ($i=$start_from; $i < ($start_from + $record_per_page) && $i < count($videos); $i++) {
            $item = new VideoGridItem($videos[$i], $this->largeMode);
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
                    <div class=''>
                        $title
                    </div>
                    $filter
                </div>";
    }

    public function createLarge($videos, $title, $showFilter, $start_from, $record_per_page) {
        $this->gridClass .= " large";
        $this->largeMode = true;
        return $this->create($videos, $title, $showFilter, 1, "", $start_from, $record_per_page);
    }

    public function contentCategory() {
        $request = "SELECT DISTINCT name FROM categories";
        $query = $this->con->prepare($request);
        $query->execute();

        $categories = "<div class='row d-flex justify-content-center'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $row = $row['name'];
            $categories .= "<a class='square_btn btn btn-red align-self-center  col-md-12' href='filter.php?category=$row' style='margin-bottom: 1px;'>$row</a>";
        }
        $categories .= "</div>";
        return $categories;
    }

    public function languageVideos($category, $language, $start_from, $record_per_page) {
        $query = $this->con->prepare("SELECT * FROM videos WHERE category=:category AND language=:language ORDER  BY id DESC LIMIT :start_from, :record_per_page");
        $query->bindParam(":category", $category);
        $query->bindParam(":language", $language);
        $query->bindParam(":start_from", $start_from, PDO::PARAM_INT);
        $query->bindParam(":record_per_page", $record_per_page, PDO::PARAM_INT);
        $query->execute();

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            $item = new VideoGridItem($video, $this->largeMode);
            $elementsHtml .= $item->createLatest($this->largeMode);
        }

        $query = $this->con->prepare("SELECT * FROM videos WHERE category=:category AND language=:language");
        $query->bindParam(":category", $category);
        $query->bindParam(":language", $language);
        $query->execute();
        $total_records = $query->rowCount();
        $total_pages = ceil($total_records/$record_per_page);

        $elementsHtml .= "<div class='row d-flex justify-content-center pt-5'><ul class='pagination'>";
        if($total_pages > 1) {
            for($i = 1; $i <= $total_pages; $i++) {
                $elementsHtml .= ButtonProvider::createPaginationButton($i);
            }
        }
        $elementsHtml .= "</ul></div>";

        return $elementsHtml;
    }

    public function languageCategory($category) {
        $query = $this->con->prepare("SELECT DISTINCT language FROM videos WHERE category=:category");
        $query->bindParam(":category", $category);
        $query->execute();

        $categories = "<div class='row d-flex justify-content-center'><h5> Available in the Following languages:</h5>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $row = $row['language'];
            $categories .= "<a class='languageHover align-self-center  col-md-1 col-md-2' href='filter.php?language=$row&category=$category' style='text-decoration: none;'><h5> $row </h5></a>";
        }
        $categories .= "</div>";
        return $categories;
    }
}
?>
