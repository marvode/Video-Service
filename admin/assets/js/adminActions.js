function approve(requestId, button) {
    $.post("ajax/approve.php", { requestId: requestId })
    .done(function() {
        $(button).toggleClass("btn-success");

        var buttonText = $(button).hasClass("btn-success") ? "APPROVE" : "APPROVED";
        $(button).text(buttonText);
        window.location.reload();
    });
}

function deleteFile(videoId, button) {
    $.post("ajax/delete.php", { videoId: videoId })
    .done(function() {
        $(button).toggleClass("btn-danger");

        var buttonText = $(button).hasClass("btn-danger") ? "DELETE" : "DELETED";
        $(button).text(buttonText);
        window.location.reload();
    });
}

function load_data(page) {
    $.ajax({
        url: "ajax/pagination.php",
        method: "POST",
        data: {page: page},
        success: function(data) {
            $("#pagination_data").html(data);
            var page_item = "#page-item-" + page;
            $(page_item).addClass("active");
        }
    })
}

function deleteAudio(audioId, button) {
    $.post("ajax/delete.php", { audioId: audioId })
    .done(function() {
        $(button).toggleClass("btn-danger");

        var buttonText = $(button).hasClass("btn-danger") ? "DELETE" : "DELETED";
        $(button).text(buttonText);
        window.location.reload();
    });
}

function deleteMessage(messageId, button) {
    $.post("ajax/delete.php", { messageId: messageId })
    .done(function() {
        $(button).removeClass("btn-danger");

        var buttonText = $(button).hasClass("btn-danger") ? "DELETE" : "DELETED";
        $(button).text(buttonText);
        window.location.reload();
    });
}

function makeFeature(videoId, button) {
    $.post("ajax/feature.php", { videoId: videoId })
    .done(function(count) {
        $(button).toggleClass("btn-info");

        var buttonText = $(button).hasClass("btn-info") ? "Make Feature" : "FEATURED";

        $(button).text(buttonText + " " + count);
        window.location.reload();
    });
}
