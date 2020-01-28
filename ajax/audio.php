<?php
require_once("../include/config.php");
require_once("../include/classes/User.php");
require_once("../include/classes/ButtonProvider.php");
require_once("../include/classes/Audio.php");
require_once("../include/classes/AudioItem.php");
require_once("../include/classes/AudioGrid.php");

$username = $_SESSION["userLoggedIn"];
$userLoggedInObj = new User($con, $username);

$record_per_page = 2;
$page = "";
$output = "";

if(isset($_POST["page"])) {
    $page = $_POST["page"];
}
else {
    $page = 1;
}
$start_from = ($page-1)*$record_per_page;

$audioGrid = new AudioGrid($con, $userLoggedInObj);
echo $audioGrid->create(null, false, $start_from, $record_per_page);
?>
