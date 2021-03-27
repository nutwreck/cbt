<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="<?=config_item('_assets_general')?>summernote-0.8.18-dist/summernote-bs4.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/katex.min.js" integrity="sha384-FaFLTlohFghEIZkw6VGwmf9ISTubWAVYW8tG8+w2LAIftJEULZABrF9PPFv+tVkH" crossorigin="anonymous"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/contrib/auto-render.min.js" integrity="sha384-bHBqxz8fokvgoJ/sc17HODNxa42TlaEhB+w8ZJXTc2nZf1VgEaFZeZvT4Mznfz0v" crossorigin="anonymous" onload="renderMathInElement(document.body);"></script>
<script src="<?=config_item('_assets_general')?>js/math-katex.js"></script>

<!-- NAVIGASI TOOGLE SOAL -->
<script>
    function toggle_soal() {
        var cont = document.getElementById('panel-toogle-soal');
        if (cont.style.display == 'block') { //Jika panel ditampilkan dihide
            cont.style.display = 'none';
            document.getElementById('lembar_soal').className = 'col-sm-12 col-md-12 mb-3'; //Ganti Panjang Desai Lembar Soal
        }
        else { //jika panel dihide ditampilkan
            cont.style.display = 'block';
            document.getElementById('lembar_soal').className = 'col-sm-12 col-md-8 mb-3'; //Ganti Panjang Desai Lembar Soal
        }
    }
</script>

<!-- Amnil id soal pertama yang muncul berdasarkan sistem -->
<script>
    $( document ).ready(function() {
        if(document.getElementById("bank_soal_first_id") != null){
            var id_soal = document.getElementById('bank_soal_first_id').innerHTML;
            get_soal(id_soal, 1);
        }
    });
</script>

<script>
    $(function(){
        $('.form-soal').find('input[type=text],textarea').filter(':visible:first').focus();
    });
</script>

<!-- Untuk menampilkan nama file saat upload soal audio -->
<script>
    if (document.getElementById('#soal_audio') != null) 
        document.querySelector("#soal_audio").onchange = function(){
            document.querySelector("#file-name").textContent = this.files[0].name;
        }
</script>

<!-- PEMILIHAN PERGANTIAN VIEW TIPE SOAL -->
<script>
    function choosen_exam(){
        var type_exam = document.getElementById('pilihan_jenis_soal').value;
        var content_jawaban = document.getElementById('content_jawaban');
        var content_acak_jawaban_head = document.getElementById('content_acak_jawaban_head');
        var content_acak_jawaban_body = document.getElementById('content_acak_jawaban_body');
        if(type_exam == '1'){ //1 PILIHAN GANDA //2 ESSAY
            content_jawaban.style.display = 'block';
            content_acak_jawaban_head.style.display = 'block';
            content_acak_jawaban_body.style.display = 'block';
        } else {
            content_jawaban.style.display = 'none';
            content_acak_jawaban_head.style.display = 'none';
            content_acak_jawaban_body.style.display = 'none';
        }
    }
</script>

<!-- KATEX -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        renderMathInElement(document.body, {

        });
    });
</script>

