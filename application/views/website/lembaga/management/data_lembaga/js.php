<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<!-- Fungsi summernote -->
<script>
    $('.summernote').summernote({
        dialogsInBody: true,
        dialogsFade: true,
        tabsize: 2,
        height: 200,
        codeviewFilter: false,
        codeviewIframeFilter: true,
        toolbar: [
          ['style', ['style','fontname', 'fontsize', 'undo', 'redo']],
          ['font', ['bold', 'italic', 'underline', 'clear']],
          ['fontstyle', ['strikethrough', 'superscript', 'subscript']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['link']]
        ]
    });
    // @param {String} color
    $('.summernote').summernote('backColor', 'transparent');
    $('.summernote').summernote('foreColor', 'black');
</script>

<!-- Validasi Form add -->
<script>
    function validate_form(){
        var emailID = document.formdata.email.value;
        atpos = emailID.indexOf("@");
        dotpos = emailID.lastIndexOf(".");
        
        if (atpos < 1 || ( dotpos - atpos < 2 )) {
            document.getElementById('email_er').innerHTML = 'Input Email dengan benar!';
            document.formdata.email.focus() ;
            return false;
        }
        if( document.formdata.lembaga_type_id.value == "-1" ) {
            document.getElementById('lembaga_type_id_er').innerHTML = 'Type lembaga wajib diisi!';
            document.formdata.lembaga_type_id.focus();
            return false;
        }
        if( document.formdata.kota_kab_id.value == "-1" ) {
            document.getElementById('kota_kab_id_er').innerHTML = 'Kota/kab wajib diisi!';
            document.formdata.kota_kab_id.focus();
            return false;
        }
        return( true );
    }
</script>