<?php
    require_once("include/header.php");
    require_once("include/afterNav.php");
    require_once("include/config.php");
    require_once("include/classes/Account.php");
    require_once("include/classes/Constants.php");
    require_once("include/classes/FormSanitizer.php");

    $account = new Account($con);

    if(isset($_POST['submit_button'])) {
        $first_name = FormSanitizer::sanitizeFormString($_POST["first_name"]);
        $last_name = FormSanitizer::sanitizeFormString($_POST["last_name"]);
        $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
        $email = FormSanitizer::sanitizeFormUsername($_POST["email"]);
        $email2 = FormSanitizer::sanitizeFormUsername($_POST["email2"]);
        $password = FormSanitizer::sanitizeFormUsername($_POST["password"]);
        $password2 = FormSanitizer::sanitizeFormUsername($_POST["password2"]);

        $wasSuccessful = $account->register($first_name, $last_name, $username, $email, $email2, $password, $password2);

        if($wasSuccessful) {
            $_SESSION["userLoggedIn"] = $username;
            header("Location: index.php");
        }
    }


    function getInputValue($name){
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }

?>

<div class="row">
    <div class="offset-md-2 offset-md-3 mt-5"></div>
    <div class=" col-md-6 col-md-8">
        <div class="card bg-dark">
            <div class="card-header">
                <h2>Sign Up</h2>
            </div>
            <div class="card-body">
                <form action="sign_up.php" method="POST">

                    <?php echo $account->getError(Constants::$firstNameCharacters); ?>
                    <input class="form-control" type="text" name="first_name" placeholder="First Name" value="<?php getInputValue("first_name") ?>" required><br>

                    <?php echo $account->getError(Constants::$lastNameCharacters); ?>
                    <input class="form-control" type="text" name="last_name" placeholder="Last Name" value="<?php getInputValue("last_name") ?>" required><br>

                    <?php echo $account->getError(Constants::$usernameCharacters); ?>
                    <?php echo $account->getError(Constants::$usernameTaken); ?>
                    <input class="form-control" type="text" name="username" placeholder="Username" value="<?php getInputValue("username") ?>" required><br>

                    <?php echo $account->getError(Constants::$emailTaken); ?>
                    <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                    <?php echo $account->getError(Constants::$emailInvalid); ?>
                    <input class="form-control" type="email" placeholder="Email" name="email" value="<?php getInputValue("email"); ?>" required autocomplete="off"><br>
                    <input class="form-control" type="email" placeholder="Confirm Email" name="email2" value="<?php getInputValue("email2"); ?>" required autocomplete="off"><br>

                    <?php echo $account->getError(Constants::$passwordLength); ?>
                    <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                    <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
                    <input class="form-control" type="password" placeholder="Password" name="password" value="<?php getInputValue("password"); ?>" required autocomplete="off"><br>
                    <input class="form-control" type="password" placeholder="Confirm Password" name="password2" value="<?php getInputValue("password2"); ?>" required autocomplete="off"><br>

                    <input class="btn btn-primary" type="submit" name="submit_button" value="Submit">
                </form>
            </div>
            <div class="card-footer">
                <a href="sign_in.php" class="text-light">Already have an account? Sign in here!</a>
            </div>
        </div>
    </div>

    <div class="offset-md-2 offset-md-3"></div>
</div>
