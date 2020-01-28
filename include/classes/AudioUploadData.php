<?php
class AudioUploadData {

    public $audioDataArray, $title, $description, $category, $uploadedBy, $language;

    public function __construct($audioDataArray, $title, $description, $genre, $uploadedBy, $language, $picDataArray) {
        $this->audioDataArray = $audioDataArray;
        $this->title = $title;
        $this->description = $description;
        $this->genre = $genre;
        $this->uploadedBy = $uploadedBy;
        $this->language = $language;
        $this->picDataArray = $picDataArray;
    }
}
?>
