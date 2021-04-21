<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/3.3.1/intro.min.js" integrity="sha512-NC1GtvckWJQLUHrSQp5+4ydIv6gW8kfP4Ewrwv8Y1xU1h9GTTaXDTnWl+kjHcZNCaX8ySFNSpPmtt/B4SUaDsQ==" crossorigin="anonymous"></script>
<script src="<?php echo config_item('_assets_website'); ?>dark-mode-switch/dark-mode-switch.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/katex.min.js" integrity="sha384-FaFLTlohFghEIZkw6VGwmf9ISTubWAVYW8tG8+w2LAIftJEULZABrF9PPFv+tVkH" crossorigin="anonymous"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/contrib/auto-render.min.js" integrity="sha384-bHBqxz8fokvgoJ/sc17HODNxa42TlaEhB+w8ZJXTc2nZf1VgEaFZeZvT4Mznfz0v" crossorigin="anonymous" onload="renderMathInElement(document.body);"></script>

<script> //DOCUMENT SET ROOT & FUNGSI2 LEMBAR UJIAN
    var id_tes          = "<?=$ujian_id; ?>";
    var widget          = $(".step");
    var total_widget    = widget.length;

    $(document).ready(function () {
        var t = $('.sisawaktu');
        if (t.length) {
            sisawaktu(t.data('time'));
        }

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

    function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };

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
            jawab_text = 'A';
        }else if(jawab == 2){
            jawab_text = 'B';
        }else if(jawab == 3){
            jawab_text = 'C';
        }else if(jawab == 4){
            jawab_text = 'D';
        }else if(jawab == 5){
            jawab_text = 'E';
        }

        return jawab_text;
    }

    function buka(id_widget) {
        $(".next").attr('rel', (id_widget + 1));
        $(".back").attr('rel', (id_widget - 1));
        $(".ragu_ragu").attr('rel', (id_widget));
        cek_status_ragu(id_widget);

        $("#soalke").html(id_widget);

        $(".step").hide();
        $("#widget_" + id_widget).show();

        simpan();
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

        $(".step").hide();
        $("#widget_" + berikutnya).show();

        simpan();
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

        $(".step").hide();
        $("#widget_" + back).show();

        simpan();
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

        simpan();
    }

    function simpan() {
        simpan_sementara();
        var form = $("#ujian");

        $.ajax({
            type: "POST",
            url: base_url + "website/user/Ujian/simpan_satu",
            data: form.serialize(),
            dataType: 'json',
            success: function (data) {
                // $('.ajax-loading').show();
                /* console.log(data); */
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
        
        for (var i = 1; i < jml_soal; i++) {
            var gr = 'id_group_soal_' + i;
            var idx = 'opsi_' + i;
            var idx2 = 'rg_' + i;
            var jawab = form[idx];
            var ragu = form[idx2];
            var group = form[gr];

            if (jawab != undefined) {
                jawab_opsi = number_opsi_text(jawab);
                if (ragu == "Y") {
                    if (jawab == "-") {
                        hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-outline-secondary text-secondary btn_soal" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab_opsi + "</a>";
                    } else {
                        hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-warning btn_soal" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab_opsi + "</a>";
                    }
                } else {
                    if (jawab == "-") {
                        hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-outline-secondary text-secondary btn_soal" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab_opsi + "</a>";
                    } else {
                        hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-success btn_soal" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab_opsi + "</a>";
                    }
                }
            } else {
                hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-outline-secondary text-secondary btn_soal" onclick="return buka(' + (i) + ');">' + (i) + ". -</a>";
            }
        }
        $("#tampil_jawaban").html('<div id="yes"></div>' + hasil_jawaban);
    }

    function done_soal(){
        simpan();
        if (confirm('Yakin ingin mengakhiri tes?')) {
            selesai();
                swal({ title: "Good job!",
                    text: "Anda sudah menyelesaikan pengerjaan soal ini",
                    button: "Dashboard",
                    icon: "success"}).then(okay => {
                    if (okay) {
                        selesai();
                        window.location.href = base_url + 'dashboard';
                    }
                });
        }
    }

    function selesai() {
        /* simpan();
        ajaxcsrf();
        $.ajax({
            type: "POST",
            url: base_url + "ujian/simpan_akhir",
            data: { id: id_tes },
            beforeSend: function () {
                simpan();
                // $('.ajax-loading').show();    
            },
            success: function (r) {
                console.log(r);
                if (r.status) {
                    window.location.href = base_url + 'ujian/list';
                }
            }
        }); */
    }

    function waktuHabis() {
        selesai();
        alert('');
        swal("Informasi", "Waktu ujian telah habis!", "info");
        window.location.href = base_url + 'dashboard';
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

<!-- User pindah tab lain atau pindah dari browser aktif sekarang -->
<script type="text/javascript">
    /* document.addEventListener("visibilitychange", event => {
        var modal = document.getElementById("alert-away");
        var timeleft  = 5;

        if (document.visibilityState == "visible") {
            var openBlockTimer = setInterval(function(){
            timeleft--;
            document.getElementById("countdownblocktimer").innerHTML = timeleft;
            if(timeleft == 0){
                clearInterval(openBlockTimer);
                modal.style.display = "none";
            } }, 1000);
        } else {
            document.getElementById("msg_title_away").innerHTML = "PESAN SISTEM!";
            document.getElementById("msg_content_away").innerHTML = "Anda terdeteksi meninggalkan halaman ini.";
            document.getElementById("msg_footer_away").innerHTML = "Tunggu waktu penalti selesai untuk dapat melanjutkan pengerjaan soal kembali.";
            modal.style.display = "block";
        }
    }) */
</script>

<!-- Intro JS -->
<script>
    /* introJs().setOptions({
        showProgress: true,
        showBullets: false
    }).start() */
</script>

<!-- NAVIGASI TOOGLE SOAL -->
<script>
    function toggle_soal() {
        var cont = document.getElementById('panel-toogle-soal');
        if (cont.style.display == 'block') { //Jika panel ditampilkan dihide
            cont.style.display = 'none';
            document.getElementById('toogle-navigasi-ico').className = 'fa fa-chevron-circle-down'; //Ganti Icon Navigasi
            document.getElementById('lembar_soal').className = 'col-sm-12 col-md-12 mb-3'; //Ganti Panjang Desai Lembar Soal
        }
        else { //jika panel dihide ditampilkan
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