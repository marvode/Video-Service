<?php
class AudioProcessor {

    private $con;
    private $allowedTypes = array("mp3");

    public function __construct($con) {
        $this->con = $con;
    }

    public function upload($audioUploadData) {
        $targetDir = "uploads/audio/";
        $picTargetDir = "uploads/audio/pic/";
        $audioData = $audioUploadData->audioDataArray;
        $pic = $audioUploadData->picDataArray;

        $tempFilePath = $targetDir . basename($audioData["name"]);
        $tempFilePath = str_replace(" ", "_", $tempFilePath);

        $picPath = $picTargetDir . basename($pic["name"]);
        $picPath = str_replace(" ", "_", $picPath);

        $isValidData = $this->processData($audioData, $tempFilePath, $picPath);

        if(!$isValidData) {
            return false;
        }

        if(move_uploaded_file($audioData["tmp_name"], $tempFilePath)) {

            $finalFilePath = $targetDir . basename($audioData["name"]);
            $finalFilePath = str_replace(" ", "_", $finalFilePath);

            if(move_uploaded_file($pic["tmp_name"], $picPath)) {
                $finalPicPath = $picTargetDir . basename($pic["name"]);
                $finalPicPath = str_replace(" ", "_", $finalPicPath);

                if(!$this->insertAudioData($audioUploadData, $finalFilePath, $finalPicPath)) {
                    echo "Upload failed";
                    return false;
                }
            }
        }

        return true;
    }

    private function processData($audioData, $filePath, $picPath) {
        $audioType = pathInfo($filePath, PATHINFO_EXTENSION);
        $picType = pathInfo($picPath, PATHINFO_EXTENSION);

        if(!$this->isValidType($audioType)) {
            echo "Invalid file type";
            return false;
        }
        else if(!$this->isValidPic($picType)) {
            echo "Invalid file picture type";
            return false;
        }
        else if($this->hasError($audioData)) {
            echo "Error code: " . $audioData["error"];
            return false;
        }

        return true;
    }

    private function isValidPic($picType) {
        $allowedPicTypes = array("jpg", "jpeg", "png");
        $lowercase = strtolower($picType);

        return in_array($lowercase, $allowedPicTypes);
    }

    private function isValidType($type) {
        $lowercased = strtolower($type);
        return in_array($lowercased, $this->allowedTypes);
    }

    private function hasError($data) {
        return $data["error"] != 0;
    }

    private function insertAudioData($uploadData, $filePath, $picPath) {
        $query = $this->con->prepare("INSERT INTO audio(title, uploadedBy, description, genre, filePath, language, picPath)
                                        VALUES(:title, :uploadedBy, :description, :genre, :filePath, :language, :picPath)");

        $query->bindParam(":title", $uploadData->title);
        $query->bindParam(":uploadedBy", $uploadData->uploadedBy);
        $query->bindParam(":description", $uploadData->description);
        $query->bindParam(":genre", $uploadData->genre);
        $query->bindParam(":filePath", $filePath);
        $query->bindParam(":picPath", $picPath);
        $query->bindParam(":language", $uploadData->language);

        return $query->execute();
    }
}
?>
