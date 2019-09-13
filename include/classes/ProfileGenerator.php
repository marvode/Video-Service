<?php
require_once("ProfileData.php");

class ProfileGenerator {
    private $con, $userLoggedInObj, $profileData, $profileUserObj;

    public function __construct($con, $userLoggedInObj, $profileUsername) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
        $this->profileUsername = $profileUsername;
        $this->profileData = new ProfileData($con, $profileUsername);

    }

    public function create() {
        $profileUsername = $this->profileData->getProfileUsername();

        if(!$this->profileData->userExists()) {
            return "User does not exist";
        }

        $headerSection = $this->createHeaderSection();
        $tabsSection = $this->createTabsSection();
        $contentSection = $this->createContentSection();

        return "<div class='text-light'>
                    $headerSection
                    $tabsSection
                    $contentSection
                </div>";
    }

    public function createHeaderSection() {
        $profileImage = $this->profileData->getProfilePic();
        $name = $this->profileData->getProfileUserFullName();
        $subCount = $this->profileData->getSubscriberCount();

        $button = $this->createHeaderButton();
        $editDetails = $this->createEditDetailsButton();
        $rechargebutton = $this->createRechargeButton();
        $requestWithdrawal = $this->requestWithdrawal();
        $requestWithdrawal2 = $this->requestWithdrawal2();

        return "<div class='row'>
                    <div class='offset-lg-4 col-lg-4'>
                        <div class='d-flex justify-content-center'>
                            <div class=''><img class='img-fluid ' src='$profileImage' style='max-height: 300px'></div>
                        </div>
                    </div>
                    <!--<div class=' '>
                        <h4 class=''>$name</h4>
                        $subCount subscribers
                    </div>-->
                    <div class='col-lg-4 '>
                        $requestWithdrawal
                    </div>
                </div>
                </div>
                <div class=''>
                    $button
                    <div class='d-flex justify-content-end'>
                        <div class='row'><div class='btn-group '>
                            $rechargebutton
                            $editDetails
                            $requestWithdrawal2
                        </div></div>
                    </div>";
    }

    public function createTabsSection() {
        return "<ul class='nav nav-tabs' role='tablist'>
                    <li class='nav-item'>
                    <a class='nav-link  text-secondary active' id='videos-tab' data-toggle='tab'
                        href='#videos' role='tab' aria-controls='videos' aria-selected='true'>VIDEOS</a>
                    </li>
                    <li class='nav-item'>
                    <a class='nav-link text-secondary' id='about-tab' data-toggle='tab' href='#about' role='tab'
                        aria-controls='about' aria-selected='false'>ABOUT</a>
                    </li>
                </ul>";
    }

    public function createContentSection() {
        $videos = $this->profileData->getUsersVideos();

        if(sizeof($videos) > 0) {
            if($this->userLoggedInObj->isSubscribedTo($this->profileUsername)) {
                $videoGrid = new VideoGrid($this->con, $this->userLoggedInObj);
                //$videoGridHtml = $videoGrid->create($videos, null, false, 0);
                $videoGridHtml = $videoGrid->create($videos, "Content", false, 1, $this->profileUsername);
            }
            else {
                $videoGrid = new VideoGrid($this->con, $this->userLoggedInObj);
                $videoGridHtml = $videoGrid->create($videos, "Trailers", false, 0, "");
            }
        }
        else {
            $videoGridHtml = "<span>This user has no videos</span>";
        }

        $aboutSection = $this->createAboutSection();

        return "<div class='tab-content channelContent'>
                    <div class='tab-pane fade show active' id='videos' role='tabpanel' aria-labelledby='videos-tab'>
                        $videoGridHtml
                    </div>
                    <div class='tab-pane fade' id='about' role='tabpanel' aria-labelledby='about-tab'>
                        $aboutSection
                    </div>
                </div>";
    }

    private function requestWithdrawal() {
        if($this->userLoggedInObj->getUsername() != $this->profileData->getProfileUsername()) {
            return "";
        }
        else {
            return "<h4>Request Withdrawal</h4>
                    <hr>
                    <form method='POST' action='request.php'>
                        <div class='form-group '><input type='text' class='form-control' name='amount' placeholder='Amount in USD (eg. 20)'></div>
                        <div class='form-group '><input type='text' class='form-control' name='accountName' placeholder='Your Account Name'></div>
                        <div class='form-group '><input type='text' class='form-control' name='accountNo' placeholder='Your Account Number'></div>
                        <div class='form-group '><input type='text' class='form-control' name='bankName' placeholder='Your Bank Name'></div>
                        <div class='form-group d-flex justify-content-end'><button type='submit' name='submit' class='btn btn-secondary'>Submit</button></div>
                    </form>";
        }
    }

    private function requestWithdrawal2() {
        if($this->userLoggedInObj->getUsername() != $this->profileData->getProfileUsername()) {
            return "";
        }
        else {
            return ButtonProvider::createHyperlinkButton('Withdraw History', '', "request.php", 'btn btn-secondary');
        }
    }

    private function createEditDetailsButton() {
        if($this->userLoggedInObj->getUsername() != $this->profileData->getProfileUsername()) {
            return "";
        }
        else {
            return ButtonProvider::createHyperlinkButton('Edit Details', '', "settings.php", 'btn btn-secondary');
        }
    }

    private function createRechargeButton() {
        if($this->userLoggedInObj->getUsername() != $this->profileData->getProfileUsername()) {
            return "";
        }
        else {
            return ButtonProvider::createHyperlinkButton('Recharge', '', "recharge.php", 'btn btn-secondary');
        }
    }

    private function createHeaderButton() {
        if($this->userLoggedInObj->getUsername() == $this->profileData->getProfileUsername()) {
            return "";
        }
        else {
            return ButtonProvider::createSubscriberButton(
                    $this->con,
                    $this->profileData->getProfileUserObj(),
                    $this->userLoggedInObj
                );
        }
    }

    private function createAboutSection() {
        $html = "<div class='p-3'>
                    <div class=''>
                        <h3>Details</h3>
                    </div>
                    <div class=''>";

        $details = $this->profileData->getAllUserDetails();
        foreach($details as $key => $value) {
            $html .= "<span>$key: $value</span><br>";
        }

        $html .= "</div></div>";

        return $html;
    }
}
?>
