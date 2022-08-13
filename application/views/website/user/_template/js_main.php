    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha512-+NqPlbbtM1QqiK8ZAo4Yrj2c4lNQoGv8P79DPtKzj++l5jnN39rHA/xsqn8zE9l0uSoxaCdrOgFs6yjyfbBxSg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- OFFLINE -->
    <script src="<?php echo config_item('_assets_general'); ?>offline/offline.min.js"></script>
    <link rel="stylesheet" href="<?php echo config_item('_assets_general'); ?>offline/themes/offline-theme-default.css">
    <link rel="stylesheet" href="<?php echo config_item('_assets_general'); ?>offline/themes/offline-language-english.css">

    <!-- Moment JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.0/moment.min.js" integrity="sha512-ls52wG0HG5y4APAupGDjukiKRHQN6wyBhbVqRSwfrIbbM0lYVby+T5tOSVtG6xtR+SOYQcCacuU/moJAyAe7hQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- POP UP FROM PHP TO JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- ALERT -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <script type="text/javascript">
        //DOCUMENT SET ROOT
        $(document).ready(function() {
            //Offline JS check koneksi internet user
            Offline.options = {
                // to check the connection status immediatly on page load.
                checkOnLoad: false,

                // to monitor AJAX requests to check connection.
                interceptRequests: true,

                // to automatically retest periodically when the connection is down (set to false to disable).
                reconnect: {
                    // delay time in seconds to wait before rechecking.
                    initialDelay: 3,

                    // wait time in seconds between retries.
                    delay: 10
                },

                // to store and attempt to remake requests which failed while the connection was down.
                requests: true
            };
        });
    </script>

    <script type="text/javascript">
        var base_url = '<?= base_url() ?>'; //GLOBAL CONFIG UNTUK BASE URL SEMUA YANG DIPAKAI DI JS

        //SISA WAKTU UJIAN / TIMER
        function sisawaktu(t, id_tes, nows) {
            const end = moment(t);
            const today = moment(nows);
            const diff_ms = end.diff(today, 'miliseconds');
            if (diff_ms > 0) {
                try {
                    const end = moment(t);
                    var x = setInterval(function() {
                            var now = moment();
                            var ms = end.diff(now, 'miliseconds');
                            var d = moment.duration(ms);
                            var s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm:ss");
                            $('.sisawaktu').html(s);
                        },
                        1000);
                    setTimeout(function() {
                        clearInterval(x);
                        var cd = "00:00:00";
                        $('.sisawaktu').html(cd);
                        waktuHabis();
                    }, (diff_ms));
                } catch (e) {
                    $.ajax({
                        type: "POST",
                        url: base_url + "website/user/Ujian/disable_ujian",
                        data: {
                            id: id_tes
                        },
                        dataType: 'json',
                        success: function(data) {
                            swal({
                                title: "Informasi",
                                text: "Browser anda tidak support untuk mengerjakan ujian!",
                                button: "Kembali",
                                icon: "info"
                            }).then(okay => {
                                if (okay) {
                                    window.location.href = base_url + 'dashboard';
                                }
                            });
                        },
                        error: function(request, status, error) {
                            alert("Terjadi kesalahan. Silahkan refresh ulang halaman ini!");
                        }
                    });
                }
            } else {
                $.ajax({
                    type: "POST",
                    url: base_url + "website/user/Ujian/disable_ujian",
                    data: {
                        id: id_tes
                    },
                    dataType: 'json',
                    success: function(data) {
                        swal({
                            title: "Informasi",
                            text: "Browser anda tidak support untuk mengerjakan ujian!",
                            button: "Kembali",
                            icon: "info"
                        }).then(okay => {
                            if (okay) {
                                window.location.href = base_url + 'dashboard';
                            }
                        });
                    },
                    error: function(request, status, error) {
                        alert("Terjadi kesalahan. Silahkan refresh ulang halaman ini!");
                    }
                });
            }
        }

        //KONFIGURASI UNTUK REQUEST POST DATA KE CONTROLLER
        function ajaxcsrf() {
            var csrfname = '<?= $this->security->get_csrf_token_name() ?>';
            var csrfhash = '<?= $this->security->get_csrf_hash() ?>';
            var csrf = {};
            csrf[csrfname] = csrfhash;
            $.ajaxSetup({
                "data": csrf
            });
        }
    </script>

    <script type="text/javascript">
        //POP UP
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "2000",
            "hideDuration": "2000",
            "timeOut": "7000",
            "extendedTimeOut": "2000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut",
            "escapeHtml": "true"
        }

        <?php if ($this->session->flashdata('success')) { ?>
            toastr.success("<?php echo $this->session->flashdata('success'); ?>");
            <?php $this->session->unset_userdata('success'); ?>
        <?php } else if ($this->session->flashdata('error')) {  ?>
            toastr.error("<?php echo $this->session->flashdata('error'); ?>");
            <?php $this->session->unset_userdata('error'); ?>
        <?php } else if ($this->session->flashdata('warning')) {  ?>
            toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
            <?php $this->session->unset_userdata('warning'); ?>
        <?php } else if ($this->session->flashdata('info')) {  ?>
            toastr.info("<?php echo $this->session->flashdata('info'); ?>");
            <?php $this->session->unset_userdata('info'); ?>
        <?php } ?>
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>