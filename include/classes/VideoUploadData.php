<?php
class VideoUploadData {

    public $videoDataArray, $title, $description, $uploadedBy;

    public function __construct($videoDataArray, $title, $description, $uploadedBy) {
        $this->videoDataArray = $videoDataArray;
        $this->title = $title;
        $this->description = $description;
        $this->uploadedBy = $uploadedBy;
    }

}
?>
