$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.cropper-modal').on('click', function () {
        console.log('qaqaqaqa');
        var target = $('#cropper-modal');
        var $image = $(target).find('#image');
        var cropBoxData;
        var canvasData;
        var originSrc = $(this).next('img').attr('src');
        $image.attr('src', originSrc);

        $(target).on('shown.bs.modal', function () {
            $image.cropper({
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.65,
                restore: false,
                guides: false,
                highlight: false,
                cropBoxMovable: false,
                cropBoxResizable: false,
                ready: function () {
                    $image.cropper('setCanvasData', canvasData);
                    $image.cropper('setCropBoxData', cropBoxData);
                }
            });
            $('#save_cropped').on('click', function(){
               $.ajax({
                   url: '/update_cropped',
                   method: 'POST',
                   data: {
                       'source': originSrc,
                       'file': cropBoxData
                   },
                   success: function (data) {
                       $('body').html(data);
                   },
                   error: function (data) {
                       $('body').html(data);
                   }
               })
            });
        }).on('hidden.bs.modal', function () {
            cropBoxData = $image.cropper('getCropBoxData');
            canvasData = $image.cropper('getCanvasData');
            console.log(canvasData);
            $image.cropper('destroy');
        });
    });
});