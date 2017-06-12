Dropzone.options.toursImagesDropzone = {
    url: '/admin/new-tour',
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

        });
        this.on("success", function(file, xhr){
            window.location.replace(file.xhr.response);
        })
    }
};