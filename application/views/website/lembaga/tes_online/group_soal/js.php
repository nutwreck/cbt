<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="<?=config_item('_assets_general')?>summernote-0.8.18-dist/summernote-bs4.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/katex.min.js" integrity="sha384-FaFLTlohFghEIZkw6VGwmf9ISTubWAVYW8tG8+w2LAIftJEULZABrF9PPFv+tVkH" crossorigin="anonymous"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/contrib/auto-render.min.js" integrity="sha384-bHBqxz8fokvgoJ/sc17HODNxa42TlaEhB+w8ZJXTc2nZf1VgEaFZeZvT4Mznfz0v" crossorigin="anonymous" onload="renderMathInElement(document.body);"></script>
<script src="<?=config_item('_assets_general')?>js/math-katex.js"></script>

<script>
    $(document).ready(function() {
        $('#table_group').DataTable( {
            
        } );
    } );

    function add_data() {
        window.location.href = "<?php echo base_url(); ?>admin/add-group-soal/<?php echo $id_paket_soal; ?>";
    }

    function paket_soal_page(){
        window.location.href = "<?php echo base_url(); ?>admin/paket-soal";
    }

    //Limit Audio
    var loopLimit = 1;
    var loopCounter = 0;
    document.getElementById('loop-limited').addEventListener('ended', function(){
        if (loopCounter < loopLimit){
            this.currentTime = 0;
            this.play();
            loopCounter++;
        } else {
            var ply = document.getElementById('loop-limited');
            var oldSrc = ply.src;
            ply.src = "";
        }
    }, false);
</script>

<!-- SUMMERNOTE -->
<script>
    var id_paket_data = <?php echo base64_decode(urldecode($id_paket_soal)); ?>;
    var IMAGE_FOLDER = 'storage/website/lembaga/grandsbmptn/group_soal/group_'+id_paket_data+'/';
    function uploadFileEditor($summernote,file)
	{
        var csrfhash = document.getElementById('csrf-hash-form').value;
		var formData = new FormData();
		formData.append("file", file);
		formData.append("folder", IMAGE_FOLDER);
		formData.append('_token', '6bdb7093cb56431ead841dd8ce53f3b7');
        formData.append(csrfname, csrfhash);
        formData.append('id_paket_soal', id_paket_data);
		$.ajax({
			url: base_url+'website/lembaga/Tes_online/editor_group_soal',
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
        formData.append('_token', '6bdb7093cb56431ead841dd8ce53f3b7');
        formData.append(csrfname, csrfhash);
        formData.append('id_paket_soal', id_paket_data);
        $.ajax({
            data: formData,
            type: "POST",
            url: base_url+'website/lembaga/Tes_online/editor_group_soal_delete',
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
    if(document.getElementById("id_group_soal") != null){
        $('.summernote').summernote('code');
    }
</script>

<!-- Untuk menampilkan nama file saat upload soal audio -->
<script>
    if (document.getElementById('audio_group') != null) 
        document.querySelector("#audio_group").onchange = function(){
            document.querySelector("#file-name").textContent = this.files[0].name;
        }
</script>

<script>
    $(function(){
        $('.form-group').find('input[type=text],textarea').filter(':visible:first').focus();
    });
</script>