$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.cropper-modal').on('click', function () {
        var target = $('#cropper-modal');
        var $image = $(target).find('#image');
        var originSrc = $(this).next('img').attr('src');
        var prop = $(this).attr('id');
        var sWidth;
        var sHeight;
        var cs;
        switch (prop){
            case'gallery':
                sWidth = 840;
                sHeight = 480;
                cs = 'viewport';

                break;
            case'main-image':
                sWidth = 600;
                sHeight = 343;
                cs = 'viewport';
                break;
            case'hot':
                sWidth = 960;
                sHeight = 275;
                cs = 'natural';
                break;
        }

        $image.attr('src', originSrc);
        var result;
        $(target).on('shown.bs.modal', function () {
            result = $($image).croppie({
                viewport: {
                    width: sWidth,
                    height: sHeight
                }
            });
            $('#save_cropped').on('click', function () {
                result.bind({orientation: 4,zoom: 0});
                result.croppie('result', {size: cs ,type: 'blob'}).then(function (blob) {
                    var fd = new FormData();
                    fd.append('source', originSrc);
                    fd.append('data', blob);
                    $.ajax({
                        url: '/update_cropped',
                        method: 'POST',
                        data: fd,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            result.croppie('destroy');
                            location.reload();
                        }
                    });
                });
            });
        }).on('hidden.bs.modal', function () {
            $('#cropper-modal').html("<div class='modal-dialog' role='document'>" +
                "<div class='modal-content'><div class='modal-header'>" +
                "<h5 class='modal-title' id='modalLabel'>Crop the image</h5>" +
                "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>" +
                "<span aria-hidden='true'>&times;</span></button></div><div class='modal-body'>" +
                "<div class='image-container'>" +
                "<img id='image' src='http://justtravel.dev/images/gallery/1/content/58ff118e14ce1.jpg' alt='Picture'>" +
                "</div></div><div class='modal-footer'>" +
                "<button type='button' class='btn btn-default' data-dismiss='modal' id='cancel_croppie'>Close</button>" +
                "<button type='button' class='btn btn-success' id='save_cropped'>Save</button></div></div></div>")});
    });
});
