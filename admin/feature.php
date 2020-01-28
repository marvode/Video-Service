<?php
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/RequestApproval.php");?>

<?php

echo "<div class='col-md-12' id='pagination_data'>";

echo "</div>";
?>
<script type="text/javascript">
    load_data();
    $(document).on('click', '.pagination_link', function() {
        var page = $(this).attr('id');
        load_data(page);
        $(this).addClass("active");
    }) 
</script>
<?php
require_once("include/footer.php")
?>
