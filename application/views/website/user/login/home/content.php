<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Candra Aji Pamungkas | candraajipamungkas@gmail.com">
    <meta name="description" content="Aplikasi ujian online &amp; ujian online berbasis komputer dengan mudah cepat dan praktis">
    <link rel="shortcut icon" href="<?php echo config_item('_assets_general'); ?>favicon/favicon.ico">
    <meta property="og:description" content="Aplikasi ujian online &amp; ujian online berbasis komputer dengan mudah cepat dan praktis">
    <meta property="og:title" content="Aplikasi Ujian Online">
    <meta name="twitter:description" content="Aplikasi ujian online &amp; ujian online berbasis komputer dengan mudah cepat dan praktis">
    <meta name="twitter:title" content="Aplikasi Ujian Online">

    <title>Zambert Online Test | Register</title>

    <noscript>
        <meta http-equiv="Refresh" content="0;<?php echo base_url(); ?>javascript-not-available">
    </noscript>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- ICON -->
    <link rel="stylesheet" href="<?php echo config_item('_assets_general'); ?>font-awesome/css/font-awesome.min.css">
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
    <!-- POP UP -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha512-+NqPlbbtM1QqiK8ZAo4Yrj2c4lNQoGv8P79DPtKzj++l5jnN39rHA/xsqn8zE9l0uSoxaCdrOgFs6yjyfbBxSg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- POP UP FROM PHP TO JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- FONT -->
    <link href="https://fonts.cdnfonts.com/css/arial-rounded-mt-bold" rel="stylesheet">

    <style>
        @import url('https://fonts.cdnfonts.com/css/kg-happy');

        .border-md {
            border-width: 2px;
        }

        .btn-facebook {
            background: #405D9D;
            border: none;
        }

        .btn-facebook:hover,
        .btn-facebook:focus {
            background: #314879;
        }

        .btn-twitter {
            background: #42AEEC;
            border: none;
        }

        .btn-twitter:hover,
        .btn-twitter:focus {
            background: #1799e4;
        }

        body {
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        .form-control:not(select) {
            padding: 1.5rem 0.5rem;
        }

        select.form-control {
            height: 52px;
            padding-left: 0.5rem;
        }

        .form-control::placeholder {
            color: #ccc;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .form-rounded {
            border-radius: 1rem;
        }

        .fs-20 {
            font-size: 20px;
        }

        .fs-18 {
            font-size: 18px;
        }

        .font-arial-bold {
            font-family: 'Arial Rounded MT Bold', sans-serif;
            font-weight: bold;
        }

        .font-kg-happy {
            font-family: 'KG HAPPY', sans-serif;
        }

        .ls-1 {
            letter-spacing: 1px;
        }
    </style>
</head>

<body>
    <!-- Navbar-->
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light py-0">
            <div class="container">
                <!-- Navbar Brand -->
                <a href="<?= base_url() ?>" class="navbar-brand">
                    <img src="<?= config_item('_assets_general') ?>header_logo/header_logo_user.png" alt="logo" width="150">
                </a>

                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ml-auto font-arial-bold fs-20">
                        <a href="<?= base_url() ?>" class="nav-item nav-link text-primary">Home</a>
                        <a href="<?= base_url() ?>#features" class="nav-item nav-link text-primary">Keunggulan</a>
                        <a href="<?= base_url() ?>#details" class="nav-item nav-link text-primary">Testimoni</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="row py-3 mt-4 align-items-center">
            <!-- For Demo Purpose -->
            <div class="col-md-5 pr-lg-5 mb-5 mb-md-0">
                <img src="<?= config_item('_assets_general') ?>image/bg-home.png" alt="daftarimages" class="img-fluid mb-3">
                <!--d-none d-md-block-->
                <h2 class="font-kg-happy">Tes Online Zambert</h2>
                <p class="text-primary mb-0 font-arial-bold fs-20">Tes online dan pembelian buku.</p>
            </div>

            <!-- Registeration Form -->
            <div class="col-md-7 col-lg-6 ml-auto">
                <form id="form_register" name="form_register" action="<?php echo base_url(); ?>website/user/Login/submit_register" class="form-register" method="POST" enctype="multipart/form-data" onsubmit="return(validate_register());">
                    <input type="hidden" id="csrf-hash-form" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                    <input type="hidden" id="timezone" name="timezone" value="Asia/Jakarta" style="display: none">
                    <div class="row">

                        <div class="input-group col-lg-12 mb-4">
                            <h1 class="font-arial-bold ls-1">DAFTAR AKUN <br /> ZAMBERT CLASS</h1>
                        </div>

                        <div class="input-group col-lg-12">
                            <h6 class="font-arial-bold text-secondary">Daftar akun Zambert Class gratis</h6>
                        </div>

                        <!-- Name -->
                        <div class="input-group col-lg-12 mb-4">
                            <!-- <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0 form-rounded shadow">
                                    <i class="fa fa-user text-muted"></i>
                                </span>
                            </div> border-left-0-->
                            <input id="input-name" type="text" name="name" placeholder="Nama Lengkap" onkeypress="return /[a-zA-Z ]/i.test(event.key)" class="form-control bg-white border-md form-rounded shadow" required>
                        </div>

                        <!-- Email Address -->
                        <div class="col-lg-12">
                            <small for="email" id="email_er" class="bg-danger text-white"></small>
                        </div>
                        <div class="input-group col-lg-12 mb-4">
                            <!-- <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0 form-rounded">
                                    <i class="fa fa-envelope text-muted"></i>
                                </span>
                            </div> -->
                            <input id="email" type="email" name="email" placeholder="Email Aktif" class="form-control bg-white border-md form-rounded shadow" required>
                        </div>

                        <!-- Phone Number -->
                        <div class="input-group col-lg-12 mb-4">
                            <!-- <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0 form-rounded">
                                    <i class="fa fa-phone-square text-muted"></i>
                                </span>
                            </div> -->
                            <input id="phoneNumber" type="tel" name="phone" placeholder="Nomor Telp Aktif. Ex : 085823445xxx" onkeypress="return /[0-9]/i.test(event.key)" minlength="10" maxlength="13" pattern=".{10,13}" title="Minimal 10 Angka Maksimal 13 Angka" class="form-control bg-white border-md form-rounded shadow" required>
                        </div>

                        <!-- Password -->
                        <div class="input-group col-lg-12 mb-4">
                            <!-- <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0 form-rounded">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                            </div> -->
                            <input id="password" type="password" name="password" placeholder="Password" class="form-control bg-white border-md form-rounded shadow" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group col-lg-12 mx-auto mb-0">
                            <button type="submit" class="btn btn-primary btn-block py-2 form-rounded">
                                <span class="font-weight-bold fs-20">Daftar Sekarang!</span>
                            </button>
                        </div>
                </form>
                <!-- Divider Text -->
                <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-2">
                    <div class="border-bottom w-100 ml-5"></div>
                    <span class="px-2 small text-muted font-weight-bold text-muted">Atau</span>
                    <div class="border-bottom w-100 mr-5"></div>
                </div>

                <!-- Already Registered -->
                <div class="text-center w-100">
                    <p class="text-muted font-weight-bold fs-18">Sudah Punya Akun? <a href="<?= base_url() ?>login" class="text-primary ml-2 fs-18">Login</a></p>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script type="text/javascript">
        //SET TIMEZONE
        $(document).ready(function() {
            try {
                const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                document.getElementById("timezone").value = timezone;
            } catch (err) {
                document.getElementById("timezone").value = "Asia/Jakarta";
            }
        });
    </script>

    <script>
        $(function() {
            $('input').on('focus', function() {
                $(this).parent().find('.input-group-text').css('border-color', '#80bdff');
            });
            $('input').on('blur', function() {
                $(this).parent().find('.input-group-text').css('border-color', '#ced4da');
            });
        });
    </script>

    <!-- Validasi Form Register -->
    <script>
        function validate_register() {
            var emailID = document.form_register.email.value;
            atpos = emailID.indexOf("@");
            dotpos = emailID.lastIndexOf(".");

            if (atpos < 1 || (dotpos - atpos < 2)) {
                document.getElementById('email_er').innerHTML = 'Input Email dengan benar!';
                document.form_register.email.focus();
                return false;
            }
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
</body>

</html>