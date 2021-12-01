$('.close.icon').on('click', function () {
    $(this).parent().transition('fade');
});


$('#searchicon')
    .on('click', function () {
        const searchrequest = $(this).prev('#searchbar').val();

        $.ajax({
            type: "POST",
            url: "/search/book",
            data: {value: searchrequest},
            success: function (response) {
                $('.container1').html(response.searchBook);
                console.log(response);
            },
            error: function (response) {
                console.log(response);
            }
        });

    });

$('#search_icon')
    .on('click', function () {
        var apisearch = $(this).prev('#search_bar').val();

        $.ajax({
            type: "POST",
            url: "/api/search",
            data: {sapi: apisearch},
            success: function (response) {
                $('.api').html(response);
            },
            error: function (response) {
                $('.api').html(response);
            }
        });

    });

<!-- Preloader -->
function loader() {
    $(document).on('click', '#news', function () {
        $.ajax({
            url:'/api/view',

            success:function (response){

            }
        })
    })
}
