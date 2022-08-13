<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">
    <!-- favicon -->
    <link rel="shortcut icon" href="<?php echo config_item('_assets_general'); ?>favicon/favicon.ico">

    <!-- Title Page-->
    <title>Login</title>

    <!-- Fontfaces CSS-->
    <link href="<?php echo config_item('_assets_general'); ?>css/font-face.css" rel="stylesheet" media="all">
    <link href="<?php echo config_item('_assets_general'); ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="<?php echo config_item('_assets_general'); ?>mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <!-- Vendor CSS-->
    <link href="<?php echo config_item('_assets_general'); ?>animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="<?php echo config_item('_assets_general'); ?>bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="<?php echo config_item('_assets_general'); ?>wow/animate.css" rel="stylesheet" media="all">
    <link href="<?php echo config_item('_assets_general'); ?>css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="<?php echo config_item('_assets_general'); ?>slick/slick.css" rel="stylesheet" media="all">
    <link href="<?php echo config_item('_assets_general'); ?>select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?php echo config_item('_assets_general'); ?>perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Pop Up -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />

    <!-- Main CSS-->
    <link href="<?php echo config_item('_assets_general'); ?>css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <h1>Login</h1>
                        </div>
                        <div class="login-form">
                            <form method="POST" action="<?= site_url('admin/submit-login') ?>" novalidate="novalidate">
                                <input type="hidden" id="csrf-hash-form" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="au-input au-input--full" type="username" name="username" placeholder="Masukkan Email">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" type="password" name="password" placeholder="Masukkan Password">
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

</body>

</html>
<!-- end document-->