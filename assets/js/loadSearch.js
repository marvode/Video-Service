function load_search_video_data(search, orderBy, page) {
    console.log(search);
    $.ajax({
        url: "ajax/search.php",
        method: "POST",
        data: {search: search, orderBy: orderBy, page: page},
        success: function(data) {
            $("#pagination_data").html(data);
            var page_item = "#page-item-" + page;
            $(page_item).addClass("active");
        },
    })
}

function load_search_audio_data(search, page) {
    console.log(search);
    $.ajax({
        url: "ajax/searchaudio.php",
        method: "POST",
        data: {search: search, page: page},
        success: function(data) {
            $("#pagination_data").html(data);
            var page_item = "#page-item-" + page;
            $(page_item).addClass("active");
        },
    })
}
