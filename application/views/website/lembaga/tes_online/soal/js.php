<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="<?= config_item('_assets_general') ?>summernote-0.8.18-dist/summernote-bs4.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/katex.min.js" integrity="sha384-FaFLTlohFghEIZkw6VGwmf9ISTubWAVYW8tG8+w2LAIftJEULZABrF9PPFv+tVkH" crossorigin="anonymous"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/contrib/auto-render.min.js" integrity="sha384-bHBqxz8fokvgoJ/sc17HODNxa42TlaEhB+w8ZJXTc2nZf1VgEaFZeZvT4Mznfz0v" crossorigin="anonymous" onload="renderMathInElement(document.body);"></script>
<script src="<?= config_item('_assets_general') ?>js/math-katex.js"></script>

<!-- NAVIGASI TOOGLE SOAL -->
<script>
    function toggle_soal() {
        var cont = document.getElementById('panel-toogle-soal');
        if (cont.style.display == 'block') { //Jika panel ditampilkan dihide
            cont.style.display = 'none';
            document.getElementById('lembar_soal').className = 'col-sm-12 col-md-12 mb-3'; //Ganti Panjang Desai Lembar Soal
        } else { //jika panel dihide ditampilkan
            cont.style.display = 'block';
            document.getElementById('lembar_soal').className = 'col-sm-12 col-md-8 mb-3'; //Ganti Panjang Desai Lembar Soal
        }
    }
</script>

<!-- NAVIGASI TOOGLE SEARCH -->
<script>
    function toogle_search() {
        var cont = document.getElementById('panel-toogle-search');
        if (cont.style.display == 'block') { //Jika panel ditampilkan dihide
            cont.style.display = 'none';
        } else { //jika panel dihide ditampilkan
            cont.style.display = 'block';
        }
    }
</script>

<!-- Amnil id soal pertama yang muncul berdasarkan sistem -->
<script>
    $(document).ready(function() {
        if (document.getElementById("bank_soal_first_id").innerHTML != "") {
            var id_soal = document.getElementById('bank_soal_first_id').innerHTML;
            get_soal(id_soal, 1);
        }
        if (document.getElementById("pilihan_jenis_soal") != null) {
            choosen_exam();
        }
    });
</script>

<script>
    $(function() {
        $('.form-soal').find('input[type=text],textarea').filter(':visible:first').focus();
    });
</script>

<!-- Untuk menampilkan nama file saat upload soal audio -->
<script>
    if (document.getElementById('soal_audio') != null)
        document.querySelector("#soal_audio").onchange = function() {
            document.querySelector("#file-name").textContent = this.files[0].name;
        }
</script>

<!-- Untuk menampilkan nama file saat upload excel soal -->
<script>
    if (document.getElementById('data_soal') != null)
        document.querySelector("#data_soal").onchange = function() {
            document.querySelector("#file-name").textContent = this.files[0].name;
        }
</script>

