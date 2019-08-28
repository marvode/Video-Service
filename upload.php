<?php
    include('include/header.php');
    require_once("include/afterNav.php");
    require_once('include/classes/VideoUploadForm.php');
    ?>

    <div class="row">
        <div class="col-md-9">
            <h3>Upload a new Video</h3>
            <hr>
            <?php
            $formProvider = new VideoUploadForm($con);
            echo $formProvider->createUploadForm();
            ?>
        </div>

    </div>

<?php include('include/footer.php'); ?>
