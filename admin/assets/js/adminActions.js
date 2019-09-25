function approve(requestId, button) {
    $.post("ajax/approve.php", { requestId: requestId })
    .done(function() {
        $(button).toggleClass("btn-success");

        var buttonText = $(button).hasClass("btn-success") ? "APPROVE" : "APPROVED";
        $(button).text(buttonText);
    });
}

function deleteFile(videoId, button) {
    $.post("ajax/delete.php", { videoId: videoId })
    .done(function() {
        $(button).toggleClass("btn-danger");

        var buttonText = $(button).hasClass("btn-danger") ? "DELETE" : "DELETED";
        $(button).text(buttonText);
    });
}

function deleteAudio(audioId, button) {
    $.post("ajax/delete.php", { audioId: audioId })
    .done(function() {
        $(button).toggleClass("btn-danger");

        var buttonText = $(button).hasClass("btn-danger") ? "DELETE" : "DELETED";
        $(button).text(buttonText);
    });
}

function deleteMessage(messageId, button) {
    $.post("ajax/delete.php", { messageId: messageId })
    .done(function() {
        $(button).removeClass("btn-danger");

        var buttonText = $(button).hasClass("btn-danger") ? "DELETE" : "DELETED";
        $(button).text(buttonText);
    });
}

function makeFeature(videoId, button) {
    $.post("ajax/feature.php", { videoId: videoId })
    .done(function(count) {
        $(button).toggleClass("btn-info");

        var buttonText = $(button).hasClass("btn-info") ? "Make Feature" : "FEATURED";

        $(button).text(buttonText + " " + count);
    });
}
