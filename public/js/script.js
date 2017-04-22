$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    tourCategoryViewer();

    $('.video_player').on('click', function(){
        var videoSRC = $(this).attr("data-video"),
            videoSRCauto = videoSRC + "?autoplay=1";
        $('#video_modal iframe').attr('src', videoSRCauto);
        $('video_modal button.close').click(function () {
            $(theModal + ' iframe').attr('src', videoSRC);
        });
        $("#video_modal").on('hidden.bs.modal', function (e) {
            $("#video_modal iframe").attr("src", "");
        });
    });

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

