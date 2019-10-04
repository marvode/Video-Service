function load_audio_data(page) {
    $.ajax({
        url: "ajax/audio.php",
        method: "POST",
        data: {page: page},
        success: function(data) {
            $("#pagination_data").html(data);
            var page_item = "#page-item-" + page;
            $(page_item).addClass("active");
        },
    })
}
