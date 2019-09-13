<?php
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/ProfileGenerator.php");
?>
<?php

if(isset($_GET["username"])) {
    $profileUsername = $_GET["username"];
}
else {
    echo "Channel not Found";
    exit();
}
$profileGenerator = new ProfileGenerator($con, $userLoggedInObj, $profileUsername);
echo $profileGenerator->create();

require_once("include/footer.php")?>
