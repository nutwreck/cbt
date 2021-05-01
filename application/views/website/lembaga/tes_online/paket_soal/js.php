<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/katex.min.js" integrity="sha384-FaFLTlohFghEIZkw6VGwmf9ISTubWAVYW8tG8+w2LAIftJEULZABrF9PPFv+tVkH" crossorigin="anonymous"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/contrib/auto-render.min.js" integrity="sha384-bHBqxz8fokvgoJ/sc17HODNxa42TlaEhB+w8ZJXTc2nZf1VgEaFZeZvT4Mznfz0v" crossorigin="anonymous" onload="renderMathInElement(document.body);"></script>
<script src="<?=config_item('_assets_general')?>js/math-katex.js"></script>

<script>
    $(document).ready(function() {
        $('#table_paket').DataTable( {
            
        } );

        if (document.getElementById('id_paket_soal') != null){
            choosen_type_paket();
            choosen_buku();
        }
    } );

    function add_data() {
        window.location.href = "<?php echo base_url(); ?>admin/add-paket-soal";
    }
</script>

<!-- Fokus pada inputan pertama ketika halaman form add di load -->
<script>
    $(function(){
        $('.form-paket-soal').find('input[type=text],textarea').filter(':visible:first').focus();
    });
</script>

<!-- Nama file muncul saat upload -->
<script>
    if (document.getElementById('petunjuk_audio') != null) 
        document.querySelector("#petunjuk_audio").onchange = function(){
            document.querySelector("#file-name").textContent = this.files[0].name;
        }
</script>

<!-- Fungsi summernote -->
<script>
    var IMAGE_FOLDER = 'storage/website/lembaga/grandsbmptn/paket_soal/';
    function uploadFileEditor($summernote,file)
	{
        var csrfhash = document.getElementById('csrf-hash-form').value;
		var formData = new FormData();
		formData.append("file", file);
		formData.append("folder", IMAGE_FOLDER);
		formData.append('_token', '388f8e8621faaf2a89834c8646271bd7');
        formData.append(csrfname, csrfhash);
		$.ajax({
			url: base_url+'website/lembaga/Tes_online/editor_paket_soal',
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
        formData.append('_token', '388f8e8621faaf2a89834c8646271bd7');
        formData.append(csrfname, csrfhash);
        $.ajax({
            data: formData,
            type: "POST",
            url: base_url+'website/lembaga/Tes_online/editor_paket_soal_delete', // replace with your url
            cache: false,
            contentType: false,
			processData: false,
            success: function(response) {
                obj = JSON.parse(response);
                document.getElementById('csrf-hash-form').value = obj.csrf;
                console.log(obj.text);
            }
        });
    }
    $('#summernote').summernote({
        placeholder: 'Masukkan petunjuk pengerjaan soal (jika ada)',
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
    $('#summernote').summernote('backColor', 'transparent');
    $('#summernote').summernote('foreColor', 'black');
</script>

<!-- Validasi Form Add -->
<script type = "text/javascript">
    function validate_addform(){
        if( document.formadd.kelas.value == "-1" ) {
            document.getElementById('kelas_er').innerHTML = 'Kelas wajib dipilih!';
            document.formadd.kelas.focus();
            return false;
        }
        if( document.formadd.materi.value == "-1" ) {
            document.getElementById('materi_er').innerHTML = 'Materi wajib dipilih!';
            document.formadd.materi.focus();
            return false;
        }
        if( document.formadd.mode_jawaban.value == "-1" ) {
            document.getElementById('mode_jawaban_er').innerHTML = 'Mode jawaban wajib dipilih!';
            document.formadd.mode_jawaban.focus();
            return false;
        }
        if( document.formadd.buku.value == "-1" ) {
            document.getElementById('buku_er').innerHTML = 'Buku wajib dipilih!';
            document.formadd.buku.focus();
            return false;
        }
        if( document.formadd.type_paket.value == "-1" ) {
            document.getElementById('type_paket_er').innerHTML = 'Tipe Paket wajib dipilih!';
            document.formadd.type_paket.focus();
            return false;
        }
        if( document.formadd.skala_nilai.value == "-1" ) {
            document.getElementById('skala_nilai_er').innerHTML = 'Skala Penilaian Wajib Dipilih!';
            document.formadd.skala_nilai.focus();
            return false;
        }
        return( true );
    }
</script>

<!-- PEMILIHAN PERGANTIAN VIEW TIPE PAKET -->
<script>
    function choosen_type_paket(){
        var type_paket = document.getElementById('type_paket').value;
        var buku_pilih = document.getElementById('buku_pilih');
        if(type_paket == '1|UJIAN'){
            buku_pilih.style.display = 'none';
        } else {
            buku_pilih.style.display = 'block';
        }
    }
</script>

<!-- PEMILIHAN PERGANTIAN VIEW PEMILHAN BUKU -->
<script>
    function choosen_buku(){
        var buku = document.getElementById('buku').value;
        var detail_buku_pilih = document.getElementById('detail_buku_pilih');
        var free_buku = document.getElementById('free_buku');
        if(buku == '2|SBMPTN'){
            detail_buku_pilih.style.display = 'block';
        } else {
            detail_buku_pilih.style.display = 'none';
        }
        $(document).ready(function() {
            $.ajax({
                type: 'POST',
                data: {buku_id:buku},
                url: "<?php echo base_url(); ?>website/lembaga/Tes_online/get_count_free_buku",
                cache: false,
                success: function(data) {
                    if(data.status == 1) {
                        free_buku.style.display = 'block';
                        document.getElementById('text_free').innerHTML = data.text;
                    } else {
                        free_buku.style.display = 'none';
                    }
                }
            });
        });
    }
</script>