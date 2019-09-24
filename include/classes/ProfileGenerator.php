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

        $button = User::isLoggedIn() ? $this->createHeaderButton() : "";
        $editDetails = $this->createEditDetailsButton();
        $rechargebutton = $this->createRechargeButton();
        $requestTab = $this->createRequestWithdrawal();
        $requestWithdrawal2 = $this->requestWithdrawal2();

        if($this->profileUsername != $this->userLoggedInObj->getUsername()) {
            $upgrade = "";
        }
        else {
            $upgrade = $this->createUpgradeSection();
        }

        return "<div class='row'>
                    $upgrade
                </div>
                <div class='row'>
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
                        $requestTab
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
                        </div>
                    </div>
                    </div>
                </div>";
    }

    public function createRequestWithdrawal() {
        if($this->userLoggedInObj->getUsername() != $this->profileData->getProfileUsername()) {
            return "";
        }
        else {
            $requestWithdrawal = $this->requestWithdrawal();

            $others = "<form method='POST' action='request1.php'>
                            <div class='form-group '><input type='text' class='form-control' name='amount' placeholder='Amount in USD (eg. 20)'></div>
                            <div class='form-group '><input type='text' class='form-control' name='paymentMedium' placeholder='Enter Payment Gateway'></div>
                            <div class='form-group '><input type='text' class='form-control' name='paymentId' placeholder='User ID'></div>
                            <div class='form-group d-flex justify-content-end'><button type='submit' name='submit' class='btn btn-secondary'>Submit</button></div>
                        </form>";

            return "<h4>Request Withdrawal</h4>
                    <ul class='nav nav-tabs' role='tablist'>
                        <li class='nav-item'>
                        <a class='nav-link  text-secondary active' id='bank-tab' data-toggle='tab'
                            href='#bank' role='tab' aria-controls='others' aria-selected='true'>BANK</a>
                        </li>
                        <li class='nav-item'>
                        <a class='nav-link text-secondary' id='others-tab' data-toggle='tab' href='#others' role='tab'
                            aria-controls='others' aria-selected='false'>OTHERS</a>
                        </li>
                    </ul><br>
                    <div class='tab-content channelContent'>
                        <div class='tab-pane fade show active' id='bank' role='tabpanel' aria-labelledby='videos-tab'>
                            $requestWithdrawal
                        </div>
                        <div class='tab-pane fade' id='others' role='tabpanel' aria-labelledby='about-tab'>
                            $others
                        </div>
                    </div>";
        }
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

    private function createUpgradeSection() {
        if($this->userLoggedInObj->isPremium()) {
            $downgradeDate = date("d M, Y", $this->userLoggedInObj->getDowngradeDate());
            if($this->userLoggedInObj->getSubscriptionCost() == 0) {
                $button = ButtonProvider::createSetSubscriptionButton($this->userLoggedInObj->getUsername());
                return "<div class='form-inline'>
                            <div class='input-group'>
                                <input type='text' class='form-control' id='subscriptionAmount' placeholder='Set Subscription Cost'>
                                <div class='input-group-append'>
                                    $button
                                </div>
                            </div>
                        </div>";
            }
            else {
                $button = ButtonProvider::createSetSubscriptionButton($this->userLoggedInObj->getUsername());
                return "<div class='row'>
                            <div class='col-12'>
                                <h6><em>Your Premium membership will expire $downgradeDate</em></h6>
                            </div>
                            <div class='form-inline'>
                                <div class='input-group'>
                                    <input type='text' class='form-control' id='subscriptionAmount' placeholder='Change Subscription Cost'>
                                    <div class='input-group-append'>
                                        $button
                                    </div>
                                </div>
                            </div>
                        </div>";
            }
        }
        else {
            $button = ButtonProvider::upgradeButton($this->userLoggedInObj->getUsername());

            $upgrade = "<div class='col-lg-3'>
                            <p>Upgrade to Premium membership plan and get paid per subscription to your channel</p>
                            $button
                        </div>";
            return $upgrade;
        }
    }

    private function requestWithdrawal() {

            return "<form method='POST' action='request.php'>
                        <div class='form-group '><input type='text' class='form-control' name='amount' placeholder='Amount in USD (eg. 20)'></div>
                        <div class='form-group '><input type='text' class='form-control' name='accountName' placeholder='Your Account Name'></div>
                        <div class='form-group '><input type='text' class='form-control' name='accountNo' placeholder='Your Account Number'></div>
                        <div class='form-group '><input type='text' class='form-control' name='bankName' placeholder='Your Bank Name'></div>
                        <div class='form-group d-flex justify-content-end'><button type='submit' name='submit' class='btn btn-secondary'>Submit</button></div>
                    </form>";
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
        if($this->userLoggedInObj->getUsername() != $this->profileData->getProfileUsername()) {
            return ButtonProvider::createSubscriberButton(
                    $this->con,
                    $this->profileData->getProfileUserObj(),
                    $this->userLoggedInObj
                );
        }
        elseif(User::isLoggedIn() == false) {
            return "";
        }
        else {
            return "";
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
