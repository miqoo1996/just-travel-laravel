$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    tourCategoryViewer();
    searchTours();
    tourDetailSearch();

    $('.video_player').on('click', function () {
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

function tourCategoryViewer() {
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
            error: function (error) {
                $('body').html(error);
            }
        });
    })
}
function searchTours() {
    $('#search_tours').on("click", function () {
        var par = $('#tour_search_index');
        var category = $(par).find('#tour_category_selector').find("option:selected").attr('value'),
            date_start = $(par).find('#date_start').val(),
            date_end = $(par).find('#date_end').val(),
            tags = $(par).find('#tags').val();
        $.ajax({
            url: '/main_search',
            type: 'POST',
            data: {
                'category': category,
                'date_start': date_start,
                'date_end': date_end,
                'tags': tags
            }
            ,
            success: function (data) {
                $('body').html(data);
            }
        });
    })
}

function tourDetailSearch() {

    var par = $('#custom_deatils_search');
    $(par).find('#detail_search').on("click", function () {
        var date_from = $(par).find('#date_from').val(),
            adult = $(par).find('#adult').val(),
            child = $(par).find('#child').val(),
            infant = $(par).find('#infant').val(),
            tour_id = $(par).find('#tour_id').val();
        $.ajax({
            url: '/tour_detail_search',
            type: 'POST',
            data: {
                'date_from': date_from,
                'adult': adult,
                'child': child,
                'infant': infant,
                'tour_id': tour_id
            },
            success: function (data) {
                console.log(data);
                $('#search_res_container').html(data);
            },
            error: function (data) {
                $('body').html(data);
            }
        });
    });

}

