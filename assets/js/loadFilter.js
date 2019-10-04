function load_category_data(category, page) {
    $.ajax({
        url: "ajax/filter.php",
        method: "POST",
        data: {category: category, page: page},
        success: function(data) {
            $("#pagination_data").html(data);
            var page_item = "#page-item-" + page;
            $(page_item).addClass("active");
        },
    })
}

function load_language_data(category, language, page) {
    $.ajax({
        url: "ajax/filter.php",
        method: "POST",
        data: {category: category, language: language, page: page},
        success: function(data) {
            $("#pagination_data").html(data);
            var page_item = "#page-item-" + page;
            $(page_item).addClass("active");
        },
    })
}
