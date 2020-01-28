<?php
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/SearchResultsProvider.php");
?>
<script src="assets/js/loadSearch.js" charset="utf-8"></script>
<?php
if(!isset($_GET["search"]) || $_GET["search"] == "") {
    echo "You must enter a search term";
    require_once("include/footer.php");
    exit();
}

$term = $_GET["search"];

if(!isset($_GET["orderBy"]) || $_GET["orderBy"] == "views") {
    $orderBy = "views";
}
else {
    $orderBy = "uploadDate";
}
?>


<div id="pagination_data">

</div>

<script type="text/javascript">
    load_search_video_data("<?php echo $term; ?>", "<?php echo $orderBy; ?>", 1);
    $(document).on('click', '.pagination_link', function() {
        var page = $(this).attr('id');
        load_search_video_data("<?php echo $term; ?>", "<?php echo $orderBy; ?>", page);
    })
</script>
<?php require_once("include/footer.php"); ?>
