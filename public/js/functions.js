$(document).ready( function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    dragDrop();

    toggleAreas();

    $('.add_day').on("click", function(){
        var container_en = $('#custom_day_container_en'),
            childrenCount = $(container_en).children().length,
            newCount = childrenCount + 1;

        $(container_en).append("<div class='custom_day'>"+
                                    "<label class='control-label col-md-3 col-sm-3 col-xs-12'>Day " + newCount+ "</label>"+
                                    "<div class='col-md-9 col-sm-9 col-xs-12 margin-b-10'>"+
                                        "<input type='text' class='form-control input-medium' name='custom_day_title_en[]' placeholder='title'>" +
                                    "</div>"+
                                    "<div class='col-md-9 col-sm-9 col-xs-12 margin-b-10 col-md-offset-3 col-sm-offset-3'>"+
                                        "<textarea class='resizable_textarea form-control' placeholder='' name='custom_day_desc_en[]'></textarea>"+
                                    "</div>" +
                                    "<div class='clearfix'></div>" +
                                "</div>");

        var container_ru = $('#custom_day_container_ru');

        $(container_ru).append("<div class='custom_day'>"+
                                    "<label class='control-label col-md-3 col-sm-3 col-xs-12'>Day " + newCount+ "</label>"+
                                    "<div class='col-md-9 col-sm-9 col-xs-12 margin-b-10'>"+
                                        "<input type='text' class='form-control input-medium' name='custom_day_title_ru[]' placeholder='title'>" +
                                    "</div>"+
                                    "<div class='col-md-9 col-sm-9 col-xs-12 margin-b-10 col-md-offset-3 col-sm-offset-3'>"+
                                        "<textarea class='resizable_textarea form-control' placeholder='' name='custom_day_desc_ru[]'></textarea>"+
                                    "</div>" +
                                    "<div class='clearfix'></div>" +
                                "</div>");

    });
    $('.remove_day').on("click", function(){
        var container_en = $('#custom_day_container_en'),
            childrenCount_en = $(container_en).children().length;
        if(childrenCount_en > 2){
            $(container_en).children().last().remove();
        }
        var container_ru = $('#custom_day_container_ru'),
        childrenCount_ru = $(container_ru).children().length;
        if(childrenCount_ru > 2){
            $(container_ru).children().last().remove();
        }
    });

    $("input[type='radio'][name=custom_day_prp]").on('change', function(){
        if($("input[type='radio'][name=custom_day_prp]:checked").val() == 'any'){
            $('.datepicker-container').hide();
        } else {
            $('.datepicker-container').show();
        }
    });
    $('#add_hotel').on("click", function(){
        var clone = $('.new_hotel').last().clone();
        $('.hotel-container').append(clone);
    });
    $('#remove_hotel').on("click", function(){
        var container = $('.hotel-container'),
            childrenCount = $(container).children().length;
        if(childrenCount > 1){
            $(container).children().last().remove();

        }
    });
    $(".tour-category-checkboxes input[type='checkbox'].basic").change(function(){
        toggleAreas();
    });

    $('.custom-image-remove-button').on('click', function(){
        var container = $(this).parent();
        var attributes = $(this).attr('id');
        var attrArray = attributes.split('?');
        $.ajax({
            url: '/admin/remove-image',
            type: 'POST',
            data: { 'type'          : attrArray[0],
                    'id'            : attrArray[1],
                    'image_type'    : attrArray[2],
                    'image_position': attrArray[3]
            },
            success: function (data) {
                console.log(data);
                if(data == 'true'){
                    $(container).fadeOut( "slow", function() {
                        $(container).parent('li').hide('slow');
                        $(container).parent('li').remove();
                    });
                } else {
                    console.log('error')
                }
            },
            error: function(error){
                $('body').html(error);
            }
        });

    });
    var d, container;
    $(".remove").on("click", function(){
        d = $(this).attr('id').split('/');
        container = $('#cnt-'+ d[0]);
        $("#cancel").on("click", function(){
            d = null;
            container = null;
        });
        $("#confirm").on("click", function(){
            alert('ok');
            $.ajax({
                url:'/admin/remove-data',
                type: 'POST',
                data: {
                    'id': d[0],
                    'param': d[1]
                },

                success: function (data) {
                    if(data == 'true'){
                        $('#delete_modal').modal('hide');
                        $(container).fadeOut( "slow", function() {
                            $(container).remove();
                        });
                    }
                },
                error: function(error){
                    $('body').html(error);
                }
            });
        });
    });


});

function toggleAreas(){
    var c = $('.tour-category-checkboxes input.custom');
    var checked = $("input[type='checkbox'].basic:checked").length;
    if(checked > 0){
        $(c).attr('checked', false);
        $(c).attr('disabled', 'disabled');
        $('.basic-field').show();
        $('.custom-field').hide();
    } else {
        $(c).removeAttr('disabled');
        $('.basic-field').hide();
        $('.custom-field').show();
    }
}
var droppedFiles = false;
var files;


function dragDrop() {
    var $form = $('.admin-image-label');
    $form.on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
    })
        .on('dragover dragenter', function() {
            $form.addClass('is-dragover');
        })
        .on('dragleave dragend drop', function() {
            $form.removeClass('is-dragover');
        })
        .on('drop', function(e) {
            droppedFiles = e.originalEvent.dataTransfer.files;
            $form.children('.admin-image-upload').prop('files', droppedFiles);
            // console.log(droppedFiles);
        })
        .on("change", '.admin-image-upload', function(){
            runReadingUrl($form, this);
            stopLoading();
        })
        .on('click','#clear-images', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $form.children('input.admin-image-upload').attr('type', '');
            $form.children('.admin-image-upload').attr('type', 'file');
            $('.drop-image').fadeOut(400, function(){ $(this).remove();});
        });

    // var par = $form.children('.admin-image-upload');
    // $(par).on("change", function(){
    //         readURL(this);
    // });
}

    function readURL(input) {
        $('.admin-image-label').addClass('loading');
        if (input.files && input.files[0]) {
        var counter = 0 ;
        var name;
        var fileCount;
        var newData = '';
        console.log(input.files);
        $(input.files).each(function () {
            var reader = new FileReader();
            name = this.name;
            reader.onload = function () {
                // $('.admin-image-label').append("<div id='d_i_" + counter +"' class='drop-image' style='display:none'><span data-id='"+ name +"'></span><img src='" + e.target.result + "'></div>");
                $('.admin-image-label').append("<div id='d_i_" + counter +"' class='drop-image'><img src='" + this.result + "'></div>")
            };
            counter++;
            reader.readAsDataURL(this);
        });
            $(input.files).promise().done(function() {
                console.log(newData);
                $('.admin-image-label').addClass('finished');
            });
        }
}

function runReadingUrl($form, $this) {
    readURL($this);
    $form.append("<button id='clear-images' class='btn btn-default' type='button'>Clear Drop Zone</button>");
}
function stopLoading() {
    $('.admin-image-label').removeClass('loading');
}

