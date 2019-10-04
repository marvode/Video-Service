<?php
require_once("../include/config.php");
require_once("../include/classes/Video.php");
require_once("../include/classes/VideoGrid.php");
require_once("../include/classes/User.php");
require_once("../include/classes/VideoGridItem.php");
require_once("../include/classes/ButtonProvider.php");
require_once("../include/classes/ProfileGenerator.php");

$username = $_SESSION["userLoggedIn"];
$userLoggedInObj = new User($con, $username);

$record_per_page = 15;
$page = "";
$output = "";

if(isset($_POST["profileUsername"])) {
    $profileUsername = $_POST["profileUsername"];
}
else {
    $profileUsername = $username;
}
if(isset($_POST["page"])) {
    $page = $_POST["page"];
}
else {
    $page = 1;
}

$start_from = ($page-1)*$record_per_page;

$profileData = new ProfileGenerator($con,$userLoggedInObj, $profileUsername);
echo $profileData->create($start_from, $record_per_page)

?>
