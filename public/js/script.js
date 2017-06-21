$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    tourCategoryViewer();
    searchTours();
    tourDetailSearch();
    tourHotelPay();

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

    $('#adult, #child, #infant').on('input', function () {
        var value = parseInt(this.value);
        if (value < 0) {
            value = 0;
        }
        this.value = value;
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
        var par = $('form');
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
                $('#tours_area').html(data);
            }
        });
    })
}
var date_from = null,
    adult = 1,
    child = 0,
    infant = 0,
    tour_id = null;
function tourDetailSearch() {
    var par = $('#custom_deatils_search');
    $(par).find('#detail_search').on("click", function () {
        date_from = $(par).find('#date_from').val();
        if (!date_from) {
            $(par).find('#date_from').focus();
            return false;
        }
        adult = $(par).find('#adult').val();
        if (adult < 1) {
            $(par).find('#adult').val('1');
        }
        child = $(par).find('#child').val();
        if (child <= 0) {
            $(par).find('#child').val('');
        }
        infant = $(par).find('#infant').val();
        if (infant <= 0) {
            $(par).find('#infant').val('');
        }
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
                $('#search_res_container').html(data);
            },
            error: function (data) {
                $('body').html(data);
            }
        });
    });
    $('.filter-details form').submit(function () {
        var $date_from = $("#date_from");
        if (!$date_from.val()) {
            $date_from.focus();
            return false;
        }
    })
}


function tourHotelPay(){
    $('#search_res_container').on('click', 'button.hotel-payment-button',function () {
        if(('' !== date_from) && (typeof tour_id !== 'undefined')){
            console.log(date_from);
            var htdata = $(this).attr('htdata');
             $.ajax({
                url: '/order_tour',
                type: 'POST',
                data: {
                    'htdata' : htdata,
                    'date_from': date_from,
                    'adults_count': adult,
                    'children_count': child,
                    'infants_count': infant,
                    'tour_id': tour_id
                },
                success: function (data) {
                    window.location.href = 'http://'+ document.location.hostname + "/order_tour/" + data;

                },
                error: function (data) {
                    $('body').html(data);
                }
            });
        }

    });
}
function setTimeZone() {
    var tz = new Date().getTimezoneOffset();
    $.ajax({
        url: '/set_guest_timezone',
        type: 'POST',
        data: {
            'tz': tz
        },
        success: function (data) {
            var show;
            if(data > 0) {
                show = '+ ' + data;
            } else {
                show = data;
            }
            console.log('timezone set ' + show);
        },
        error: function () {
            console.log('timezone error');
        }
    });
}
