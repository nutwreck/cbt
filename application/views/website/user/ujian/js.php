<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/3.3.1/intro.min.js" integrity="sha512-NC1GtvckWJQLUHrSQp5+4ydIv6gW8kfP4Ewrwv8Y1xU1h9GTTaXDTnWl+kjHcZNCaX8ySFNSpPmtt/B4SUaDsQ==" crossorigin="anonymous"></script>
<script src="<?php echo config_item('_assets_website'); ?>dark-mode-switch/dark-mode-switch.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/katex.min.js" integrity="sha384-FaFLTlohFghEIZkw6VGwmf9ISTubWAVYW8tG8+w2LAIftJEULZABrF9PPFv+tVkH" crossorigin="anonymous"></script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/contrib/auto-render.min.js" integrity="sha384-bHBqxz8fokvgoJ/sc17HODNxa42TlaEhB+w8ZJXTc2nZf1VgEaFZeZvT4Mznfz0v" crossorigin="anonymous" onload="renderMathInElement(document.body);"></script>

<script> //DOCUMENT SET ROOT
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
        (".step").hide();
        $("#widget_1").show();
    });

    function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };
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

<!-- For Mobile Menu SideBar --> 
<!-- <script> FOR NEXT DESIGN UJIAN
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
                document.getElementById('collaps-icon').className = 'fa fa-expand'; //Ganti Icon Toogle Sidebar
            } else {
                content.style.display = "block";
                document.getElementById('collaps-icon').className = 'fa fa-compress'; //Ganti Icon Toogle Sidebar
            }
        });
    }
</script> -->

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

<!-- TIMER -->
<script>
    function waktuHabis() {
        alert('');
        swal("Informasi", "Waktu ujian telah habis!", "info");
        window.location.href = base_url + 'dashboard';
    }
</script>

<!-- Increase Decrease Font Lembar Soal -->
<script>
    $('#_increase').on('click', function() {
        var fontSize = $('.card-text').css('font-size');
        var newFontSize = parseInt(fontSize)+1;
        
        $('.card-text').css('font-size', newFontSize+'px')
        $('.huruf_opsi').css('font-size', newFontSize+'px')
    })

    $('#_decrease').on('click', function() {
        var fontSize = $('.card-text').css('font-size');
        var newFontSize = parseInt(fontSize)-1;
        
        $('.card-text').css('font-size', newFontSize+'px')
        $('.huruf_opsi').css('font-size', newFontSize+'px')
    })

    $('#_reset').on('click', function() {
        $('.card-text').css('font-size', '16px')
        $('.huruf_opsi').css('font-size', '16px')
    })
</script>

<!-- SELESAI MENGERJAKAN -->
<script>
    function done_soal(){
        swal({ title: "Good job!",
            text: "Anda sudah menyelesaikan pengerjaan soal ini",
            button: "Dashboard",
            icon: "success"}).then(okay => {
            if (okay) {
                window.location.href = base_url + 'dashboard';
            }
        });
    }
</script>