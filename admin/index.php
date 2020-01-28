<?php
require_once('include/header.php');
require_once("include/afterNav.php");

function getAllUsersBalance($con) {
    $query = $con->prepare("SELECT * FROM users WHERE balance > 0 ORDER BY balance DESC");
    $query->execute();

    $html = "<table class='table table-striped'>
                <thead class='thead-dark'>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Sign Up Date</th>
                    <th>Subscription Cost</th>
                    <th>Balance</th>
                </thead>
                <tbody>";

    while($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $name = $row["first_name"] . " " . $row["last_name"];
        $username = $row["user_name"];
        $email = $row["email"];
        $signUpDate = $row["signUpDate"];
        $balance = $row["balance"];
        $subscriptionCost = $row["subscriptionCost"];

        $html .= "<tr>
                    <td>$name</td>
                    <td>$username</td>
                    <td>$email</td>
                    <td>$signUpDate</td>
                    <td>$subscriptionCost</td>
                    <td>$balance</td>
                </tr>";
    }
    $html .= "</tbody>
            </table>";

    return $html;
}

if(User::isLoggedIn()){
    echo getAllUsersBalance($con);
}
?>

<?php include('include/footer.php'); ?>
