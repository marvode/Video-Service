<?php
class VideoUploadForm {

    public function createUploadForm() {
        $fileInput = $this->createFileInput();
        $titleInput = $this->createTitleInput();
        $descriptionInput = $this->createDescriptionInput();
        $uploadButton = $this->createUploadButton();
        return "<form action='processing.php' method='POST' enctype='multipart/form-data'>
                    $fileInput
                    $titleInput
                    $descriptionInput
                    $uploadButton
                </form>";
    }

    private function createFileInput() {

        return "<div class='form-group'>
                    <label for='FormControlFile'>Your file</label>
                    <input type='file' class='form-control-file' id='FormControlFile' name='fileInput' required>
                </div>";
    }

    private function createTitleInput() {
        return "<div class='form-group'>
                    <input class='form-control' type='text' placeholder='Title' name='titleInput'>
                </div>";
    }

    private function createDescriptionInput() {
        return "<div class='form-group'>
                    <textarea class='form-control' placeholder='Description' name='descriptionInput' rows='5'></textarea>
                </div>";
    }

    private function createUploadButton() {
        return "<button type='submit' class='btn btn-secondary' name='uploadButton'>Upload</button>";
    }
}
?>
