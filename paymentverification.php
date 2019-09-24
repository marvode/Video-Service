<?php
require_once("include/header.php");
require_once("include/afterNav.php");

// if(isset($_GET["txref"])) {
//     $ref = $_GET["txref"];
//     $amount = ""; //get from server
//     $currency = "USD";
//
//     $query = array(
//         "SECKEY" => "FLWSECK-bf533a3c64be74c5bab3fb69cccf51bd-X",
//         "txref" => $ref
//     );
//     $data_string = json_encode($query);
//
//     $ch = curl_init("https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify"); // rave verification url
//     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
//
//     $response = curl_exec($ch);
//
//     $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
//     $header = substr($response, 0, $header_size);
//     $body = substr($response, $header_size);
//
//     curl_close($ch);
//
//     $resp = json_encode($response, true);
//     print_r($resp);
//     $paymentStatus = $resp['data']['status'];
//     $chargeResponsecode = $resp['data']['chargecode'];
//     $chargeAmount = $resp['data']['amount'];
//     $chargeCurrency = $resp['data']['currency'];
//
//     if(($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($chargeAmount == $amount) && ($chargeCurrency == $currency)) {
//         echo successResponse($usernameLoggedIn);
//     }
//     else {
//         echo failureResponse($usernameLoggedIn);
//     }
// }


function successResponse($usernameLoggedIn) {
    return "<div class='col-lg-6 offset-lg-3'>
                <div class='my-auto mx-auto'>
                    <img src='assets/images/success.png' alt='Payment Successful' style='max-height: 370px'>
                    <h5>Payment Successful</h5>
                    <p>Click <a class='text-light' href='profile.php?username=$usernameLoggedIn'>Here</a></p>
                </div>
            </div>";
}

function failureResponse($usernameLoggedIn) {
    return "<div class='col-lg-6 offset-lg-3'>
                <div class='my-auto mx-auto'>
                    <img src='assets/images/unsuccess.png' style='max-height: 370px' alt='Payment Unsuccessful'>
                    <h5>Payment Unsuccessful</h5>
                    <p>Click <a class='text-light' href='profile.php?username=$usernameLoggedIn'>Here</a></p>
                </div>
            </div>";
}
echo successResponse($usernameLoggedIn);
?>

<?php require_once("include/footer.php"); ?>