<!-- SUMMERNOTE -->
<script>
    var id_paket_data = <?php echo base64_decode(urldecode($id_paket_soal)); ?>;
    var IMAGE_FOLDER = 'storage/website/lembaga/grandsbmptn/paket_soal/soal_'+id_paket_data+'/';
    function uploadFileEditor($summernote,file)
	{
        var csrfhash = document.getElementById('csrf-hash-form').value;
		var formData = new FormData();
		formData.append("file", file);
		formData.append("folder", IMAGE_FOLDER);
		formData.append('_token', '8c064f61a5d9059125ea94df78809fef');
        formData.append(csrfname, csrfhash);
        formData.append('id_paket_soal', id_paket_data);
		$.ajax({
			url: base_url+'website/lembaga/Tes_online/editor_soal',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			success: function (response) {
                obj = JSON.parse(response);
                document.getElementById('csrf-hash-form').value = obj.csrf;
				$summernote.summernote('insertImage', obj.link, function ($image) {
					$image.attr('src', obj.link);
				});
			}
		});
	}
    function deleteFileEditor(src) {
        var csrfhash = document.getElementById('csrf-hash-form').value;
        var formData = new FormData();
		formData.append("src", src);
        formData.append('_token', '8c064f61a5d9059125ea94df78809fef');
        formData.append(csrfname, csrfhash);
        formData.append('id_paket_soal', id_paket_data);
        $.ajax({
            data: formData,
            type: "POST",
            url: base_url+'website/lembaga/Tes_online/editor_soal_delete',
            cache: false,
            contentType: false,
			processData: false,
            success: function(response) {
                obj = JSON.parse(response);
                document.getElementById('csrf-hash-form').value = obj.csrf;
                /* console.log(obj.text); */
            }
        });
    }
    $('.summernote').summernote({
        dialogsInBody: true,
        dialogsFade: true,
        tabsize: 2,
        height: 200,
        codeviewFilter: false,
        codeviewIframeFilter: true,
        maximumImageFileSize:500000,
        toolbar: [
          ['style', ['style','fontname', 'fontsize', 'undo', 'redo']],
          ['font', ['bold', 'italic', 'underline', 'clear']],
          ['fontstyle', ['strikethrough', 'superscript', 'subscript']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture']],
          ['view', ['codeview']],
          ['katex', ['math']]
        ],
        callbacks: {
            onImageUpload: function (files) {
                uploadFileEditor($(this), files[0]);
            },
            onMediaDelete : function(target) {
                deleteFileEditor(target[0].src);
            }
        }
    });
    // @param {String} color
    $('.summernote').summernote('backColor', 'transparent');
    $('.summernote').summernote('foreColor', 'black');
</script>

<script>
    function get_soal(id_soal, no_soal){
        /* console.log(no_soal); */
        var obj;
        var csrfname = document.getElementById('csrf-name-form').innerHTML;
        var csrfhash = document.getElementById('csrf-hash-form').value;
        var paket_soal_id = document.getElementById('paket_soal_id').innerHTML;
        var formData = new FormData();
		formData.append("bank_soal_id", id_soal);
        formData.append("paket_soal_id", paket_soal_id);
        formData.append("nomor_soal", no_soal);
        formData.append("_token", '206b3a13a65afd2ea84090f6276d63f5');
        formData.append(csrfname, csrfhash);
        /* console.log(formData); */
        $.ajax({
            data: formData,
            type: "POST",
            url: base_url+'website/lembaga/Tes_online/get_detail_exam',
            cache: false,
            contentType: false,
			processData: false,
            success: function(response) {
                obj = JSON.parse(response);
                /* console.log(obj); */
                document.getElementById('csrf-hash-form').value = obj.csrf;
                //HEADER SOAL SHOW
                document.getElementById("header-soal").innerHTML = obj.header_soal;
                //CONTENT SOAL SHOW
                document.getElementById("content-soal").innerHTML = obj.content_soal;
                //JAWABAN SOAL SHOW
                document.getElementById("jawaban-soal").innerHTML = obj.jawaban_soal;
            }
        });
    }
</script>

<!-- Validasi Form Add -->
<script type = "text/javascript">
    function validate_addform(){
        if( document.formadd.jenis_soal.value == "-1" ) {
            document.getElementById('jenis_soal_er').innerHTML = 'Jenis soal wajib dipilih!';
            document.formadd.jenis_soal.focus();
            return false;
        }
        if( document.formadd.tipe_kesulitan.value == "-1" ) {
            document.getElementById('tipe_kesulitan_er').innerHTML = 'Tipe kesulitan wajib dipilih!';
            document.formadd.tipe_kesulitan.focus();
            return false;
        }
        return( true );
    }
</script>