<?php
class VideoUploadData {

    public $videoDataArray, $title, $description, $category, $uploadedBy, $language, $content;

    public function __construct($videoDataArray, $title, $description, $category, $uploadedBy, $language, $content) {
        $this->videoDataArray = $videoDataArray;
        $this->title = $title;
        $this->description = $description;
        $this->category = $category;
        $this->uploadedBy = $uploadedBy;
        $this->language = $language;
        $this->content = $content;
    }

    public function updateDetails($con, $videoId) {
        $query = $con->prepare("UPDATE videos SET title=:title, description=:description, category=:category WHERE id=:videoId");
        $query->bindParam(":title", $this->title);
        $query->bindParam(":description", $this->description);
        $query->bindParam(":category", $this->category);
        $query->bindParam(":videoId", $videoId);

        return $query->execute();
    }
}
?>
