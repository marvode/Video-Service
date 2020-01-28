<?php 
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/RequestApproval.php");?>

<script src="assets/js/adminActions.js"></script>

<div class='row d-flex justify-content-end'>
    <?php echo ButtonProvider::createRequestHistory(); ?>
</div>
<br>
<?php
$requests = new RequestView($con);


$requests->create();

require_once("include/footer.php")
?>