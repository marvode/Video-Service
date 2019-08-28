<?php
require_once('include/header.php');
?>
<!-- <script type="text/javascript">
    function truncateText(selector, maxLength) {
        var element = document.querySelector(selector),
            truncated = element.innerText;

        if (truncated.length > maxLength) {
            truncated = truncated.substr(0,maxLength) + '...';
        }
        return truncated;
    }
    $('h6').text() = truncateText('h6', 20);
</script> -->
<!-- <style media="screen">
h6 {
 width: 190px;
 white-space: nowrap;
 overflow: hidden;
 text-overflow: ellipsis;
}

</style> -->
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

.text {
  background-color: #32a0a8;
  color: white;
  font-size: 16px;
  padding: 16px 32px;
}
.mousehover:hover {
    color: #14decd;
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
</style>


    <div class="">
        <?php
        $attraction = new VideoGrid($con, $userLoggedInObj->getUsername());
        $videoGrid = new VideoGrid($con, $userLoggedInObj->getUsername());
        $videoGrid2 = new VideoGrid($con, $userLoggedInObj->getUsername());
        $videoGrid3 = new VideoGrid($con, $userLoggedInObj->getUsername());
        $videoGrid4 = new VideoGrid($con, $userLoggedInObj->getUsername());
        echo $attraction->createAttraction(null, "Latest", false);
        echo "<br>";
        require_once("include/afterNav.php");
        echo $videoGrid->create(null, "Watch Amazing Videos", false);
        echo "<br>";
        echo $videoGrid2->create(null, "Latest Release", false);
        echo "<br>";
        echo $videoGrid3->create(null, "Hot Right Now", false);
        echo "<br>";
        echo $videoGrid4->create(null, "Must Watch", false);
        echo "<br>";
        ?>
    </div>

    <script type="text/javascript">

    </script>
<?php include('include/footer.php'); ?>
