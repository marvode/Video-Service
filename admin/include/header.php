<?php
require_once("include/config.php");
require_once("include/classes/User.php");
require_once("include/classes/ButtonProvider.php");
require_once("include/classes/Transactions.php");
require_once("include/classes/Video.php");
require_once("include/classes/VideoGrid.php");
require_once("include/classes/VideoGridItem.php");

$usernameLoggedIn = isset($_SESSION["userLoggedIn"]) ? $_SESSION["userLoggedIn"] : "";

$userLoggedInObj = new User($con, $usernameLoggedIn);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>eVISION360</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <script src="assets/js/jquery.js" charset="utf-8"></script>
        <script src="assets/js/popper.js" charset="utf-8"></script>
        <script src="assets/js/bootstrap.min.js" charset="utf-8"></script>
        <script src="assets/js/main.js"></script>

        <script src="assets/js/adminActions.js"></script>

        <style media="screen">
        @import url('https://fonts.googleapis.com/css?family=Lobster&display=swap');

        .navbar-brand {
            font-family: 'Lobster', cursive;
        }
        hr {
        		width: 95%;
            	height: 1px;
        		background-color: #4f4f4f;
        		border: none;
        }
        </style>
    </head>
    <body style="background-color:#fc7b03;">
        <nav class="navbar navbar-dark navbar-expand-lg bg-dark sticky-top mb-2" role="navigation" style="border-bottom:1px solid rgba(0,0,0,0.2)">
            <div class="container-fluid d-flex">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> ☰
                </button> <a class="navbar-brand" href="index.php">eVISION360</a>

                <div class="collapse navbar-collapse col-md-10 justify-content-end" id="bs-example-navbar-collapse-1">
                    <form class="form-inline mr-auto ml-auto" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search">
                            <div class="input-group-append">
                                <button type="reset" class="btn btn-outline-light bg-light" style="border-width: 0px;">
                                    <img src="assets/images/icons/search.png" alt="" width="22px">
                                </button>
                            </div>
                        </div>
                    </form>
                    <ul class="nav navbar-nav">
                        <li class="nav-item"><?php if(User::isLoggedIn()) echo ButtonProvider::createApproveRequest();?></li>
                        <li class="nav-item"><?php if(User::isLoggedIn()) echo ButtonProvider::createSetFeatureVideo();?></li>
                        <li class="nav-item"><?php if(User::isLoggedIn()) echo ButtonProvider::createHyperlinkButton("Audio", null, "audio.php", "nav-link");?></li>
                        <li class="nav-item"><?php if(User::isLoggedIn()) echo ButtonProvider::createHyperlinkButton("Messages", null, "contact.php", "nav-link");?></li>

                        <li class="nav-item"><?php echo ButtonProvider::createLogOutButton() ?></li>
                        <li class="nav-item"><?php if(User::isLoggedIn()) {
                            $balance = $userLoggedInObj->getBalance();
                            echo ButtonProvider::createRechargeButton("<em>Available Bal: </em>$balance USD");
                        }
                        else {
                            echo "";
                        }?></li>

                    </ul>
                </div>
            </div>
        </nav>
