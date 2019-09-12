<?php

class RequestView {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function create() {
        if(User::isLoggedIn()){
            echo $this->getAllUsersRequest();
        }
    }

    private function getAllUsersRequest() {
        $query = $this->con->prepare("SELECT * FROM withdrawals WHERE withdrawalStatus=0 ORDER BY id");
        $query->execute();
    
        $html = "<table class='table table-striped'>
                    <thead class='thead-dark'>
                        <th>Username</th>
                        <th>Withdrawal Amount</th>
                        <th>Account Name</th>
                        <th>Account No</th>
                        <th>Bank Name</th>
                        <th>Request Date</th>
                        <th></th>
                    </thead>
                    <tbody>";
    
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $username = $this->getUsernameFromId($row["userId"]);
            $amount = $row["amount"];
            $date = $row["date"];
            $requestId = $row["id"];
            $bankName = $row["bankName"];
            $accountName = $row["accountName"];
            $accountNo = $row["accountNo"];
            $approveButton = ButtonProvider::createApproveButton($this->con, $requestId);
            
    
            $html .= "<tr>
                        <td>$username</td>
                        <td>$amount</td>
                        <td>$accountName</td>
                        <td>$accountNo</td>
                        <td>$bankName</td>
                        <td>$date</td>
                        <td>$approveButton</td>
                    </tr>";
        }
        $html .= "</tbody>
                </table>";
    
        return $html;
    }

    public function getRequestHistory() {
        $query = $this->con->prepare("SELECT * FROM withdrawals ORDER BY id DESC");
        $query->execute();
    
        $html = "<table class='table table-striped'>
                    <thead class='thead-dark'>
                        <th>Username</th>
                        <th>Withdrawal Amount</th>
                        <th>Request Date</th>
                        <th></th>
                    </thead>
                    <tbody>";
    
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $username = $this->getUsernameFromId($row["userId"]);
            $amount = $row["amount"];
            $date = $row["date"];
            $requestId = $row["id"];
            $approveButton = ButtonProvider::createApproveButton($this->con, $requestId);
            
    
            $html .= "<tr>
                        <td>$username</td>
                        <td>$amount</td>
                        <td>$date</td>
                        <td>$approveButton</td>
                    </tr>";
        }
        $html .= "</tbody>
                </table>";
    
        return $html;
    }


    private function getUsernameFromId($id) {
        $query = $this->con->prepare("SELECT user_name FROM users WHERE id=:id");
        $query->bindParam(":id", $id);
        $query->execute();

        $username = (string)$query->fetch(PDO::FETCH_ASSOC)["user_name"];

        return $username;
    }

    public static function isApproved($con, $requestId) {
        $query = $con->prepare("SELECT withdrawalStatus FROM withdrawals WHERE id=:requestId");
        $query->bindParam(":requestId", $requestId);

        $query->execute();
        
        return (int)$query->fetch(PDO::FETCH_ASSOC)["withdrawalStatus"];
    }
}
?>