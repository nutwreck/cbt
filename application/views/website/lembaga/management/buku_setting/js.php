<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="<?=config_item('_assets_general')?>summernote-0.8.18-dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_setting_buku').DataTable( {
            
        } );
        
        if(document.getElementById("pilihan_jenis_modul") != null){
            disable_all_form();
        }
    } );
    function add_data_detail() {
        var data = '<?php if(isset($id_buku)){ echo $id_buku; } else{}?>';
        var data_dua = '<?php if(isset($id_config_buku)){ echo $id_config_buku; } else{}?>';
        var data_tiga = '<?php if(isset($id_config_buku_group)){ echo $id_config_buku_group; } else{}?>';
        window.location.href = "<?php echo base_url(); ?>admin/add-detail-buku/" + data + '/' + data_dua + '/' + data_tiga;
    }
    function add_group_modul() {
        var data = '<?php if(isset($id_buku)){ echo $id_buku; } else{}?>';
        var data_dua = '<?php if(isset($config_buku_id)){ echo $config_buku_id; } else{}?>';
        window.location.href = "<?php echo base_url(); ?>admin/add-group-buku/" + data + '/' + data_dua;
    }
    function disable_all_form(){
        var upload_gambar = document.getElementById('upload_gambar');
        var upload_audio = document.getElementById('upload_audio');
        var upload_video = document.getElementById('upload_video');
        var upload_text = document.getElementById('upload_text');
        var upload_link = document.getElementById('upload_link');
        var upload_file = document.getElementById('upload_file');
        upload_gambar.style.display = 'none';
        upload_audio.style.display = 'none';
        upload_video.style.display = 'none';
        upload_text.style.display = 'none';
        upload_link.style.display = 'none';
        upload_file.style.display = 'none';
    }
</script>

<script>
    function choosen_type(){
        var type = document.getElementById('pilihan_jenis_modul').value;
        var upload_gambar = document.getElementById('upload_gambar');
        var upload_audio = document.getElementById('upload_audio');
        var upload_video = document.getElementById('upload_video');
        var upload_text = document.getElementById('upload_text');
        var upload_link = document.getElementById('upload_link');
        var upload_file = document.getElementById('upload_file');
        if(type == '1'){ 
            upload_gambar.style.display = 'block';
            upload_audio.style.display = 'none';
            upload_video.style.display = 'none';
            upload_text.style.display = 'none';
            upload_link.style.display = 'none';
            upload_file.style.display = 'none';
        } else if (type == '2') {
            upload_gambar.style.display = 'none';
            upload_audio.style.display = 'block';
            upload_video.style.display = 'none';
            upload_text.style.display = 'none';
            upload_link.style.display = 'none';
            upload_file.style.display = 'none';
        } else if (type == '3') {
            upload_gambar.style.display = 'none';
            upload_audio.style.display = 'none';
            upload_video.style.display = 'block';
            upload_text.style.display = 'none';
            upload_link.style.display = 'none';
            upload_file.style.display = 'none';
        } else if (type == '4') {
            upload_gambar.style.display = 'none';
            upload_audio.style.display = 'none';
            upload_video.style.display = 'none';
            upload_text.style.display = 'none';
            upload_link.style.display = 'none';
            upload_file.style.display = 'none';
        }
        else if (type == '5') {
            upload_gambar.style.display = 'none';
            upload_audio.style.display = 'none';
            upload_video.style.display = 'none';
            upload_text.style.display = 'none';
            upload_link.style.display = 'block';
            upload_file.style.display = 'none';
        } 
        else if (type == '6') {
            upload_gambar.style.display = 'none';
            upload_audio.style.display = 'none';
            upload_video.style.display = 'none';
            upload_text.style.display = 'none';
            upload_link.style.display = 'none';
            upload_file.style.display = 'block';
        }
        else{
            upload_gambar.style.display = 'none';
            upload_audio.style.display = 'none';
            upload_video.style.display = 'none';
            upload_text.style.display = 'none';
            upload_link.style.display = 'none';
            upload_file.style.display = 'none';
        }
    }
</script>

<script>
    var id_buku = <?php if(isset($id_buku)) { echo base64_decode(urldecode($id_buku)); } else { echo 0; } ; ?>;
    var IMAGE_FOLDER = 'storage/website/lembaga/grandsbmptn/modul/buku_'+id_buku+'/';
    function uploadFileEditor($summernote,file)
	{
        var csrfhash = document.getElementById('csrf-hash-form-text').value;
		var formData = new FormData();
		formData.append("file", file);
		formData.append("folder", IMAGE_FOLDER);
		formData.append('_token', '586b4cca03255330f4da77001ebbfd67');
        formData.append(csrfname, csrfhash);
        formData.append('id_buku', id_buku);
		$.ajax({
			url: base_url+'website/lembaga/Management/editor_modul',
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
        var csrfhash = document.getElementById('csrf-hash-form-text').value;
        var formData = new FormData();
		formData.append("src", src);
        formData.append('_token', '586b4cca03255330f4da77001ebbfd67');
        formData.append(csrfname, csrfhash);
        formData.append('id_buku', id_buku);
        $.ajax({
            data: formData,
            type: "POST",
            url: base_url+'website/lembaga/Management/editor_modul_delete',
            cache: false,
            contentType: false,
			processData: false,
            success: function(response) {
                obj = JSON.parse(response);
                document.getElementById('csrf-hash-form-text').value = obj.csrf;
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
          ['view', ['codeview']]
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

<!-- Fokus pada inputan pertama ketika halaman form add di load -->
<script>
    $(function(){
        $('#form-edit-buku').find('input[type=text],textarea').filter(':visible:first').focus();
    });
</script>

<!-- Fungsi summernote descripsi buku -->
<script>
    $('#summernote-buku').summernote({
        placeholder: 'Masukkan deskripsi buku, ini akan dimunculkan ketika user membeli produk buku',
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
          ['insert', ['link']],
        ]
    });
    // @param {String} color
    $('#summernote-buku').summernote('backColor', 'transparent');
    $('#summernote-buku').summernote('foreColor', 'black');
</script>