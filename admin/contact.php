<?php require_once("include/header.php");
require_once("include/afterNav.php");

function getAllContacts($con) {
    $query = $con->prepare("SELECT * FROM contact ORDER BY id DESC");
    $query->execute();

    $html = "<table class='table table-striped'>
                <thead class='thead-dark'>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th></th>
                </thead>
                <tbody>";

    while($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $username = $row["username"];
        $name = $row["name"];
        $date = $row["date"];
        $email = $row["email"];
        $subject = $row["subject"];
        $message = $row["message"];
        $delete = ButtonProvider::createDeleteMessageButton($con, $row["id"]);

        $html .= "<tr>
                    <td>$username</td>
                    <td>$name</td>
                    <td>$email</td>
                    <td>$subject</td>
                    <td>$message</td>
                    <td>$date</td>
                    <td>$delete</td>
                </tr>";
    }
    $html .= "</tbody>
            </table>";

    return $html;
}

?>

<div class="">
    <?php echo getAllContacts($con); ?>
</div>

<?php

require_once("include/footer.php")
?>
