function approve(requestId, button) {
    $.post("ajax/approve.php", { requestId: requestId })
    .done(function() {
        $(button).toggleClass("btn-success");

        var buttonText = $(button).hasClass("btn-success") ? "APPROVE" : "APPROVED";
        $(button).text(buttonText);
    });
}