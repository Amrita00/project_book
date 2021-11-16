$('.close.icon').on('click', function () {
    $(this).parent().transition('fade');
});


$('#searchicon')
    .on('click', function () {
        var searchrequest = $(this).prev('#searchbar').val();

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


