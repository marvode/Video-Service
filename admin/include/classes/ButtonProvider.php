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

    public static function createRequestHistory() {
        return ButtonProvider::createHyperlinkButton("Request History", "", "requestHistory.php", "btn btn-primary");
    }
}
?>
