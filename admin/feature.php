<?php 
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/RequestApproval.php");?>

<script src="assets/js/adminActions.js"></script>

<?php

$videoGrid = new VideoGrid($con, $userLoggedInObj);
echo "<div class='col-lg-12'>";
echo $videoGrid->createFeatureSelect(null, "Set Feature Video", "");
echo "</div>";

require_once("include/footer.php")
?>