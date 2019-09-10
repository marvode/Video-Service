function subscribe(userTo, userFrom, button) {
    if(userTo == userFrom) {
        alert("You can't subscribe to yourself");
        return;
    }

    $.post("ajax/subscribe.php", { userTo: userTo, userFrom: userFrom, videoId: videoId })
    .done(function(count) {
        if(count != null) {
            $(button).toggleClass("btn-danger btn-secondary");

            var buttonText = $(button).hasClass("btn-danger") ? "SUBSCRIBE" : "SUBSCRIBED";
            $(button).text(buttonText + " " + count);
        }
        else {
            alert("Something went wrong");
        }
    });
}
