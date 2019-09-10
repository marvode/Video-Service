<?php
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/Account.php");
require_once("include/classes/FormSanitizer.php");
require_once("include/classes/SettingsFormProvider.php");
require_once("include/classes/Constants.php");

if(!User::isLoggedIn()) {
    header("Location: sign_in.php");
}

$detailsMessage = "";
$passwordMessage = "";
$formProvider = new SettingsFormProvider();

if(isset($_POST["saveDetailsButton"])) {
    $account = new Account($con);

    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);

    if($account->updateDetails($firstName, $lastName, $email, $userLoggedInObj->getUsername())) {
        $detailsMessage = "<div class='alert alert-success'>
                                <strong>SUCCESS!</strong> Details updated successfully
                            </div>";
    }
    else {
        $errorMessage = $account->getFirstError();

        if($errorMessage == "") $errorMessage = "Something went wrong";

        $detailsMessage = "<div class='alert alert-danger'>
                                <strong>ERROR!</strong> $errorMessage
                            </div>";
    }
}

if(isset($_POST["savePasswordButton"])) {
    $account = new Account($con);

    $oldPassword = FormSanitizer::sanitizeFormPassword($_POST["oldPassword"]);
    $newPassword = FormSanitizer::sanitizeFormPassword($_POST["newPassword"]);
    $newPassword2 = FormSanitizer::sanitizeFormPassword($_POST["newPassword2"]);

    if($account->updatePassword($oldPassword, $newPassword, $newPassword2, $userLoggedInObj->getUsername())) {
        $passwordMessage = "<div class='alert alert-success'>
                                <strong>SUCCESS!</strong> Password update successfully
                            </div>";
    }
    else {
        $errorMessage = $account->getFirstError();

        if($errorMessage == "") $errorMessage = "Something went Wrong";

        $passwordMessage = "<div class='alert alert-danger'>
                                <strong>ERROR!</strong>
                                $errorMessage
                            </div>";
    }
}
?>
<div class='jumbotron bg-dark'>
    <div class=''>
        <div class=''>
            <?php echo $detailsMessage; ?>
        </div>
        <?php
            echo $formProvider->createUserDetailsForm(
                isset($_POST["firstName"]) ? $_POST["firstName"] : $userLoggedInObj->getFirstName(), isset($_POST["lastName"]) ? $_POST["lastName"] : $userLoggedInObj->getLastName(), isset($_POST["email"]) ? $_POST["email"] : $userLoggedInObj->getEmail()
            );
        ?>
    </div>
    <br>
    <div class=''>
        <div class="">
            <?php echo $passwordMessage; ?>
        </div>
        <?php echo $formProvider->createPasswordForm(); ?>
    </div>
</div>

<?php require_once("include/footer.php"); ?>
