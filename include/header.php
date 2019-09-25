<?php
require_once("include/config.php");
require_once("include/classes/User.php");
require_once("include/classes/ButtonProvider.php");
require_once("include/classes/Video.php");
require_once("include/classes/VideoGrid.php");
require_once("include/classes/VideoGridItem.php");
require_once("include/classes/SubscriptionsProvider.php");
require_once("include/classes/Transactions.php");


$usernameLoggedIn = isset($_SESSION["userLoggedIn"]) ? $_SESSION["userLoggedIn"] : "";

$userLoggedInObj = new User($con, $usernameLoggedIn);
if(User::isLoggedIn()){
    $userLoggedInObj->downgrade();
    $userLoggedInObj->subscriptionCheck($usernameLoggedIn);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>EVISION360</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/button.css">

        <script src="assets/js/jquery.js" charset="utf-8"></script>
        <script src="assets/js/popper.js" charset="utf-8"></script>
        <script src="assets/js/bootstrap.min.js" charset="utf-8"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/userAction.js" charset="utf-8"></script>
        <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5d8b73277b26a8001242976b&product=inline-share-buttons" async="async"></script>
        <style media="screen">
        @import url('https://fonts.googleapis.com/css?family=Satisfy&display=swap');

        .navbar-brand {
            font-family: 'Satisfy', cursive;
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
                </button> <a class="navbar-brand" href="index.php">EVISION360</a>

                <div class="collapse navbar-collapse col-lg-10 justify-content-end" id="bs-example-navbar-collapse-1">
                    <form action="search.php" method="GET" class="form-inline mr-auto ml-auto" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search">
                            <div class="input-group-append">
                                <button class="btn btn-outline-light bg-light" style="border-width: 0px;">
                                    <img src="assets/images/icons/search.png" alt="" width="22px">
                                </button>
                            </div>
                        </div>
                    </form>
                    <ul class="nav navbar-nav">
                        <li class="nav-item"><a href='#' class='nav-link disabled' style:'padding-right: 1em; padding-left: 1em'><span style="color: red;">Live Stream<sup>coming soon</sup></span></a></li>
                        <li class="nav-item"><?php echo ButtonProvider::createUserUploadButton() ?></li>
                        <li class="nav-item"><a class="nav-link" href="audio.php">Audio</a></li>
                        <li class="nav-item"><?php echo ButtonProvider::createSubscriptionsButton() ?></li>
                        <li class="nav-item"><?php echo ButtonProvider::createUserProfileNavigationButton($con, $usernameLoggedIn) ?></li>
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
