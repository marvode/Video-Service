<?php
class Request {
    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function requestWithdrawal($amount, $accountName, $accountNo, $bankName) {
        if($this->debitUser($amount)) {
            Transaction::recordWithdrawal($this->con, $amount, $this->userLoggedInObj->getUserId(), 0, $accountName, $accountNo, $bankName);

            return true;
        }
        return false;
    }

    public function getAllRequest() {
        $query = $this->con->prepare("SELECT * FROM withdrawals ORDER BY id DESC");

        $query->execute();

        $html = "<table class='table table-striped'>
                    <thead class='thead-dark'>
                        <th>Withdrawal Amount</th>
                        <th>Status</th>
                        <th>Request Date</th>
                    </thead>
                    <tbody>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $status = $this->mapStatus($row["withdrawalStatus"]);
            $amount = $row["amount"];
            $date = $row["date"];


            $html .= "<tr>
                        <td>$amount</td>
                        <td>$status</td>
                        <td>$date</td>
                    </tr>";
        }
        $html .= "</tbody>
                </table>";

        return $html;
    }

    private function debitUser($amount) {
        $balance = $this->userLoggedInObj->getBalance();
        if($balance >= $amount) {
            $balance = $balance - $amount;
            $id = $this->userLoggedInObj->getUserId();
            $query = $this->con->prepare("UPDATE users SET balance=:balance where id=:id");
            $query->bindParam(":balance", $balance);
            $query->bindParam(":id", $id);

            $query->execute();
            return true;
        }
        return false;
    }

    private function mapStatus($status) {
        if($status == 0) {
            return "Pending";
        }
        return "Approved";
    }
}

?>