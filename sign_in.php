<?php
require_once("include/header.php");
require_once("include/afterNav.php");
require_once("include/classes/Account.php");
require_once("include/classes/Constants.php");
require_once("include/classes/FormSanitizer.php");

$account = new Account($con);

if(isset($_POST["submit_button"])) {
    $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);

    $wasSuccessful = $account->login($username, $password);

    if($wasSuccessful) {
        $_SESSION["userLoggedIn"] = $username;
        header("Location: index.php");
    }
}

function getInputValue($name) {
    if(isset($_POST[$name])) {
        echo $_POST[$name];
    }
}
?>

<div class="row">
    <div class="offset-md-2 offset-lg-3 mt-5"></div>
    <div class=" col-lg-6 col-md-8">
        <div class="card bg-dark">
            <div class="card-header">
                <h2>Sign In</h2>
            </div>
            <div class="card-body">
                <form action="sign_in.php" method="POST">

                    <?php echo $account->getError(Constants::$loginFailed); ?>
                    <input class="form-control" type="text" name="username" placeholder="Username" value="<?php getInputValue("username") ?>" required><br>

                    <input class="form-control" type="password" placeholder="Password" name="password" value="<?php getInputValue("password"); ?>" required><br>

                    <input class="btn btn-primary" type="submit" name="submit_button" value="Submit">
                </form>
            </div>
            <div class="card-footer">
                <a href="sign_up.php" class='text-light'>Need an account? Sign up here!</a>
            </div>
        </div>
    </div>

    <div class="offset-md-2 offset-lg-3"></div>
</div>
