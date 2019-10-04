<?php
class AudioItem {
    private $audio;


    public function __construct($audio) {
        $this->audio = $audio;
    }

    public function create() {
        $thumbnail = $this->createThumbnail();
        $details = $this->createDetails();
        $audioPath = $this->audio->getFilePath();
        $title = $this->audio->getTitle();

        return "<div style='border: 1px solid black; border-radius: 1.5em;' class='col-md-6 offset-md-3 p-4 mb-3'>
                    <h3><em>Title:</em> $title</h3>
                    <div class='thumbnail'>$thumbnail</div>
                    <div class='p-1'>$details</div>
                    <div>
                        <audio controls>
                            <source src='$audioPath' type='audio/mp3'>
                        </audio>
                    </div>
                </div>";
    }

    private function createThumbnail() {
        $thumbnail = $this->audio->getThumbnail();


        return "<img class='img-fluid' src='$thumbnail' width:'80%'>";
    }

    private function createDetails() {

        $username = $this->audio->getUploadedBy();
        $description = $this->createDescription();

        return "<div class='pr-1 pl-1'>
                    <span class=''>Uploaded by $username</span>
                    <div class=''>
                        <span class=''></span>
                    </div>
                    $description
                </div>";
    }

    private function createDescription() {
        $description = $this->audio->getDescription();
        return "<span class='description'>$description</span>";
    }
}
?>
