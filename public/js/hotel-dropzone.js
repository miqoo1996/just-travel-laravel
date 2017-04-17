

Dropzone.options.hotelImagesDropzone = {
    url: '/admin/new-hotel',
    // Prevents Dropzone from uploading dropped files immediately
    autoProcessQueue: false,
    uploadMultiple: true,
    hiddenInputContainer: '#dropzone-hidden-area',
    parallelUploads: 20,
    init: function() {
        var myDropzone = this;

        // Here's the change from enyo's tutorial...

        $("#submit-hotel").click(function (e) {
                if (myDropzone.getQueuedFiles().length > 0) {
                    myDropzone.processQueue();
                    e.preventDefault();
                    e.stopPropagation();
                } else {
                    myDropzone.uploadFiles([]); //send empty
                }
            });

        this.on("sending", function(file, xhr, formData){
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                var checkboxes = $(".region input[type='checkbox']");
                $(checkboxes).each(function () {
                     if($(this).prop('checked')){
                         formData.append($(this).attr('name'), $(this).attr('name'));
                     }
                });
                var textInputs = $("form input[type='text']");
                var value;
                $(textInputs).each(function () {
                    if(typeof $(this).attr('value') == 'undefined') {
                        value = '';
                    } else {
                        value = $(this).attr('value');
                    }
                    formData.append($(this).attr('name'), value);
                });

                var textAreas = $("form textarea");
                    $(textAreas).each(function () {
                        if(typeof $(this).val() == 'undefined') {
                            value = '';
                        } else {
                            value = $(this).val();
                        }
                        formData.append($(this).attr('name'), value);
                    });
                var visible = $('#visibility');
                var visibleProp = 'off';
                if($(visible).prop('checked')){
                    visibleProp = 'on';
                }
                formData.append('visibility', visibleProp);
                formData.append('main_image', $('#main_image').prop('files')[0]);
                formData.append('type', $('#type').val());
                formData.append('desc_en', $('#editor-en').html());
                formData.append('desc_ru', $('#editor-ru').html());


        });
            this.on("success", function(file, xhr){
                window.location.replace(file.xhr.response);
            })
    }
};