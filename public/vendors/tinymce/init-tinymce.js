tinymce.init({
    selector: "textarea.tinymce",
    height: 300,
    theme: 'modern',
    plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern '
],
    toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ',
    toolbar2: 'print preview media | forecolor backcolor emoticons | imageupload',
    templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
],
    content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
],
    file_picker_types: 'file image media',
    setup: function(editor) {
        var inp = $('<input id="tinymce-uploader" type="file" name="pic" accept="image/*" style="display:none">');
        $(editor.getElement()).parent().append(inp);

        inp.on("change",function(){
            var input = inp.get(0);
            var file = input.files[0];
            var fr = new FileReader();
            fr.onload = function() {
                var img = new Image();
                img.src = fr.result;
                editor.insertContent('<img src="'+img.src+'"/>');
                inp.val('');
            };
            fr.readAsDataURL(file);
        });

        editor.addButton( 'imageupload', {
            text: false,
            icon: "image",
            onclick: function(e) {
                inp.trigger('click');
            }
        });
    }
});
