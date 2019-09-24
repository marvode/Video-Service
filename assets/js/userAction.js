function subscribe(userTo, userFrom) {
    $.post("ajax/subscribe.php", { userTo: userTo, userFrom: userFrom })
    .done(function(data) {
        if(data === "success") {
            $(".subscribeButton").toggleClass("btn-danger btn-secondary");

            let buttonText = $(".subscribeButton").hasClass("btn-danger") ? "SUBSCRIBE" : "SUBSCRIBED";
            $(".subscribeButton").text(buttonText);
        }
        else {
            alert("Unable to subscribe to this channel: Insufficient Funds");
        }
    });
}

function setSubscription(username, button) {
    let amount = document.querySelector("#subscriptionAmount").value;
    url = "http://localhost/video_service/"
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
            window.location = "http://localhost/video_service/profile.php?username=" + username;
        }
        else {
            $(button).text(result);
        }
    })

}

function deleteFile(videoId, button) {
    $.post("ajax/delete.php", { videoId: videoId })
    .done(function(count) {
        $(button).toggleClass("btn-danger");
        window.location = "http://localhost/video_service/";

        var buttonText = $(button).hasClass("btn-danger") ? "DELETE" : "DELETED";
        $(button).text(count);
    });
}
