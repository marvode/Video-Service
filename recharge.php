<?php
require_once("include/header.php");
require_once("include/afterNav.php");
?>

<div class="container">
    <div class="offset-lg-3 col-lg-6">
        <div class="card text-dark">
            <div class="card-header">
                <h3>Recharge Now</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <input class='form-control' id='email' type="text" name="" value="<?php echo $userLoggedInObj->getEmail(); ?>">
                    </div>
                    <div class="form-group">
                        <input class='form-control' id='phone' type="text" name="" value="" placeholder="Your Phone Number">
                    </div>
                    <div class="form-group">
                        <input class='form-control' id='amount' type="text" name="" value="" placeholder="Amount in USD (eg. 5)">
                    </div>
                    <script type="text/javascript" src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                    <button class='btn btn-success' style="border-radius: 0px" type="button" id='submit' onclick="payWithRave()">Pay Now</button>
                </form>
            </div>

        </div>
    </div>

</div>

<script>
    function payWithRave() {
        const API_publicKey = "FLWPUBK-99302aeac657078ec0d9917f81a16893-X";
        const email = document.querySelector('#email').value;
        const phone = document.querySelector('#phone').value;
        const rechargeAmount = parseFloat(document.getElementById('amount').value);
        const uniqueId = function() {
            return Math.random().toString(36).substr(2, 16);
        }

        var x = getpaidSetup({
            PBFPubKey: API_publicKey,
            customer_email: email,
            amount: rechargeAmount,
            customer_phone: phone,
            currency: "USD",
            country: "NG",
            txref: "rave-" + uniqueId(),

            onclose: function() {},
            callback: function(response) {
                var txref = response.tx.txRef; // collect txRef returned and pass to a 					server page to complete status check.
                var status = response.data.data.status;
                console.log("This is the response returned after a charge", response);
                var address = "http://evision360.com/"
                if (
                    response.tx.chargeResponseCode == "00" ||
                    response.tx.chargeResponseCode == "0"
                ) {
                    // redirect to a success page.
                    let user = "<?php echo $usernameLoggedIn; ?>";
                    topup(user, rechargeAmount);
                } else {
                    // redirect to a failure page.
                    window.location = address + "paymentverification.php?status=" + status;
                }

                x.close(); // use this to close the modal immediately after payment.
            }
        });
    }
</script>



<?php require_once("include/footer.php"); ?>
