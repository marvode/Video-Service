<?php
    require_once('include/header.php');
    require_once("include/afterNav.php");
    require_once('include/classes/VideoUploadForm.php');
    require_once('include/classes/AudioUploadForm.php');
    ?>

    <div class="row">
        <div class="col-md-8 mb-4">
            <h3>Upload Video</h3>
            <hr>
            <?php
            $formProvider = new VideoUploadForm($con, $userLoggedInObj);
            echo $formProvider->createUploadForm();
            ?>
        </div>

        <div class="col-md-4">
            <h3>Upload Music</h3>
            <hr>
            <?php
            $formProvider = new AudioUploadForm($con, $userLoggedInObj);
            echo $formProvider->createUploadForm();
            ?>
        </div>
    </div>

<?php include('include/footer.php'); ?>
