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
        $.ajax({
            url: path,
            type: 'GET',
            success: function (data) {
                $('#tours_area').html(data);
            },
            error: function(error){
                $('body').html(error);
            }
        });
    })
}