<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/katex.min.js" integrity="sha384-FaFLTlohFghEIZkw6VGwmf9ISTubWAVYW8tG8+w2LAIftJEULZABrF9PPFv+tVkH" crossorigin="anonymous"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/contrib/auto-render.min.js" integrity="sha384-bHBqxz8fokvgoJ/sc17HODNxa42TlaEhB+w8ZJXTc2nZf1VgEaFZeZvT4Mznfz0v" crossorigin="anonymous" onload="renderMathInElement(document.body);"></script>

<script> //DOCUMENT SET ROOT & FUNGSI2 LEMBAR UJIAN
    var id_tes          = "<?=$ujian_id; ?>";
    var widget          = $(".step");
    var total_widget    = widget.length;
    var audio_limit     = <?=$audio_limit?>;
    var is_jawab        = <?=$is_jawab?>;
    var is_continuous   = <?=$is_continuous?>;

    $(document).ready(function () {
        var width = screen.width;

        if(width >= 768){
            //Sidebar hidden
            $('#sidebar, #content').toggleClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        }

        //disable F5
        $(document).on("keydown", disableF5);

        buka(1);
        simpan_sementara();

        $("#widget_1").show();

        limit_audio(audio_limit, 1);

        $("html, body").animate({ 
            scrollTop: $('.all-exam').offset().top 
        }, 1000);
    });

    function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };

    //Visual Limit Audio
    function limit_audio(audio_limit, no){
        if (audio_limit != 0 && document.getElementById('loop-limited-' + no) != null) {
            var loopLimit = audio_limit;
            var loopCounter = 1;
            document.getElementById('loop-limited-' + no).addEventListener('ended', function(){
                if (loopCounter < loopLimit){
                    this.currentTime = 0;
                    this.play();
                    loopCounter++;
                } else {
                    var ply = document.getElementById('loop-limited-' + no);
                    document.getElementById('audio_soal_' + no).value = loopCounter;
                    /* var oldSrc = ply.src; */
                    /* ply.src = ""; */
                    ply.style.display = 'none';
                    simpan();
                }
            }, false);
        }

        if (audio_limit != 0 && document.getElementById('group-loop-limited-' + no) != null) {
            var loopLimit = audio_limit;
            var loopCounter = 1;
            document.getElementById('group-loop-limited-' + no).addEventListener('ended', function(){
                if (loopCounter < loopLimit){
                    this.currentTime = 0;
                    this.play();
                    loopCounter++;
                } else {
                    var ply = document.getElementById('group-loop-limited-' + no);
                    document.getElementById('audio_group_' + no).value = loopCounter;
                    /* var oldSrc = ply.src; */
                    /* ply.src = ""; */
                    ply.style.display = 'none';
                    simpan();
                }
            }, false);
        }
    }

    function harus_jawab(no){
        if(is_jawab == 1){
            var f_asal = $("#ujian");
            var form = getFormData(f_asal);

            var gr_m = 'id_group_mode_jwb' + no;
            var group_m = form[gr_m];

            if(group_m == 1){ //1 Pilihan Ganda 2 Essay
                var pil_gan = $('input:radio[name=opsi_'+no+']:checked').val();
                if ( !pil_gan ) {
                    swal({ title: "Informasi",
                        text: "Pilihan Jawaban harus dipilih salah satu!",
                        button: "Kembali",
                        icon: "info"}).then(okay => {
                        if (okay) {
                            buka_return(no);
                        }
                    });
                }
            } else {
                var name_essay = 'essay_' + no;
                var x = document.forms["ujian"][name_essay].value;
                if (x == "") {
                    swal({ title: "Informasi",
                        text: "Jawaban harus diisi!",
                        button: "Kembali",
                        icon: "info"}).then(okay => {
                        if (okay) {
                            buka_return(no);
                        }
                    });
                }
            }
        }
    }

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

        limit_audio(audio_limit, id_widget);

        $("#soalke").html(id_widget);

        var w = document.getElementById("group_petunjuk_"+id_widget); 

        if(w != null){
            buka_group(id_widget);
        } else {
            $(".step").hide();
            $("#widget_" + id_widget).show();
        }

        simpan();

        if(id_widget != 1) {
            $("html, body").animate({ 
                scrollTop: $('.tampilan_soal_jwb').offset().top 
            }, 1000);
        }
    }

    function buka(id_widget) {
        $(".next").attr('rel', (id_widget + 1));
        $(".back").attr('rel', (id_widget - 1));
        $(".ragu_ragu").attr('rel', (id_widget));
        cek_status_ragu(id_widget);

        limit_audio(audio_limit, id_widget);

        if(id_widget != 1){
            harus_jawab(before_widget);
        }

        $("#soalke").html(id_widget);

        var w = document.getElementById("group_petunjuk_"+id_widget); 

        if(w != null){
            buka_group(id_widget);
        } else {
            $(".step").hide();
            $("#widget_" + id_widget).show();
        }

        before_widget = id_widget;

        simpan();

        if(id_widget != 1) {
            $("html, body").animate({ 
                scrollTop: $('.tampilan_soal_jwb').offset().top 
            }, 1000);
        }
    }

    function buka_non_group(id_widget) {
        $('#petunjukModal').modal('hide');

        $(".next").attr('rel', (id_widget + 1));
        $(".back").attr('rel', (id_widget - 1));
        $(".ragu_ragu").attr('rel', (id_widget));
        cek_status_ragu(id_widget);

        limit_audio(audio_limit, id_widget);

        if(id_widget != 1){
            harus_jawab(before_widget);
        }

        $("#soalke").html(id_widget);

        $(".step").hide();
        $("#widget_" + id_widget).show();
        
        before_widget = id_widget;

        simpan();

        if(id_widget != 1) {
            $("html, body").animate({ 
                scrollTop: $('.tampilan_soal_jwb').offset().top 
            }, 1000);
        }
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

        limit_audio(audio_limit, berikutnya);

        harus_jawab(berikutnya - 1);

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

        simpan();
    }

    function back() {
        if (is_continuous == 1){
            document.getElementById('arrow_back').className = "btn btn-sm text-primary bg-white btn-nxt-brf-hrd disabled";
            document.getElementById('previous_back').className = "back btn btn-md btn-primary text-white disabled";
        } else {
            var back = $(".back").attr('rel');
            back = parseInt(back);
            back = back < 1 ? 1 : back;

            limit_audio(audio_limit, back);

            harus_jawab(back + 1);

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

            simpan();
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

        simpan();
    }

    function buka_group(urutan){
        var f_asal = $("#ujian");
        var form = getFormData(f_asal);
        var gr = 'id_group_soal_' + urutan;
        var gr_n = 'group_soal_' + urutan;
        var group = form[gr];

        $.ajax({
            type: "POST",
            url: base_url + "website/user/Buku/buka_group",
            data: 'id_group='+group+'&urutan='+urutan,
            dataType: 'json',
            success: function (data) {
                // Add response in Modal body
                $('#title-group').html(data.judul);
                $('#body-group').html(data.petunjuk);
                $('#footer-group').html(data.footer);

                // Display Modal
                $('#petunjukModal').modal('show');

                if(urutan != 1) {
                    $("html, body").animate({ 
                        scrollTop: $('.tampilan_soal_jwb').offset().top 
                    }, 1000);
                }
            }
        });
    }

    function simpan() {
        simpan_sementara();
        var form = $("#ujian");

        $.ajax({
            type: "POST",
            url: base_url + "website/user/Buku/simpan_satu",
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
        var group_number = 1;
        var sub_group_before = "";
        
        for (var i = 1; i < jml_soal; i++) {
            //iniatial group mode jawaban
            var gr_m = 'id_group_mode_jwb' + i;
            var group_m = form[gr_m];

            var gr = 'id_group_soal_' + i;
            var gr_s = 'group_soal_sub_' + i;
            var gr_n = 'group_soal_' + i;
            var idx2 = 'rg_' + i;
            var ragu = form[idx2];
            var group = form[gr]; //group soal
            var group_name = form[gr_n]; //group soal
            var sub_group_name = form[gr_s]; //group soal sub
            var sub_group_name_split = sub_group_name.split(" ");
            var sub_group_after = sub_group_name_split[0];
            var group_name_split = group_name.split(" ");
            var group_name_first = group_name_split[0];

            if(group_m == 1){ //1 Pilihan Ganda 2 Essay
                var idx = 'opsi_' + i;
                var jwb_exp = form[idx];
                var jawab_pro = jwb_exp == undefined ? '' : jwb_exp.split('|');
                var jawab = jawab_pro[1];

            } else {
                var idx = 'essay_' + i;
                var jawab = form[idx] == '' ? undefined : form[idx];
            }

            var check = '<i style="margin-left:3px;" class="fa fa-check fa-xs"></i>';
            var times = '<i style="margin-left:3px;" class="fa fa-times fa-xs"></i>';

            //Parent group jika ada
            if(group != group_before && group != 0) {
                hasil_jawaban += '<a id="group_petunjuk_'+(i)+'" class="btn btn-primary btn-block text-white btn_group" onclick="return buka_group(' + (i) + ');">' + group_name + "</a>";
                group_number++;
            }

            //Sub group
            if(sub_group_after != sub_group_before && sub_group_after != group_name_first) {
                hasil_jawaban += '<div class="d-flex justify-content-center"><a id="sub_group_petunjuk_'+(i)+'" class="btn btn-secondary btn-block text-white disabled btn_sub_group">' + sub_group_after + "</a></div>";
            }

            if (jawab != undefined){
                if(group_m == 1){
                    jawab_content = number_opsi_text(jawab);
                } else {
                    jawab_content = check;
                }
                
                if (ragu == "Y") {
                    if (jawab == "-") {
                        hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-outline-secondary text-secondary btn_soal" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab_content + "</a>";
                    } else {
                        hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-warning btn_soal" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab_content + "</a>";
                    }
                } else {
                    if (jawab == "-") {
                        hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-outline-secondary text-secondary btn_soal" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab_content + "</a>";
                    } else {
                        hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-success btn_soal" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab_content + "</a>";
                    }
                }
            } else {
                if(group_m == 1){
                    jawab_content = '-';
                } else {
                    jawab_content = times;
                }

                hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-outline-secondary text-secondary btn_soal" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab_content + "</a>";
            }

            var group_before = group;
            var sub_group_before = sub_group_after;
        }

        if (is_continuous == 1){
            var cont = document.getElementById('panel-toogle-soal');
            cont.style.display = 'none';
            document.getElementById("button-nav").disabled = true;
            document.getElementById('toogle-navigasi-ico').className = 'fa fa-chevron-circle-up'; //Ganti Icon Navigasi
            document.getElementById('lembar_soal').className = 'col-sm-12 col-md-12 mb-3'; //Ganti Panjang Desai Lembar Soal
        } else {
            $("#tampil_jawaban").html('<div id="yes"></div>' + hasil_jawaban);
        }
    }

    function done_soal(){
        simpan();
        if (confirm('Yakin ingin mengakhiri tes?')) {
            selesai();
        }
    }

    function selesai() {
        simpan();
        $.ajax({
            type: "POST",
            url: base_url + "website/user/Buku/simpan_akhir",
            data: { id: id_tes },
            beforeSend: function () {
                simpan();
            },
            success: function (r) {
                /* console.log(r); */
                if (r.status) {
                    if(r.hasil == 1){
                        window.location.href = base_url + 'buku/result/' + r.id;
                    } else {
                        window.location.href = base_url + 'buku/sbmptn/launch';
                    }
                }
            }
        });
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