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

<style media="screen">
h6 {
 width: 190px;
 white-space: nowrap;
 overflow: hidden;
 text-overflow: ellipsis;
}

</style>


    <div class="">
        <?php
        $videoGrid = new VideoGrid($con, $userLoggedInObj->getUsername());

        echo $videoGrid->create(null, "Watch Amazing Videos", false);
        ?>
    </div>

<?php include('include/footer.php'); ?>
