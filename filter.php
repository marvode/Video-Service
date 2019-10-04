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

<script src="assets/js/loadFilter.js" charset="utf-8"></script>

<?php

if(isset($_GET["category"]) && !isset($_GET["language"])) {
    $category = (string)$_GET["category"];

    echo "<div><h4>$category</h4><hr></div>";
    echo "<div id='pagination_data'></div>";
    $category = categoryMap($con, $category);

    echo "<script>
            load_category_data($category, 1);
            $(document).on('click', '.pagination_link', function() {
                var page = $(this).attr('id');
                load_category_data($category, page);
            })
        </script>";
}
elseif(isset($_GET["language"]) && isset($_GET["category"])) {
    $category = (string)$_GET["category"];
    $language = (string)$_GET["language"];

    echo "<div id='pagination_data'></div>";
    echo "<script>
            load_language_data($category, '$language', 1);
            $(document).on('click', '.pagination_link', function() {
                var page = $(this).attr('id');
                load_language_data($category, '$language', page);
            })
        </script>";
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
