<?php

class ButtonProvider {
    public static $signInFunction = "notSignedIn()";

    public static function createLink($link) {
        return User::isLoggedIn() ? $link : ButtonProvider::$signInFunction;
    }

    public static function createButton($text, $imageSrc, $action, $class) {
        $image = ($imageSrc == null) ? "" : "<img src='$imageSrc'>";
        $action = ButtonProvider::createLink($action);

        return "<button class='$class' onclick='$action'>
                    $image
                    <span>$text</span>
                </button>";
    }

    public static function createHyperlinkButton($text, $imageSrc, $href, $class) {
        $image = ($imageSrc == null) ? "" : "<img src='$imageSrc'>";

        return "<a href='$href' class='$class' style:'padding-right: 1em; padding-left: 1em'>
                    $image
                    <span>$text</span>
                </a>";
    }


    public static function createUserProfileButton($con, $username) {
        $userObj = new User($con, $username);
        $profilePic = $userObj->getProfilePic();
        $link = "profile.php?username=$username";

        return "<a href='$link' class='nav-link ' style='padding-right: 1em; padding-left: 1em'>
                    <img src='../$profilePic' height='30px'>
                </a>";
    }

    public static function createUserProfilePic($con, $username) {
        $userObj = new User($con, $username);
        $profilePic = "../" . $userObj->getProfilePic();

        return "<img src='$profilePic' height='26px'>";
    }

    public static function createSetFeatureVideo() {
        return ButtonProvider::createHyperlinkButton("Set Feature Video", "", "feature.php", "nav-link ");
    }

    public static function createApproveRequest() {
        return ButtonProvider::createHyperlinkButton("Approve Requests", "", "requests.php", "nav-link ");
    }

    public static function createLogOutButton() {
        if(User::isLoggedIn()) {
            return ButtonProvider::createHyperlinkButton("Sign out", "", "logout.php", "nav-link ");
        }
        else {
            return ButtonProvider::createHyperlinkButton("Sign In", "", "sign_in.php", "nav-link ");
        }
    }

    public static function createRechargeButton($text) {
        if(User::isLoggedIn()) {
            return ButtonProvider::createHyperlinkButton("$text", "", "#", "nav-link ");
        }
        else {
            return "";
        }
    }

    public static function createApproveButton($con, $requestId) {
        $isApproved = RequestView::isApproved($con, $requestId);
        $buttonText = $isApproved ? "APPROVED" : "APPROVE";

        $buttonClass = $isApproved ? "btn " : "btn btn-success";
        $action = "approve(\"$requestId\", this)";

        $button = ButtonProvider::createButton($buttonText, null, $action, $buttonClass);

        return "<div class='subscribeButtonContainer'>
                    $button
                </div>";
    }

    public static function createDeleteButton($con, $videoId) {
        return ButtonProvider::createButton("Delete", null, "deleteFile(\"$videoId\", this)", "btn btn-danger");
    }

    public static function createDeleteAudioButton($con, $audioId) {
        return ButtonProvider::createButton("Delete", null, "deleteAudio(\"$audioId\", this)", "btn btn-danger");
    }

    public static function createDeleteMessageButton($con, $messageId) {
        return ButtonProvider::createButton("Delete", null, "deleteMessage(\"$messageId\", this)", "btn btn-danger");
    }

    public static function createFeatureButton($con, $videoId) {
        $isFeatured = RequestView::isFeatured($con, $videoId);
        $buttonText = $isFeatured ? "FEATURED" : "Make Feature";

        $buttonClass = $isFeatured ? "btn " : "btn btn-info";
        return ButtonProvider::createButton($buttonText, null, "makeFeature(\"$videoId\", this)", $buttonClass);
    }

    public static function createRequestHistory() {
        return ButtonProvider::createHyperlinkButton("Request History", "", "requestHistory.php", "btn btn-primary");
    }

    public static function createPaginationButton($linkId) {
        return "<li class='page-item' id='page-item-$linkId'><a class='page-link pagination_link' style='background-color:#fc7b03;' id='$linkId'>$linkId</a></li>";
    }
}
?>
