<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/katex.min.js" integrity="sha384-FaFLTlohFghEIZkw6VGwmf9ISTubWAVYW8tG8+w2LAIftJEULZABrF9PPFv+tVkH" crossorigin="anonymous"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/contrib/auto-render.min.js" integrity="sha384-bHBqxz8fokvgoJ/sc17HODNxa42TlaEhB+w8ZJXTc2nZf1VgEaFZeZvT4Mznfz0v" crossorigin="anonymous" onload="renderMathInElement(document.body);"></script>

<script> //DOCUMENT SET ROOT & FUNGSI2 LEMBAR UJIAN
    var id_tes          = "<?=$ujian_id; ?>";
    var widget          = $(".step");
    var total_widget    = widget.length;

    $(document).ready(function () {
        //Sidebar hidden
        $('#sidebar, #content').toggleClass('active');
        $('.collapse.in').toggleClass('in');
        $('a[aria-expanded=true]').attr('aria-expanded', 'false');

        //disable F5
        /* $(document).on("keydown", disableF5); */

        buka(1);
        simpan_sementara();

        $("#widget_1").show();
    });

    function getFormData($form) {
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};
        $.map(unindexed_array, function (n, i) {
            indexed_array[n['name']] = n['value'];
        });
        return indexed_array;
    }

    function number_opsi_text(jawab){
        if(jawab == 1){
            var jawab_text = 'A';
        }else if(jawab == 2){
            var jawab_text = 'B';
        }else if(jawab == 3){
            var jawab_text = 'C';
        }else if(jawab == 4){
            var jawab_text = 'D';
        }else if(jawab == 5){
            var jawab_text = 'E';
        }

        return jawab_text;
    }

    function buka_return(id_widget) {
        $(".next").attr('rel', (id_widget + 1));
        $(".back").attr('rel', (id_widget - 1));
        $(".ragu_ragu").attr('rel', (id_widget));
        cek_status_ragu(id_widget);

        $("#soalke").html(id_widget);

        var w = document.getElementById("group_petunjuk_"+id_widget); 

        if(w != null){
            buka_group(id_widget);
        } else {
            $(".step").hide();
            $("#widget_" + id_widget).show();
        }
    }

    function buka(id_widget) {
        $(".next").attr('rel', (id_widget + 1));
        $(".back").attr('rel', (id_widget - 1));
        $(".ragu_ragu").attr('rel', (id_widget));
        cek_status_ragu(id_widget);

        $("#soalke").html(id_widget);

        var w = document.getElementById("group_petunjuk_"+id_widget); 

        if(w != null){
            buka_group(id_widget);
        } else {
            $(".step").hide();
            $("#widget_" + id_widget).show();
        }

        before_widget = id_widget;
    }

    function buka_non_group(id_widget) {
        $('#petunjukModal').modal('hide');

        $(".next").attr('rel', (id_widget + 1));
        $(".back").attr('rel', (id_widget - 1));
        $(".ragu_ragu").attr('rel', (id_widget));
        cek_status_ragu(id_widget);

        $("#soalke").html(id_widget);

        $(".step").hide();
        $("#widget_" + id_widget).show();
        
        before_widget = id_widget;
    }

    function cek_status_ragu(id_soal) {
        var status_ragu = $("#rg_" + id_soal).val();

        if (status_ragu == "N") {
            $(".ragu_ragu").html('Ragu');
        } else {
            $(".ragu_ragu").html('Tidak Ragu');
        }
    }

    function next() {
        var berikutnya = $(".next").attr('rel');
        berikutnya = parseInt(berikutnya);
        berikutnya = berikutnya > total_widget ? total_widget : berikutnya;

        $("#soalke").html(berikutnya);

        $(".next").attr('rel', (berikutnya + 1));
        $(".back").attr('rel', (berikutnya - 1));
        $(".ragu_ragu").attr('rel', (berikutnya));
        cek_status_ragu(berikutnya);

        var w = document.getElementById("group_petunjuk_"+berikutnya); 

        if(w != null){
            buka_group(berikutnya);
        } else {
            $(".step").hide();
            $("#widget_" + berikutnya).show();
        }
    }

    function back() {
        var back = $(".back").attr('rel');
        back = parseInt(back);
        back = back < 1 ? 1 : back;

        $("#soalke").html(back);

        $(".back").attr('rel', (back - 1));
        $(".next").attr('rel', (back + 1));
        $(".ragu_ragu").attr('rel', (back));
        cek_status_ragu(back);

        var w = document.getElementById("group_petunjuk_"+back); 

        if(w != null){
            buka_group(back);
        } else {
            $(".step").hide();
            $("#widget_" + back).show();
        }
    }

    function tidak_jawab() {
        var id_step = $(".ragu_ragu").attr('rel');
        var status_ragu = $("#rg_" + id_step).val();

        if (status_ragu == "N") {
            $("#rg_" + id_step).val('Y');
            $("#btn_soal_" + id_step).removeClass('btn-success');
            $("#btn_soal_" + id_step).addClass('btn-warning');

        } else {
            $("#rg_" + id_step).val('N');
            $("#btn_soal_" + id_step).removeClass('btn-warning');
            $("#btn_soal_" + id_step).addClass('btn-success');
        }

        cek_status_ragu(id_step);
    }

    function buka_group(urutan){
        var f_asal = $("#ujian");
        var form = getFormData(f_asal);
        var gr = 'id_group_soal_' + urutan;
        var group = form[gr];

        $.ajax({
            type: "POST",
            url: base_url + "website/user/Ujian/buka_group",
            data: 'id_group='+group+'&urutan='+urutan,
            dataType: 'json',
            success: function (data) {
                // Add response in Modal body
                $('#title-group').html(data.judul);
                $('#body-group').html(data.petunjuk);
                $('#footer-group').html(data.footer);

                // Display Modal
                $('#petunjukModal').modal('show');
            }
        });
    }

    function simpan_sementara() {
        var f_asal = $("#ujian");
        var form = getFormData(f_asal);
        //form = JSON.stringify(form);
        var jml_soal = form.jml_soal;
        jml_soal = parseInt(jml_soal);

        var hasil_jawaban = "";
        var group_number = 1;
        
        for (var i = 1; i < jml_soal; i++) {
            //iniatial group mode jawaban
            var gr_m = 'id_group_mode_jwb' + i;
            var group_m = form[gr_m];

            var gr = 'id_group_soal_' + i;
            var idx2 = 'rg_' + i;
            var ragu = form[idx2];
            var group = form[gr]; //group soal

            if(group_m == 1){ //1 Pilihan Ganda 2 Essay
                var idx = 'key_' + i;
                var jwb_exp = form[idx];
                var jawab_pro = jwb_exp == undefined ? '' : jwb_exp.split('|');
                var jawab = jawab_pro[1];
                var jawab_benar = jawab_pro[2];
            } else {
                var idx = 'essay_' + i;
                var jawab = form[idx] == '' ? undefined : form[idx];
            }

            var check = '<i style="margin-left:3px;" class="fa fa-check fa-xs"></i>';
            var times = '<i style="margin-left:3px;" class="fa fa-times fa-xs"></i>';

            if(group != group_before && group != 0) {
                hasil_jawaban += '<a id="group_petunjuk_'+(i)+'" class="btn button-round btn-primary text-white btn_group" onclick="return buka_group(' + (i) + ');">G' + (group_number) + "</a>";
                group_number++;
            }

            if (jawab != undefined){
                if(jawab_benar == jawab){
                    if (ragu == "Y") {
                        if (jawab == "-") {
                            hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-outline-secondary text-secondary btn_soal" onclick="return buka(' + (i) + ');">' + (i) + "</a>";
                        } else {
                            hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-warning btn_soal" onclick="return buka(' + (i) + ');">' + (i) + "</a>";
                        }
                    } else {
                        if (jawab == "-") {
                            hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-outline-secondary text-secondary btn_soal" onclick="return buka(' + (i) + ');">' + (i) + "</a>";
                        } else {
                            hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-success btn_soal" onclick="return buka(' + (i) + ');">' + (i) + "</a>";
                        }
                    }
                } else {
                    hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-danger btn_soal" onclick="return buka(' + (i) + ');">' + (i) + "</a>";
                }
            } else {
                hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-outline-secondary text-secondary btn_soal" onclick="return buka(' + (i) + ');">' + (i) + "</a>";
            }

            var group_before = group;
        }

        $("#tampil_jawaban").html('<div id="yes"></div>' + hasil_jawaban);
    }
