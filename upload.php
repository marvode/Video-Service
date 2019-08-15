<?php
    include('include/header.php');
    require_once('include/classes/VideoUploadForm.php');
    ?>

    <div class="row">
        <div class="col-md-9">
            <?php
            $formProvider = new VideoUploadForm();
            echo $formProvider->createUploadForm();
            ?>
        </div>

    </div>

<?php include('include/footer.php'); ?>
