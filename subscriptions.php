<?php require_once("include/header.php");
require_once("include/afterNav.php");

if(!User::isLoggedIn()) {
    header("Location: sign_in.php");
}

?>
<script src="assets/js/loadSubscriptions.js" charset="utf-8"></script>

<div id="pagination_data"></div>

<script>
    load_subscription_data(1);
    $(document).on('click', '.pagination_link', function() {
        var page = $(this).attr('id');
        load_subscription_data(page);
    })
</script>
<?php require_once("include/footer.php"); ?>
