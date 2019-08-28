<?php
class VideoUploadForm {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function createUploadForm() {
        $fileInput = $this->createFileInput();
        $titleInput = $this->createTitleInput(null);
        $descriptionInput = $this->createDescriptionInput(null);
        $categoriesInput = $this->createCategoriesInput(null);
        $uploadButton = $this->createUploadButton();
        $amountInput = $this->createAmountInput();
        return "<form action='processing.php' method='POST' enctype='multipart/form-data'>
                    $fileInput
                    $titleInput
                    $descriptionInput
                    $categoriesInput
                    $amountInput
                    $uploadButton
                </form>";
    }

    private function createFileInput() {

        return "<div class='form-group'>
                    <label for='FormControlFile'><em>Only mp4 files less than 3 GB</em></label>
                    <input type='file' class='form-control-file' id='FormControlFile' name='fileInput' required>
                </div>";
    }

    private function createCategoriesInput($value) {
        if($value == null) $value = "";

        $query = $this->con->prepare("SELECT * FROM categories");
        $query->execute();

        $html = "<div class='form-group'>
                    <select class='form-control' name='categoryInput'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["id"];
            $name = $row["name"];
            $selected = ($id == $value) ? "selected='selected'" : "";

            $html .= "<option $selected value='$id'>$name</option>";
        }

        $html .= "</select>
                </div>";

        return $html;
    }

    public function createEditDetailsForm($video) {
        $titleInput = $this->createTitleInput($video->getTitle());
        $descriptionInput = $this->createDescriptionInput($video->getDescription());
        $categoriesInput = $this->createCategoriesInput($video->getCategory());
        $saveButton = $this->createSaveButton();
        return "<form method='POST'>
                    $titleInput
                    $descriptionInput
                    $categoriesInput
                    $saveButton
                </form>";
    }

    private function createTitleInput($value) {
        if($value == null) $value = "";
        return "<div class='form-group'>
                    <input class='form-control' type='text' placeholder='Title' name='titleInput' value='$value'>
                </div>";
    }

    private function createDescriptionInput($value) {
        if($value == null) $value = "";
        return "<div class='form-group'>
                    <textarea class='form-control' placeholder='Description' name='descriptionInput' rows='5'>$value</textarea>
                </div>";
    }

    private function createAmountInput() {
        return "<div class='form-group'>
                    <em>leave the field blank for free video</em>
                    <input class='form-control' placeholder='Cost of Video in Naira (eg. 50)' type='text' name='amountInput'>
                </div>";
    }

    private function createUploadButton() {
        return "<button type='submit' class='btn btn-primary' name='uploadButton'>Upload</button>";
    }

    private function createSaveButton() {
        return "<button type='submit' class='btn btn-primary' name='saveButton'>Save</button>";
    }
}
?>