<!-- PEMILIHAN PERGANTIAN VIEW TIPE SOAL -->
<script>
    function choosen_exam() {
        var type_exam = document.getElementById('pilihan_jenis_soal').value;
        var content_jawaban = document.getElementById('content_jawaban');
        var content_acak_jawaban_head = document.getElementById('content_acak_jawaban_head');
        var content_acak_jawaban_body = document.getElementById('content_acak_jawaban_body');
        if (type_exam == '1') { //1 PILIHAN GANDA //2 ESSAY
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

<!-- JIKA USER MEMILIH ALL DI SEARCH SOAL -->
<script>
    function prevent_form() {
        var type_group_soal = document.getElementById('group_soal_idx').value;
        var kata_kunci_soal = document.getElementById('kata_kunci_soalx');
        if (type_group_soal == 'all_soal') { //PILIH ALL SOAL KOSONGKAN DAN DISABLE FIELD KATA KUNCI SOAL
            kata_kunci_soal.disabled = true;
            kata_kunci_soal.value = "";
        } else {
            kata_kunci_soal.disabled = false;
            kata_kunci_soal.value = "";
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
    var IMAGE_FOLDER = 'storage/website/lembaga/grandsbmptn/paket_soal/soal_' + id_paket_data + '/';

    function uploadFileEditor($summernote, file) {
        var csrfhash = document.getElementById('csrf-hash-form').value;
        var formData = new FormData();
        formData.append("file", file);
        formData.append("folder", IMAGE_FOLDER);
        formData.append('_token', '8c064f61a5d9059125ea94df78809fef');
        formData.append(csrfname, csrfhash);
        formData.append('id_paket_soal', id_paket_data);
        $.ajax({
            url: base_url + 'website/lembaga/Tes_online/editor_soal',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(response) {
                obj = JSON.parse(response);
                document.getElementById('csrf-hash-form').value = obj.csrf;
                $summernote.summernote('insertImage', obj.link, function($image) {
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
            url: base_url + 'website/lembaga/Tes_online/editor_soal_delete',
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
        maximumImageFileSize: 500000,
        toolbar: [
            ['style', ['style', 'fontname', 'fontsize', 'undo', 'redo']],
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
            onImageUpload: function(files) {
                uploadFileEditor($(this), files[0]);
            },
            onMediaDelete: function(target) {
                deleteFileEditor(target[0].src);
            }
        }
    });
    // @param {String} color
    $('.summernote').summernote('backColor', 'transparent');
    $('.summernote').summernote('foreColor', 'black');
    if (document.getElementById("id_bank_soal") != null) {
        $('.summernote').summernote('code');
    }
</script>

<script>
    function get_soal(id_soal, no_soal) {
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
            url: base_url + 'website/lembaga/Tes_online/get_detail_exam',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                obj = JSON.parse(response);

                if (obj.status == "berhasil") {
                    /* console.log(obj); */
                    document.getElementById('csrf-hash-form').value = obj.csrf;
                    //HEADER SOAL SHOW
                    document.getElementById("header-soal").innerHTML = obj.header_soal;
                    //CONTENT SOAL SHOW
                    document.getElementById("content-soal").innerHTML = obj.content_soal;
                    //JAWABAN SOAL SHOW
                    document.getElementById("jawaban-soal").innerHTML = obj.jawaban_soal;
                    //
                    $("html, body").animate({
                        scrollTop: $('.soal-content').offset().top
                    }, 1000);
                } else {
                    alert("Permintaan gagal. Silahkan ulangi kembali atau refresh halaman ini!");
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    }
</script>

<!-- Validasi Form Add -->
<script type="text/javascript">
    function validate_addform() {
        if (document.formadd.jenis_soal.value == "-1") {
            document.getElementById('jenis_soal_er').innerHTML = 'Jenis soal wajib dipilih!';
            document.formadd.jenis_soal.focus();
            return false;
        }
        if (document.formadd.tipe_kesulitan.value == "-1") {
            document.getElementById('tipe_kesulitan_er').innerHTML = 'Tipe kesulitan wajib dipilih!';
            document.formadd.tipe_kesulitan.focus();
            return false;
        }
        return (true);
    }
</script>

<!-- Validasi Form Add -->
<script type="text/javascript">
    function validate_editform() {
        if (document.formedit.no_soal.value == "") {
            document.getElementById('no_soal_er').innerHTML = 'No Soal Tidak Terisi, Refresh Halaman Ini!';
            document.formedit.no_soal.focus();
            return false;
        }
        return (true);
    }
</script>

<!-- Opsi jawaban -->
<script type="text/javascript">
    function add_opsi_jawaban() {
        let num = document.getElementById("last_opsi_number").value;
        let alpha = document.getElementById("last_opsi_alpha").value;

        if (parseInt(num) === 11) { //Maksimal opsi jawaban hanya sampai J
            alert("Maksimal opsi jawaban hanya sampai J");
            return false;
        }

        //Insert content
        let table_opsi_jawaban = document.getElementById("table_opsi_jawaban");
        let row_opsi_jawaban = table_opsi_jawaban.insertRow(-1);
        row_opsi_jawaban.id = 'opsi_jawaban_' + num;
        let cell_opsi_jawaban_1 = row_opsi_jawaban.insertCell(0);
        let cell_opsi_jawaban_2 = row_opsi_jawaban.insertCell(1);
        let cell_opsi_jawaban_3 = row_opsi_jawaban.insertCell(2);
        let cell_opsi_jawaban_4 = row_opsi_jawaban.insertCell(3);
        cell_opsi_jawaban_1.className = "text-center font-weight-bold";
        cell_opsi_jawaban_1.innerHTML = '<td>' + alpha + ' <br /><button type="button" id="hapus_opsi_jawaban_' + num + '" class="btn btn-sm btn-danger button_hapus_opsi_jawaban" title="Hapus opsi jawaban" onclick="delete_opsi_jawaban(' + num + ')" style="display:none;"><i class="fa fa-trash"></i></button></td>';
        cell_opsi_jawaban_2.className = "text-center";
        cell_opsi_jawaban_2.innerHTML = '<td><div class="form-check"><input class="form-check-input position-static" type="checkbox" name="tanda_jawaban[]" value="' + num + '" id="blankRadio' + num + '" onclick="get_opsi_jawaban_selected(' + num + ')"></div></td>';
        cell_opsi_jawaban_3.innerHTML = '<td><div class="form-group"><textarea class="summernote note-math-dialog" id="summernote' + num + '" name="jawaban[]" rows="10"></textarea></div></td>';
        cell_opsi_jawaban_4.className = "text-center";
        cell_opsi_jawaban_4.innerHTML = '<td><div class="form-group"><input id="skor_jawaban' + num + '" name="skor_jawaban[]" type="text" class="form-control" aria-required="true" aria-invalid="false" value="0" required></div></td>';

        //Display summernote editor
        $("#summernote" + num).summernote({
            dialogsInBody: true,
            dialogsFade: true,
            tabsize: 2,
            height: 200,
            codeviewFilter: false,
            codeviewIframeFilter: true,
            maximumImageFileSize: 500000,
            toolbar: [
                ['style', ['style', 'fontname', 'fontsize', 'undo', 'redo']],
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
                onImageUpload: function(files) {
                    uploadFileEditor($(this), files[0]);
                },
                onMediaDelete: function(target) {
                    deleteFileEditor(target[0].src);
                }
            }
        });
        // @param {String} color
        $("#summernote" + num).summernote('backColor', 'transparent');
        $("#summernote" + num).summernote('foreColor', 'black');
        if (document.getElementById("id_bank_soal") != null) {
            $("#summernote" + num).summernote('code');
        }

        //Display button delete opsi for current element
        let hapus_opsi_jawaban_id_last = document.getElementById('hapus_opsi_jawaban_' + num);
        hapus_opsi_jawaban_id_last.style.display = 'block';

        //Hidden all button before last button
        for (let p = parseInt(num) - 1; p > 0; p--) {
            let hapus_opsi_jawaban_id_before = document.getElementById('hapus_opsi_jawaban_' + p);
            hapus_opsi_jawaban_id_before.style.display = 'none';
        }

        //Update flag number and alpha element last
        document.getElementById("last_opsi_number").value = parseInt(num) + 1;
        document.getElementById("last_opsi_alpha").value = String.fromCharCode(parseInt(num) + 1 + 64);
    }

    function get_opsi_jawaban_selected(num) {
        var limit_opsi_choosen = parseInt(document.querySelector('input[name="opsi_jawaban"]:checked').value);
        if ($('[name="tanda_jawaban[]"]:checked').length > limit_opsi_choosen) {
            $('#blankRadio' + num).prop('checked', false);
            return alert("Hanya boleh pilih " + limit_opsi_choosen + " jawaban");
        }
    }

    function update_list_opsi_jawaban() {
        document.querySelectorAll('[name="tanda_jawaban[]"]:checked').forEach(el => el.checked = false);
    }

    function delete_opsi_jawaban(num) {
        //delete element jawaban
        const element_opsi_jawaban = document.getElementById("opsi_jawaban_" + num);
        element_opsi_jawaban.remove();

        //Display button delete opsi for current element
        let hapus_opsi_jawaban_id_last = document.getElementById('hapus_opsi_jawaban_' + (parseInt(num) - 1));
        hapus_opsi_jawaban_id_last.style.display = 'block';

        //Hidden all button before last button
        for (let p = parseInt(num) - 2; p > 0; p--) {
            let hapus_opsi_jawaban_id_before = document.getElementById('hapus_opsi_jawaban_' + p);
            hapus_opsi_jawaban_id_before.style.display = 'none';
        }

        //update flag number and alpha element last
        document.getElementById("last_opsi_number").value = parseInt(num);
        document.getElementById("last_opsi_alpha").value = String.fromCharCode(parseInt(num) + 64);
    }
</script>