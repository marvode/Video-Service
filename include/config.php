<?php
    try {
        $con = new PDO("mysql:dbname=Video_Stream;host=localhost", "root", "");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>
