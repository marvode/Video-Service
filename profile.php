<?php
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/ProfileGenerator.php");
?>
<script src="assets/js/loadProfileVideos.js" charset="utf-8"></script>
<?php

if(isset($_GET["username"])) {
    $profileUsername = $_GET["username"];
}
else {
    echo "Channel not Found";
    exit();
}

echo "<div class='col-md-12' id='pagination_data'>";

echo "</div>";

?>
<script type="text/javascript">
    load_video_data("<?php echo $profileUsername; ?>", 1);
    $(document).on('click', '.pagination_link', function() {
        var page = $(this).attr('id');
        load_video_data("<?php echo $profileUsername; ?>", page);
    })
</script>

<?php

// $profileGenerator = new ProfileGenerator($con, $userLoggedInObj, $profileUsername);
// echo $profileGenerator->create();

require_once("include/footer.php")?>
