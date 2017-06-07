tinymce.init({
    selector: '.tinymce',
    toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | table | fontsizeselect | imageupload",
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
            text:"IMAGE",
            icon: false,
            onclick: function(e) {
                inp.trigger('click');
            }
        });
    }
});