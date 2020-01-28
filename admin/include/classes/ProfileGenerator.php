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

        return "<div class='row justify-content-center'>
                    <div class=''>
                        <img class='' src='$profileImage'>
                        <div class=''>
                            <h4 class=''>$name</h4>
                            $subCount subscribers
                        </div>
                    </div>
                </div>
                <div class=''>
                    $button
                    <div class=''>
                        <div class='btn-group d-flex justify-content-end'>
                            $rechargebutton
                            $editDetails
                            $requestWithdrawal
                        </div>
                    </div>
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
            return ButtonProvider::createHyperlinkButton('Request Withdrawal', '', "request.php", 'btn btn-secondary');
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
