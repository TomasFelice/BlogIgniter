$('div.list-categories a').click(function() {
    $('button.list-categories').text($(this).text());
    $('button.list-categories').attr('data-id', $(this).attr('data-id'));
});

$('.btn-search-post').click(function() {
    search($('input-search-post').val(), $('button.list-categories').attr('data-id'));
});

function search(search, category_id) {
    $.ajax({
        url: BASE_URL + 'blog/search',
        type: 'GET',
        data: {
            search: search,
            category_id: category_id
        },
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