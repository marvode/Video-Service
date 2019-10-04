<?php require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/Audio.php");
require_once("include/classes/AudioItem.php");
require_once("include/classes/AudioGrid.php");
?>

<script src="assets/js/loadAudio.js" charset="utf-8"></script>

<div id="pagination_data"></div>

<script>
    load_audio_data(1);
    $(document).on('click', '.pagination_link', function() {
        var page = $(this).attr('id');
        load_audio_data(page);
    })
</script>

<?php require_once("include/footer.php") ?>
