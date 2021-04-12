<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="<?=config_item('_assets_general')?>summernote-0.8.18-dist/summernote-bs4.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/katex.min.js" integrity="sha384-FaFLTlohFghEIZkw6VGwmf9ISTubWAVYW8tG8+w2LAIftJEULZABrF9PPFv+tVkH" crossorigin="anonymous"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/contrib/auto-render.min.js" integrity="sha384-bHBqxz8fokvgoJ/sc17HODNxa42TlaEhB+w8ZJXTc2nZf1VgEaFZeZvT4Mznfz0v" crossorigin="anonymous" onload="renderMathInElement(document.body);"></script>
<script src="<?=config_item('_assets_general')?>js/math-katex.js"></script>

<script>
    $(document).ready(function() {
        $('#table_bacaan').DataTable( {
            
        } );
    } );

    function add_data() {
        window.location.href = "<?php echo base_url(); ?>admin/add-bacaan-soal/<?php echo $id_paket_soal; ?>";
    }

    function paket_soal_page(){
        window.location.href = "<?php echo base_url(); ?>admin/paket-soal";
    }
</script>

<!-- SUMMERNOTE -->
<script>
    var id_paket_data = <?php echo base64_decode(urldecode($id_paket_soal)); ?>;
    var IMAGE_FOLDER = 'storage/website/lembaga/grandsbmptn/bacaan_soal/bacaan_'+id_paket_data+'/';
    function uploadFileEditor($summernote,file)
	{
        var csrfhash = document.getElementById('csrf-hash-form').value;
		var formData = new FormData();
		formData.append("file", file);
		formData.append("folder", IMAGE_FOLDER);
		formData.append('_token', '4cdf658a25ff361d2618b233e0b66f3f');
        formData.append(csrfname, csrfhash);
        formData.append('id_paket_soal', id_paket_data);
		$.ajax({
			url: base_url+'website/lembaga/Tes_online/editor_bacaan_soal',
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
        formData.append('_token', '4cdf658a25ff361d2618b233e0b66f3f');
        formData.append(csrfname, csrfhash);
        formData.append('id_paket_soal', id_paket_data);
        $.ajax({
            data: formData,
            type: "POST",
            url: base_url+'website/lembaga/Tes_online/editor_bacaan_soal_delete',
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
    if(document.getElementById("id_bacaan_soal") != null){
        $('.summernote').summernote('code');
    }
</script>