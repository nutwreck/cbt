    <!-- Jquery JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha512-3P8rXCuGJdNZOnUx/03c1jOTnMn3rP63nBip5gOP2qmUh5YAdVAvFZ1E+QLZZbC1rtMrQb+mah3AfYW11RUrWA==" crossorigin="anonymous"></script>
    <!-- Bootstrap JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- Vendor JS       -->
    <script src="<?php echo config_item('_assets_general'); ?>slick/slick.min.js"></script>
    <script src="<?php echo config_item('_assets_general'); ?>wow/wow.min.js"></script>
    <script src="<?php echo config_item('_assets_general'); ?>animsition/animsition.min.js"></script>
    <script src="<?php echo config_item('_assets_general'); ?>bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="<?php echo config_item('_assets_general'); ?>counter-up/jquery.waypoints.min.js"></script>
    <script src="<?php echo config_item('_assets_general'); ?>counter-up/jquery.counterup.min.js"></script>
    <script src="<?php echo config_item('_assets_general'); ?>circle-progress/circle-progress.min.js"></script>
    <script src="<?php echo config_item('_assets_general'); ?>perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?php echo config_item('_assets_general'); ?>chartjs/Chart.bundle.min.js"></script>
    <script src="<?php echo config_item('_assets_general'); ?>select2/select2.min.js"></script>

    <!-- Main JS-->
    <script src="<?php echo config_item('_assets_general'); ?>js/main.js"></script>

    <!-- pop up -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        /* Universal Config */
        var base_url = '<?= base_url() ?>';
        var csrfname = '<?= $this->security->get_csrf_token_name() ?>';
    </script>

    <script type="text/javascript">
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
            "hideMethod": "fadeOut"
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

    <script>
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