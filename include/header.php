<?php
require_once("include/config.php");
require_once("include/classes/User.php");
require_once("include/classes/Video.php");
require_once("include/classes/VideoGrid.php");
require_once("include/classes/VideoGridItem.php");


$usernameLoggedIn = isset($_SESSION["userLoggedIn"]) ? $_SESSION["userLoggedIn"] : "";

$userLoggedInObj = new User($con, $usernameLoggedIn);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>EVISION360</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="assets/css/style.css"> -->
    </head>
    <body style="background-color:#f0edeb;">
        <nav class="navbar navbar-light navbar-expand-md bg-light sticky-top mb-2" role="navigation" style="border-bottom:1px solid rgba(0,0,0,0.2)">
            <div class="container-fluid d-flex">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> ☰
                </button> <a class="navbar-brand" href="index.php">EVISION360</a>

                <div class="collapse navbar-collapse justify-content-end" id="bs-example-navbar-collapse-1">
                    <form class="form-inline" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <div class="input-group-append">
                                <button type="reset" class="btn btn-outline-dark">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                    <ul class="nav navbar-nav">
                        <li class="active nav-item"><a href="upload.php" class="nav-link">Upload</a></li>
                        <li class="nav-item"><a href="sign_in.php" class="nav-link">Sign In</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid" id="mainContent">
            <div class="jumbotron bg-light" style="flex:1;" id="mainContentContainer">
                <div class="p-2">
