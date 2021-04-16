<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script src="<?=config_item('_assets_general')?>summernote-0.8.18-dist/summernote-bs4.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_materi').DataTable( {
            
        } );
        var content_jawaban = document.getElementById('content_jawaban');
        var upload_gambar = document.getElementById('upload_gambar');
        var upload_audio = document.getElementById('upload_audio');
        var upload_video = document.getElementById('upload_video');
        var upload_text = document.getElementById('upload_text');
        var upload_link = document.getElementById('upload_link');
        upload_gambar.style.display = 'none';
            upload_audio.style.display = 'none';
            upload_video.style.display = 'none';
            upload_text.style.display = 'none';
            upload_link.style.display = 'none';

    } );

    function add_data() {
        
        window.location.href = "<?php echo base_url(); ?>admin/add-video" ;
    }
    function add_gambar() {
        
        window.location.href = "<?php echo base_url(); ?>admin/add-gambar" ;
    }
    function add_data_detail() {
        var data = '<?php if(isset($data_id)){ echo $data_id; } else{}?>';
      
        window.location.href = "<?php echo base_url(); ?>admin/add-detail-konversi/" + data;
    }
    function import_excel() {
        window.location.href = "<?php echo base_url(); ?>admin/add-import-konversi";
    }
</script>
<script>
    function choosen_exam(){
        var type_exam = document.getElementById('pilihan_jenis_soal').value;
        var content_jawaban = document.getElementById('content_jawaban');
        var upload_gambar = document.getElementById('upload_gambar');
        var upload_audio = document.getElementById('upload_audio');
        var upload_video = document.getElementById('upload_video');
        var upload_text = document.getElementById('upload_text');
        var upload_link = document.getElementById('upload_link');
        if(type_exam == '1'){ 
            upload_gambar.style.display = 'block';
            upload_audio.style.display = 'none';
            upload_video.style.display = 'none';
            upload_text.style.display = 'none';
            upload_link.style.display = 'none';
           
        } else if (type_exam == '2') {
            upload_gambar.style.display = 'none';
            upload_audio.style.display = 'block';
            upload_video.style.display = 'none';
            upload_text.style.display = 'none';
            upload_link.style.display = 'none';
        }  else if (type_exam == '3') {
            upload_gambar.style.display = 'none';
            upload_audio.style.display = 'none';
            upload_video.style.display = 'block';
            upload_text.style.display = 'none';
            upload_link.style.display = 'none';
        }
        else if (type_exam == '4') {
            upload_gambar.style.display = 'none';
            upload_audio.style.display = 'none';
            upload_video.style.display = 'none';
            upload_text.style.display = 'block';
            upload_link.style.display = 'none';
        }
        else if (type_exam == '5') {
            upload_gambar.style.display = 'none';
            upload_audio.style.display = 'none';
            upload_video.style.display = 'none';
            upload_text.style.display = 'none';
            upload_link.style.display = 'block';
        } 
        else{
            upload_gambar.style.display = 'none';
            upload_audio.style.display = 'none';
            upload_video.style.display = 'none';
            upload_text.style.display = 'none';
            upload_link.style.display = 'none';

        }
    
    }
</script>
<!-- Info Close -->
<script>
    function close_info() {
        var cont = document.getElementById('info_user');
        cont.style.display = 'none';
        document.getElementById('content_add').className = 'col-lg-6'; //Ganti ukuran form add
    }
</script>

<!-- Validasi Form Add -->
<script type = "text/javascript">
    function validate_addform(){
        if( document.formadd.materi.value == "" ) {
            document.getElementById('materi_er').innerHTML = 'Wajib diisi!';
            document.formadd.materi.focus() ;
            return false;
        }
        return( true );
    }
</script>

<!-- Validasi Form Edit -->
<script type = "text/javascript">
    function validate_editform(){
        if( document.formedit.materi.value == "" ) {
            document.getElementById('materi_er').innerHTML = 'Wajib diisi!';
            document.formedit.materi.focus() ;
            return false;
        }
        return( true );
    }
</script>
<script>

var id_paket_data = <?php echo base64_decode(urldecode($id_buku)); ?>;
    var IMAGE_FOLDER = 'storage/website/lembaga/grandsbmptn/modul/soal_'+id_paket_data+'/';
    function uploadFileEditor($summernote,file)
	{
        var csrfhash = document.getElementById('csrf-hash-form').value;
		var formData = new FormData();
		formData.append("file", file);
		formData.append("folder", IMAGE_FOLDER);
		formData.append('_token', '586b4cca03255330f4da77001ebbfd67');
        formData.append(csrfname, csrfhash);
        formData.append('id_paket_soal', id_paket_data);
		$.ajax({
			url: base_url+'website/lembaga/Buku_setting/editor_modul',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			type: 'POST',
			success: function (response) {
                obj = JSON.parse(response);
                document.getElementById('csrf-hash-form-text').value = obj.csrf;
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
        formData.append('_token', '586b4cca03255330f4da77001ebbfd67');
        formData.append(csrfname, csrfhash);
        formData.append('id_paket_soal', id_paket_data);
        $.ajax({
            data: formData,
            type: "POST",
            url: base_url+'website/lembaga/Buku_setting/editor_modul_delete',
            cache: false,
            contentType: false,
			processData: false,
            success: function(response) {
                obj = JSON.parse(response);
                document.getElementById('csrf-hash-form-text').value = obj.csrf;
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
    if(document.getElementById("id_bank_soal") != null){
        $('.summernote').summernote('code');
    }
</script>