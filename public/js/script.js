$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    tourCategoryViewer();
});

function tourCategoryViewer(){
    $('.tc-viewer').on('click', function () {
        var path = $(this).attr('id');
        var parent = $(this).parent('li');
        $.ajax({
            url: path,
            type: 'GET',
            success: function (data) {
                $('#tours_area').html(data);
                $('.mp-categories.fixme li.active').removeClass('active');
                $(parent).addClass('active');
            },
            error: function(error){
                $('body').html(error);
            }
        });
    })
}