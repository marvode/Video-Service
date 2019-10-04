function load_video_data(profileUsername, page) {
    $.ajax({
        url: "ajax/profileVideoPagination.php",
        method: "POST",
        data: {profileUsername: profileUsername, page: page},
        success: function(data) {
            $("#pagination_data").html(data);
            var page_item = "#page-item-" + page;
            $(page_item).addClass("active");
        },
    })
}
