<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/katex.min.js" integrity="sha384-FaFLTlohFghEIZkw6VGwmf9ISTubWAVYW8tG8+w2LAIftJEULZABrF9PPFv+tVkH" crossorigin="anonymous"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/contrib/auto-render.min.js" integrity="sha384-bHBqxz8fokvgoJ/sc17HODNxa42TlaEhB+w8ZJXTc2nZf1VgEaFZeZvT4Mznfz0v" crossorigin="anonymous" onload="renderMathInElement(document.body);"></script>

<script>
    //DOCUMENT SET ROOT & FUNGSI2 LEMBAR UJIAN
    var id_tes = "<?= $ujian_id; ?>";
    var widget = $(".step");
    var total_widget = widget.length;
    var audio_limit = <?= $audio_limit ?>;
    var is_jawab = <?= $is_jawab ?>;
    var is_continuous = <?= $is_continuous ?>;
    var blok_layar = <?= $blok_layar ?>;

    $(document).ready(function() {
        var t = $('.sisawaktu');
        var waktu_sekarang = $('#waktusekarang').val();

        if (t.length) {
            sisawaktu(t.data('time'), id_tes, waktu_sekarang);
        }

        var width = screen.width;

        if (width >= 768) {
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

    function disableF5(e) {
        if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault();
    };

    //Visual Limit Audio
    function limit_audio(audio_limit, no) {
        if (audio_limit != 0 && document.getElementById('loop-limited-' + no) != null) {
            var loopLimit = audio_limit;
            var loopCounter = 1;
            document.getElementById('loop-limited-' + no).addEventListener('ended', function() {
                if (loopCounter < loopLimit) {
                    this.currentTime = 0;
                    this.play();
                    loopCounter++;
                } else {
                    var ply = document.getElementById('loop-limited-' + no);
                    document.getElementById('audio_soal_' + no).value = loopCounter;
                    ply.style.display = 'none';
                    simpan();
                }
            }, false);
        }

        if (audio_limit != 0 && document.getElementById('group-loop-limited-' + no) != null) {
            var loopLimit = audio_limit;
            var loopCounter = 1;
            document.getElementById('group-loop-limited-' + no).addEventListener('ended', function() {
                if (loopCounter < loopLimit) {
                    this.currentTime = 0;
                    this.play();
                    loopCounter++;
                } else {
                    var ply = document.getElementById('group-loop-limited-' + no);
                    document.getElementById('audio_group_' + no).value = loopCounter;
                    ply.style.display = 'none';
                    simpan();
                }
            }, false);
        }
    }

    function harus_jawab(no) {
        if (is_jawab == 1) {
            //var f_asal = $("#ujian");
            //var form = getFormData(f_asal);

            //var gr_m = 'id_group_mode_jwb' + no;
            //var group_m = form[gr_m];
            var group_m = $("input[name=id_group_mode_jwb" + no + "]").val();

            if (group_m == 1) { //1 Pilihan Ganda 2 Essay
                var pil_gan = $('input[name=opsi_' + no + '[]]:checked').val();
                if (!pil_gan) {
                    swal({
                        title: "Informasi",
                        text: "Pilihan Jawaban harus diisi!",
                        button: "Kembali",
                        icon: "info"
                    }).then(okay => {
                        if (okay) {
                            buka_return(no);
                        }
                    });
                }
            } else {
                var name_essay = 'essay_' + no;
                var x = document.forms["ujian"][name_essay].value;
                if (x == "") {
                    swal({
                        title: "Informasi",
                        text: "Jawaban harus diisi!",
                        button: "Kembali",
                        icon: "info"
                    }).then(okay => {
                        if (okay) {
                            buka_return(no);
                        }
                    });
                }
            }
        }
    }

    function deleteFromObject(keyPart, obj) {
        for (var k in obj) { // Loop through the object
            if (~k.indexOf(keyPart)) { // If the current key contains the string we're looking for
                delete obj[k]; // Delete obj[key];
            }
        }
    }

    function getFormData($form) {
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        //Get html data
        $.map(unindexed_array, function(n, i) {
            indexed_array[n['name'].replace('[]', '')] = n['value'];
        });

        //Mapping opsi jawaban
        $.map(unindexed_array, function(n, i) {
            if ($("input[name='opsi_" + i + "[]']:checked").length > 1) { //Mapping jawaban multi
                var k = "";
                var element_jawaban = $("input[name='opsi_" + i + "[]']:checked");
                for (var z = 0; z < $("input[name='opsi_" + i + "[]']:checked").length; z++) {
                    var a = element_jawaban[z];
                    k = $("input[name='opsi_" + i + "[]']:checked").length = z ? k + a.value.split('|')[1] : k + a.value.split('|')[1] + ':';
                }

                const index_opsi = 'opsi_' + i;
                deleteFromObject(index_opsi, indexed_array);
                indexed_array[index_opsi] = k;
            }

            if ($("input[name='opsi_" + i + "[]']:checked").length == 1) {
                var s = "";
                var element_jawaban = $("input[name='opsi_" + i + "[]']:checked");
                for (var v = 0; v < $("input[name='opsi_" + i + "[]']:checked").length; v++) {
                    var h = element_jawaban[v];
                    s = s + h.value.split('|')[1];
                }

                const index_opsi = 'opsi_' + i;
                deleteFromObject(index_opsi, indexed_array);
                indexed_array[index_opsi] = s;
            }
        });

        return indexed_array;
    }

    function number_opsi_text(jawab) {
        if (jawab == 1) {
            var jawab_text = 'A';
        } else if (jawab == 2) {
            var jawab_text = 'B';
        } else if (jawab == 3) {
            var jawab_text = 'C';
        } else if (jawab == 4) {
            var jawab_text = 'D';
        } else if (jawab == 5) {
            var jawab_text = 'E';
        } else if (jawab == 6) {
            var jawab_text = 'F';
        } else if (jawab == 7) {
            var jawab_text = 'G';
        } else if (jawab == 8) {
            var jawab_text = 'H';
        } else if (jawab == 9) {
            var jawab_text = 'I';
        } else if (jawab == 10) {
            var jawab_text = 'J';
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

        var w = document.getElementById("group_petunjuk_" + id_widget);

        if (w != null) {
            buka_group(id_widget);
        } else {
            $(".step").hide();
            $("#widget_" + id_widget).show();
        }

        //simpan();

        if (id_widget != 1) {
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

        if (id_widget != 1) {
            harus_jawab(before_widget);
        }

        $("#soalke").html(id_widget);

        var w = document.getElementById("group_petunjuk_" + id_widget);

        if (w != null) {
            buka_group(id_widget);
        } else {
            $(".step").hide();
            $("#widget_" + id_widget).show();
        }

        before_widget = id_widget;

        //simpan();

        if (id_widget != 1) {
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

        if (id_widget != 1) {
            harus_jawab(before_widget);
        }

        $("#soalke").html(id_widget);

        $(".step").hide();
        $("#widget_" + id_widget).show();

        before_widget = id_widget;

        //simpan();

        if (id_widget != 1) {
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

        var w = document.getElementById("group_petunjuk_" + berikutnya);

        if (w != null) {
            buka_group(berikutnya);
        } else {
            $(".step").hide();
            $("#widget_" + berikutnya).show();
        }

        //simpan();
    }

    function back() {
        if (is_continuous == 1) {
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

            var w = document.getElementById("group_petunjuk_" + back);

            if (w != null) {
                buka_group(back);
            } else {
                $(".step").hide();
                $("#widget_" + back).show();
            }

            //simpan();
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

    function buka_soal_timer(nomorSoal, timerSoal) {
        //Buka soal
        var soalHide = document.getElementById("nomor_soals_" + nomorSoal);
        soalHide.style.display = "block";

        //Tutup button timer
        var buttonTimerHide = document.getElementById("btn_timer_soals_" + nomorSoal);
        buttonTimerHide.style.display = "none";

        //Countdown tutup soal
        try {
            var displayTimer = document.getElementById("timer_soals_" + nomorSoal);
            var minutesTimer = 60 * parseInt(timerSoal);
            var timer = minutesTimer,
                minutes, seconds;
            var timerCountdown = setInterval(function() {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                displayTimer.innerHTML = '<div class="mb-2"><span class="badge badge-info" style="font-size: 18px;"><span class="text-white">Soal Akan ditutup kembali dalam hitungan</span> <span class="text-dark"> ' + minutes + ':' + seconds + '</span></span></div>';

                if (--timer < 0) {
                    clearInterval(timerCountdown);

                    displayTimer.innerHTML = '<div class="mb-2"><span class="badge badge-danger text-white" style="font-size: 18px;">Waktu menampilkan soal sudah berakhir!</span></div>';
                    soalHide.style.display = "none";
                    buttonTimerHide.style.display = "none";
                }
            }, 1000);
        } catch (e) {
            soalHide.style.display = "none";
            buttonTimerHide.style.display = "block";

            alert("Kesalahan saat membuka soal. Silahkan ulangi kembali!");
        }
    }

    function buka_group(urutan) {
        //var f_asal = $("#ujian");
        //var form = getFormData(f_asal);
        //var gr = 'id_group_soal_' + urutan;
        //var group = form[gr];
        var group = $("input[name=id_group_soal_" + urutan + "]").val();

        $.ajax({
            type: "POST",
            url: base_url + "website/user/Ujian/buka_group",
            data: 'id_group=' + group + '&urutan=' + urutan,
            dataType: 'json',
            success: function(data) {
                // Add response in Modal body
                $('#title-group').html(data.judul);
                $('#body-group').html(data.petunjuk);
                $('#footer-group').html(data.footer);

                // Display Modal
                $('#petunjukModal').modal('show');

                if (urutan != 1) {
                    $("html, body").animate({
                        scrollTop: $('.tampilan_soal_jwb').offset().top
                    }, 1000);
                }
            },
            error: function(request, status, error) {
                alert("Terjadi kesalahan. Silahkan ulangi kembali!");
            }
        });
    }

    function get_opsi_jawaban_selected(num, opsi) {
        let class_limit_jawaban = 'opsi_jawaban_' + num;
        let limit_opsi_choosen = parseInt(document.getElementById(class_limit_jawaban).value);

        if ($('[name="opsi_' + num + '[]"]:checked').length > limit_opsi_choosen) {
            $('#opsi_' + opsi + '_' + num).prop('checked', false);
            return alert("Hanya boleh pilih " + limit_opsi_choosen + " jawaban");
        } else {
            simpan_sementara_satu(num, opsi);
            simpan();
        }
    }

    async function simpan() {
        //simpan_sementara();
        var form = $("#ujian");

        $.ajax({
            type: "POST",
            url: base_url + "website/user/Ujian/simpan_satu",
            data: form.serialize(),
            dataType: 'json',
            success: function(data) {
                if (data.status == "gagal") {
                    alert("Gagal menyimpan jawaban. Mohon ulangi pilih jawaban anda kembali!");
                }
            },
            error: function(request, status, error) {
                alert("Terjadi kesalahan. Silahkan ulangi kembali!");
            }
        });
    }

    //Partial load navigasi soal
    function simpan_sementara_satu(nums, opsis) {
        var ragus = $("input[name=rg_" + nums + "]").val();

        //Content jawaban
        var sp = "";
        if ($("input[name='opsi_" + nums + "[]']:checked").length > 1) { //Mapping jawaban multi
            for (var z = 0; z < $("input[name='opsi_" + nums + "[]']:checked").length; z++) {
                var a = $("input[name='opsi_" + nums + "[]']:checked")[z];
                sp = $("input[name='opsi_" + nums + "[]']:checked").length = z ? sp + a.value.split('|')[1] : sp + a.value.split('|')[1] + ':';
            }
        } else if ($("input[name='opsi_" + nums + "[]']:checked").length == 1) {
            for (var v = 0; v < $("input[name='opsi_" + nums + "[]']:checked").length; v++) {
                var h = $("input[name='opsi_" + nums + "[]']:checked")[v];
                sp = sp + h.value.split('|')[1];
            }
        }

        var arr_jawab_content_all = new Array();
        var jawab_content_all = sp.split(":");
        for (var d = 0; d < jawab_content_all.length; d++) {
            arr_jawab_content_all.push(number_opsi_text(jawab_content_all[d]));
        }
        jawab_content = arr_jawab_content_all.length > 0 ? arr_jawab_content_all.join() : '-';

        if (ragus == "Y") {
            if (opsis == "-") {
                document.getElementById('btn_soal_' + nums).className = "btn button-round btn-outline-secondary text-secondary btn_soal";
            } else {
                document.getElementById('btn_soal_' + nums).className = "btn button-round btn-warning btn_soal";
            }
        } else {
            if (opsis == "-") {
                document.getElementById('btn_soal_' + nums).className = "btn button-round btn-outline-secondary text-secondary btn_soal";
            } else {
                document.getElementById('btn_soal_' + nums).className = "btn button-round btn-success btn_soal";
            }
        }

        document.getElementById('btn_soal_' + nums).innerHTML = nums + ". " + jawab_content;
    }

    //Hanya untuk awalan load - navigasi soal
    async function simpan_sementara() {
        var f_asal = $("#ujian");
        var form = getFormData(f_asal);
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

            if (group_m == 1) { //1 Pilihan Ganda 2 Essay
                var idx = 'opsi_' + i;
                var jwb_exp = form[idx];
                var jawab_pro = jwb_exp == undefined ? '' : jwb_exp;
                var jawab = jawab_pro;
            } else {
                var idx = 'essay_' + i;
                var jawab = form[idx] == '' ? undefined : form[idx];
            }

            var check = '<i style="margin-left:3px;" class="fa fa-check fa-xs"></i>';
            var times = '<i style="margin-left:3px;" class="fa fa-times fa-xs"></i>';

            //Parent group jika ada
            if (group != group_before && group != 0) {
                hasil_jawaban += '<a id="group_petunjuk_' + (i) + '" class="btn btn-primary btn-block text-white btn_group" onclick="return buka_group(' + (i) + ');">' + group_name + "</a>";
                group_number++;
            }

            //Sub group
            if (sub_group_after != sub_group_before && sub_group_after != group_name_first) {
                hasil_jawaban += '<div class="d-flex justify-content-center"><a id="sub_group_petunjuk_' + (i) + '" class="btn btn-secondary btn-block text-white disabled btn_sub_group">' + sub_group_after + "</a></div>";
            }

            //Isi Nomor
            if (jawab) { //Jika ada jawabannya
                if (group_m == 1) {
                    var arr_jawab_content_all = new Array();
                    var jawab_content_all = jawab.split(":");
                    for (var d = 0; d < jawab_content_all.length; d++) {
                        arr_jawab_content_all.push(number_opsi_text(jawab_content_all[d]));
                    }
                    jawab_content = arr_jawab_content_all.join();
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
                if (group_m == 1) {
                    jawab_content = '-';
                } else {
                    jawab_content = times;
                }

                hasil_jawaban += '<a id="btn_soal_' + (i) + '" class="btn button-round btn-outline-secondary text-secondary btn_soal" onclick="return buka(' + (i) + ');">' + (i) + ". " + jawab_content + "</a>";
            }

            var group_before = group;
            var sub_group_before = sub_group_after;
        }

        if (is_continuous == 1) {
            var cont = document.getElementById('panel-toogle-soal');
            cont.style.display = 'none';
            document.getElementById("button-nav").disabled = true;
            document.getElementById('toogle-navigasi-ico').className = 'fa fa-chevron-circle-up'; //Ganti Icon Navigasi
            document.getElementById('lembar_soal').className = 'col-sm-12 col-md-12 mb-3'; //Ganti Panjang Desai Lembar Soal
        } else {
            $("#tampil_jawaban").html('<div id="yes"></div>' + hasil_jawaban);
        }
    }

    function done_soal() {
        //simpan();
        if (confirm('Yakin ingin mengakhiri tes?')) {
            selesai();
        }
    }

    function selesai() {
        //simpan();
        $.ajax({
            type: "POST",
            url: base_url + "website/user/Ujian/simpan_akhir",
            data: {
                id: id_tes
            },
            beforeSend: function() {
                simpan();
            },
            success: function(r) {
                if (r.status) {
                    if (r.hasil == 1) {
                        window.location.href = base_url + 'result/' + r.id + '/' + r.ranking;
                    } else {
                        window.location.href = base_url + 'dashboard';
                    }
                } else {
                    alert("Gagal memproses menyimpan jawaban. Harap hubungi admin!");
                }
            },
            error: function(request, status, error) {
                //alert(request.responseText);
                alert("Gagal memproses menyimpan jawaban. Harap hubungi admin!");
            }
        });
    }

    function waktuHabis() {
        swal("Informasi", "Waktu ujian telah habis!", "info");
        setTimeout(() => {
            swal("Informasi", "Waktu ujian telah habis!", "info");
        }, 500);
        setTimeout(() => {
            swal("Informasi", "Sedang menyimpan jawaban. Mohon Tunggu.", "info");
        }, 1500);
        setTimeout(() => {
            swal("Informasi", "Mengalihkan", "info");
        }, 2000);
        setTimeout(() => {
            selesai();
        }, 2500);
    }
</script>

<!-- Increase Decrease Font Lembar Soal -->
<script>
    function _increase() {
        var fontSize = $('.card-text').css('font-size');
        var newFontSize = parseInt(fontSize) + 1;

        $('.card-text').css('font-size', newFontSize + 'px')
        $('.huruf_opsi').css('font-size', newFontSize + 'px')
    }

    function _decrease() {
        var fontSize = $('.card-text').css('font-size');
        var newFontSize = parseInt(fontSize) - 1;

        $('.card-text').css('font-size', newFontSize + 'px')
        $('.huruf_opsi').css('font-size', newFontSize + 'px')
    }

    function _reset() {
        $('.card-text').css('font-size', '16px')
        $('.huruf_opsi').css('font-size', '16px')
    }
</script>

<!-- User pindah tab lain atau pindah dari browser aktif sekarang -->
<script type="text/javascript">
    document.addEventListener("visibilitychange", event => {
        if (blok_layar != 0) {
            var modal = document.getElementById("alert-away");
            var timeleft = blok_layar;

            if (document.visibilityState == "visible") {
                var openBlockTimer = setInterval(function() {
                    timeleft--;
                    document.getElementById("countdownblocktimer").innerHTML = timeleft;
                    if (timeleft == 0) {
                        clearInterval(openBlockTimer);
                        modal.style.display = "none";
                    }
                }, 1000);
            } else {
                document.getElementById("msg_title_away").innerHTML = "PESAN SISTEM!";
                document.getElementById("msg_content_away").innerHTML = "Anda terdeteksi meninggalkan halaman ini.";
                document.getElementById("msg_footer_away").innerHTML = "Tunggu waktu penalti selesai untuk dapat melanjutkan pengerjaan soal kembali.";
                modal.style.display = "block";
            }
        }
    })
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

<!-- LOADING HALAMAN -->
<script>
    $(window).on('load', function() {
        $('#loading').hide();
    })
</script>