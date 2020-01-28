<?php
class AudioUploadForm {
    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function createUploadForm() {
        $fileInput = $this->createFileInput();
        $titleInput = $this->createTitleInput(null);
        $descriptionInput = $this->createDescriptionInput(null);
        $categoriesInput = $this->createCategoriesInput(null);
        $uploadButton = $this->createUploadButton();
        $languageInput = $this->createLanguageInput();
        $thumbnail = $this->createThumbnailInput();
        return "<form action='musicprocessing.php' method='POST' enctype='multipart/form-data'>
                    $fileInput
                    $titleInput
                    $descriptionInput
                    $categoriesInput
                    $languageInput
                    $thumbnail
                    '<div class='d-flex justify-content-end'>
                        $uploadButton
                    </div>'
                </form>";
    }

    private function createFileInput() {

        return "<div class='form-group'>
                    <label for='FormControlFile'><em>Only mp3 files</em></label>
                    <input type='file' class='form-control-file' id='FormControlFile' name='musicFileInput' required>
                </div>";
    }

    private function createThumbnailInput() {

        return "<div class='form-group'>
                    <label>Music Cover Art</label>
                    <input type='file' class='form-control-file' name='musicPicInput' required>
                </div>";
    }

    private function createCategoriesInput($value) {
        if($value == null) $value = "";

        $query = $this->con->prepare("SELECT * FROM music_genre");
        $query->execute();

        $html = "<div class='form-group'>
                    <select class='form-control' name='genreInput'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["id"];
            $name = $row["genre"];
            $selected = ($id == $value) ? "selected='selected'" : "";

            $html .= "<option $selected value='$id'>$name</option>";
        }

        $html .= "</select>
                </div>";

        return $html;
    }

    private function createTitleInput($value) {
        if($value == null) $value = "";
        return "<div class='form-group'>
                    <input class='form-control' type='text' placeholder='Title' name='musicTitleInput' value='$value' required>
                </div>";
    }

    private function createDescriptionInput($value) {
        if($value == null) $value = "";
        return "<div class='form-group'>
                    <textarea class='form-control' placeholder='Description' name='musicDescriptionInput' rows='5' required>$value</textarea>
                </div>";
    }

    private function createLanguageInput() {
        return "<div class='form-group'>
                    <input class='form-control' type='text' placeholder='Language' name='musicLanguageInput' value='' required>
                </div>";
    }

    private function createUploadButton() {
        return "<button type='submit' class='btn btn-primary' name='musicUploadButton'>Upload</button>";
    }
}