</script>

<!-- Increase Decrease Font Lembar Soal -->
<script>
    function _increase(){
        var fontSize = $('.card-text').css('font-size');
        var newFontSize = parseInt(fontSize)+1;
        
        $('.card-text').css('font-size', newFontSize+'px')
        $('.huruf_opsi').css('font-size', newFontSize+'px')
    }

    function _decrease(){
        var fontSize = $('.card-text').css('font-size');
        var newFontSize = parseInt(fontSize)-1;
        
        $('.card-text').css('font-size', newFontSize+'px')
        $('.huruf_opsi').css('font-size', newFontSize+'px')
    }

    function _reset(){
        $('.card-text').css('font-size', '16px')
        $('.huruf_opsi').css('font-size', '16px')
    }
</script>

<!-- NAVIGASI TOOGLE SOAL -->
<script>
    function toggle_soal() {
        var cont = document.getElementById('panel-toogle-soal');
        if (cont.style.display == 'block') { //Jika panel ditampilkan dihide
            cont.style.display = 'none';
            document.getElementById('toogle-navigasi-ico').className = 'fa fa-chevron-circle-down'; //Ganti Icon Navigasi
            document.getElementById('lembar_soal').className = 'col-sm-12 col-md-12 mb-3'; //Ganti Panjang Desai Lembar Soal
        } else { //jika panel dihide ditampilkan
            cont.style.display = 'block';
            document.getElementById('toogle-navigasi-ico').className = 'fa fa-chevron-circle-up'; //Ganti Icon Navigasi
            document.getElementById('lembar_soal').className = 'col-sm-12 col-md-8 mb-3'; //Ganti Panjang Desai Lembar Soal
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