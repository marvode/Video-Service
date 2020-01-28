const url = "http://evision360.com/";

function subscribe(userTo, userFrom) {
    $.post("ajax/subscribe.php", { userTo: userTo, userFrom: userFrom })
    .done(function(data) {
        if(data === "success") {
            $(".subscribeButton").toggleClass("btn-danger btn-secondary");

            let buttonText = $(".subscribeButton").hasClass("btn-danger") ? "SUBSCRIBE" : "SUBSCRIBED";
            $(".subscribeButton").text(buttonText);

            $("#subscribeAlert").fadeOut('slow');
        }
        else {
            alert("Unable to subscribe to this channel: Insufficient Funds");
        }
    });
}

function topup(user, amount) {
    console.log(amount);
    $.post("ajax/topup.php", { user: user, amount: amount })
    .done(function() {
        window.location = url + "paymentverification.php?status=successful";
    });
}

function setSubscription(username, button) {
    let amount = document.querySelector("#subscriptionAmount").value;
    if(amount !== "") {
        $.post("ajax/setSubscription.php", {username: username, amount: amount})
        .done(function(count) {
            $(button).text(count);
            setTimeout(() => {window.location = url + "profile.php?username=" + username}, 1000);

        });
    }
    else {
        alert("You did not put in an amount");
    }

}

function upgrade(username, button) {
    $.post("ajax/upgrade.php", { username: username })
    .done(function(result) {
        if(result == "1") {
            window.location = url + "profile.php?username=" + username;
        }
        else {
            $(button).text(result);
        }
    })

}

function deleteAudio(audioId, button) {
    $.post("ajax/delete.php", { audioId: audioId })
    .done(function() {
        $(button).toggleClass("btn-danger");

        var buttonText = $(button).hasClass("btn-danger") ? "DELETE" : "DELETED";
        $(button).text(buttonText);
    });
}

function deleteFile(videoId, button) {
    $.post("ajax/delete.php", { videoId: videoId })
    .done(function(count) {
        $(button).toggleClass("btn-danger");
        window.location = url;

        var buttonText = $(button).hasClass("btn-danger") ? "DELETE" : "DELETED";
        $(button).text(count);
    });
}
