<?php
require_once('include/header.php');
require_once("include/afterNav.php");?>

<style media="screen">
.languageHover {
    transition: transform 1s ease;
}

.languageHover:hover h5 {
    color: #f95;
    transform: scale(1.2);
}
</style>

<?php

if(isset($_GET["category"]) && !isset($_GET["language"])) {
    $category = (string)$_GET["category"];
    $videoGrid = new VideoGrid($con, $userLoggedInObj->getUsername());
    echo "<div><h4>$category</h4><hr></div>";
    $category = categoryMap($con, $category);
    echo $videoGrid->createFilter("", $category, false, 0);

    echo $videoGrid->languageCategory($category, 0);

}

if (isset($_GET["language"]) && isset($_GET["category"])) {
    $category = (string)$_GET["category"];
    $language = (string)$_GET["language"];
    $videoGrid = new VideoGrid($con, $userLoggedInObj->getUsername());

    echo $videoGrid->languageVideos($category, $language, 0);
}

else {
        echo "Category not Found";
        exit();
}

function categoryMap($con, $category) {

    $query = $con->prepare("SELECT * FROM categories WHERE name=:category");
    $query->bindParam(":category", $category);
    $query->execute();

    $category = $query->fetch(PDO::FETCH_ASSOC);
    return $category["id"];
}
?>
<?php require_once("include/footer.php"); ?>
