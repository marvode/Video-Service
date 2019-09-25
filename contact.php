<?php
require_once("include/header.php");
require_once("include/afterNav.php");
?>

<div class="col-lg-6 offset-lg-3">
    <h3>Contact Us</h3>
    <form action="contact.php" method="POST">
        <div class="form-group">
            <input class="form-control" type="text" name="name" placeholder="Enter Your Name" required <?php $readonly = User::isLoggedIn() ? 'readonly' : ''; echo $readonly; ?> value="<?php $name = User::isLoggedIn() ? $userLoggedInObj->getName() : "";
            echo $name;?>">
        </div>
        <div class="form-group">
            <input class="form-control" type="email" name="email" placeholder="Enter Your Email" required value="<?php $email = User::isLoggedIn() ?  $userLoggedInObj->getEmail() : "" ;
            echo $email;?>">
        </div>
        <div class="form-group">
            <input class="form-control" type="text" name="subject" placeholder="Subject" required value="">
        </div>
        <div class="form-group">
            <textarea class="form-control" name="message" placeholder="Message" required rows="5"></textarea>
        </div>
        <button name="submit" class='btn btn-primary'>Submit</button>
    </form>
</div>

<?php
function saveContact($con, $name, $email, $subject, $message, $username) {
    $query = $con->prepare("INSERT INTO contact (name, email, subject, message, username) VALUES (:name, :email, :subject, :message, :username)");
    $query->bindParam(":name", $name);
    $query->bindParam(":email", $email);
    $query->bindParam(":subject", $subject);
    $query->bindParam(":message", $message);
    $query->bindParam(":username", $username);
    $query->execute();
}


if(isset($_POST["submit"])) {
    if(isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["subject"]) && isset($_POST["message"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $subject = $_POST["subject"];
        $message = $_POST["message"];

        saveContact($con, $name, $email, $subject, $message, $usernameLoggedIn);

        echo "Thanks for contacting us, we will get back to you as soon as possible";
    }
    else {
        echo "Form not complete";
    }
}
?>

<?php require_once("include/footer.php"); ?>
