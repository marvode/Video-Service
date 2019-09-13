<?php
require_once("include/config.php");
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
                    <img src='$profilePic' height='30px'>
                </a>";
    }

    public static function createUserProfilePic($con, $username) {
        $userObj = new User($con, $username);
        $profilePic = $userObj->getProfilePic();

        return "<img src='$profilePic' height='26px'>";
    }

    public static function createUserProfileNavigationButton($con, $username) {
        if(User::isLoggedIn()) {
            return ButtonProvider::createUserProfileButton($con, $username);
        }
        else {
            return "<a href='sign_in.php' class='nav-link ' style='padding-right: 1em; padding-left: 1em'>
                        <span class=''>Sign In</span>
                    </a>";
        }
    }

    public static function createUserUploadButton() {
        if(User::isLoggedIn()) {
            return ButtonProvider::createHyperlinkButton("Upload", "", "upload.php", "nav-link ");
        }
        else {
            return ButtonProvider::createHyperlinkButton("Upload", "", "sign_in.php", "nav-link ");
        }
    }

    public static function createRechargeButton($text) {
        if(User::isLoggedIn()) {
            return ButtonProvider::createHyperlinkButton("$text", "", "recharge.php", "nav-link ");
        }
        else {
            return "";
        }
    }

    public static function createSubscriptionsButton() {
        if(User::isLoggedIn()) {
            return ButtonProvider::createHyperlinkButton("Subscriptions", "", "subscriptions.php", "nav-link ");
        }
        else {
            return "";
        }
    }

    public static function createLogOutButton() {
        if(User::isLoggedIn()) {
            return ButtonProvider::createHyperlinkButton("Sign out", "", "logout.php", "nav-link ");
        }
        else {
            return ButtonProvider::createHyperlinkButton("Sign Up", "", "sign_up.php", "nav-link ");
        }
    }

    public static function createSubscriberButton($con, $userToObj, $userLoggedInObj, $videoId) {
        $userTo = $userToObj->getUsername();
        $userLoggedIn = $userLoggedInObj->getUsername();

        if($userTo == $userLoggedIn) {
            $button = ButtonProvider::createDeleteButton($con, $videoId);
            return "<div class='d-flex justify-content-end'>
                        $button
                    </div>";
        }
        $isSubscribedTo = $userLoggedInObj->isSubscribedTo($userTo);
        $buttonText = $isSubscribedTo ? "SUBSCRIBED" : "SUBSCRIBE";
        $buttonText .= " " . $userToObj->getSubscriberCount();

        $buttonClass = $isSubscribedTo ? "btn-secondary" : "btn-danger";

        $button = ButtonProvider::createHyperlinkButton($buttonText, null, "subscribe.php?videoId=$videoId", "btn " . $buttonClass);

        return "<div class='d-flex justify-content-end'>
                    $button
                </div>";

    }

    public static function createDeleteButton($con, $videoId) {
        return ButtonProvider::createButton("Delete", null, "deleteFile(\"$videoId\", this)", "btn btn-danger");
    }
}
?>
