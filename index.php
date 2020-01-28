<?php
require_once('include/header.php');
?>

<style media="screen">
.image-container {
  position: relative;
  width: 100%;
}

.image {
  opacity: 1;
  display: block;
  width: 100%;
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
}

.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}

.image-container:hover .image {
  opacity: 0.3;
}

.image-container:hover .middle {
  opacity: 1;
}

/* [1] The container */
.img-hover-zoom { /* [1.1] Set it as per your need */
  overflow: hidden; /* [1.2] Hide the overflowing of child elements */
}

/* [2] Transition property for smooth transformation of images */
.img-hover-zoom img {
  transition: transform .5s ease;
}

/* [3] Finally, transforming the image when container gets hovered */
.img-hover-zoom:hover img {
  transform: scale(1.15);
}

.languageHover {
    transition: transform 1s ease;
}

.languageHover:hover h5 {
    color: #f95;
    transform: scale(1.2);
}

</style>

<script type="text/javascript">


</script>


    <div class="container-fluid">
        <?php
        $videoGrid = new VideoGrid($con, $userLoggedInObj->getUsername());
        ?>



        <div class="container-fluid">
            <div class="row">
                <h3>View by categories</h4>
            </div>
            <div class="row mt-3">
                <?php
                echo "<div class='col-md-2 pr-3'>";
                echo $videoGrid->contentCategory();
                echo "</div>";

                echo "<div class='col-md-10' id='attraction' style='padding:0px;'>";
                echo $videoGrid->createAttraction(null, "Latest", false);
                echo "</div>"
                ?>
                <script type="text/javascript">
                    document.querySelector('.img-hover-zoom').querySelector('img').style.height = '';
                </script>
            </div>
        </div>
        <?php
        require_once("include/afterNav.php");
        ?>
     
        <?php
        echo $videoGrid->create(null, "Watch Amazing Videos", false, 0, "", 0, 6);
        echo "<br>";
        ?>
       
        <?php
        echo $videoGrid->createLatest(null, "Latest Release", false, 0);
        echo "<br>";
        ?>


    </div>


    <script type="text/javascript">

    </script>
<?php include('include/footer.php'); ?>
