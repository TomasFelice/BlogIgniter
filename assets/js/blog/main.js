$('div.list-categories a').click(function() {
    $('button.list-categories').text($(this).text());
    $('button.list-categories').attr('data-id', $(this).attr('data-id'));
});

$('.btn-search-post').click(function() {
    search($('.input-search-post').val(), $('button.list-categories').attr('data-id'));
});

function search(search, category_id) {
    $.ajax({
        url: BASE_URL + 'blog/search',
        data: {
            search: search,
            category_id: category_id
        },
        type: 'GET',
        success: function(posts) {
            $('#post_search').html(posts);
        },
        error: function() {
            $.toaster({
                message: 'Intente nuevamente',
                title: 'Error',
                priority: 'warning'
            })
        }
    });
}

/* Favoritos */

$('.favorite-post').click(function() {
    favorite($(this).attr('data-id'));
});

function favorite(post_id) {

    token_url = "favorite_delete";
    if ($(".favorite-post[data-id=" + post_id + "]").hasClass("fa-heart-o"))
        token_url = "favorite_save";

    $.ajax({
        url: BASE_URL + "blog/" + token_url + "/" + post_id,
        type: 'GET',
        success: function (post_id) {
            if ($(".favorite-post[data-id=" + post_id + "]").hasClass("fa-heart-o")) {
                $(".favorite-post[data-id=" + post_id + "]").removeClass("fa-heart-o");
                $(".favorite-post[data-id=" + post_id + "]").addClass("fa-heart");
            } else {
                $(".favorite-post[data-id=" + post_id + "]").addClass("fa-heart-o");
                $(".favorite-post[data-id=" + post_id + "]").removeClass("fa-heart");
            }
        }
        ,
        error: function () {
            $.toaster({priority: 'warning', title: 'Error', message: 'Intente nuevamente'});
        }
    }
    );
}