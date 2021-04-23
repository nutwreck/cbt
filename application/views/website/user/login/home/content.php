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

    <style>
        .border-md {
            border-width: 2px;
        }

        .btn-facebook {
            background: #405D9D;
            border: none;
        }

        .btn-facebook:hover, .btn-facebook:focus {
            background: #314879;
        }

        .btn-twitter {
            background: #42AEEC;
            border: none;
        }

        .btn-twitter:hover, .btn-twitter:focus {
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
            font-weight: thin;
            font-size: 0.9rem;
        }
        .form-control:focus {
            box-shadow: none;
        }
    </style>
</head>
<body>
    <!-- Navbar-->
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light py-0">
            <div class="container">
                <!-- Navbar Brand -->
                <a href="<?=base_url()?>" class="navbar-brand">
                    <img src="<?=config_item('_assets_general')?>header_logo/header_logo_user.png" alt="logo" width="150">
                </a>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="row py-3 mt-4 align-items-center">
            <!-- For Demo Purpose -->
            <div class="col-md-5 pr-lg-5 mb-5 mb-md-0">
                <img src="https://res.cloudinary.com/mhmd/image/upload/v1569543678/form_d9sh6m.svg" alt="" class="img-fluid mb-3 d-none d-md-block">
                <h1>Tes Online Zambert</h1>
                <p class="font-italic text-muted mb-0">Tes online dan pembelian buku.</p>
            </div>

            <!-- Registeration Form -->
            <div class="col-md-7 col-lg-6 ml-auto">
                <form id="form_register" name="form_register" action="<?php echo base_url(); ?>website/user/Login/submit_register" class="form-register" method="POST" enctype="multipart/form-data" onsubmit="return(validate_register());">
                    <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <div class="row">

                        <!-- Name -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-user text-muted"></i>
                                </span>
                            </div>
                            <input id="input-name" type="text" name="name" placeholder="Masukkan Nama Anda" onkeypress="return /[a-zA-Z ]/i.test(event.key)" class="form-control bg-white border-left-0 border-md" required>
                        </div>

                        <!-- Email Address -->
                        <div class="col-lg-12">
                            <small for="email" id="email_er" class="bg-danger text-white"></small>
                        </div>
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-envelope text-muted"></i>
                                </span>
                            </div>
                            <input id="email" type="email" name="email" placeholder="Masukkan Email Aktif" class="form-control bg-white border-left-0 border-md" required>
                        </div>

                        <!-- Phone Number -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-phone-square text-muted"></i>
                                </span>
                            </div>
                            <input id="phoneNumber" type="tel" name="phone" placeholder="Nomor Telp Aktif. Ex : 085823445xxx" onkeypress="return /[0-9]/i.test(event.key)" minlength="10" maxlength="13" pattern=".{10,13}" title="Minimal 10 Angka Maksimal 13 Angka" class="form-control bg-white border-md border-left-0" required>
                        </div>

                        <!-- Password -->
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                            </div>
                            <input id="password" type="password" name="password" placeholder="Password" class="form-control bg-white border-left-0 border-md" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group col-lg-12 mx-auto mb-0">
                            <button type="submit" class="btn btn-primary btn-block py-2">
                                <span class="font-weight-bold">Daftar Sekarang!</span>
                            </button>
                        </div>
                </form>
                        <!-- Divider Text -->
                        <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                            <div class="border-bottom w-100 ml-5"></div>
                            <span class="px-2 small text-muted font-weight-bold text-muted">Atau</span>
                            <div class="border-bottom w-100 mr-5"></div>
                        </div>

                        <!-- Already Registered -->
                        <div class="text-center w-100">
                            <p class="text-muted font-weight-bold">Sudah Punya Akun? <a href="<?=base_url()?>login" class="text-primary ml-2">Login</a></p>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('input').on('focus', function () {
                $(this).parent().find('.input-group-text').css('border-color', '#80bdff');
            });
            $('input').on('blur', function () {
                $(this).parent().find('.input-group-text').css('border-color', '#ced4da');
            });
        });
    </script>
    
    <!-- Validasi Form Register -->
    <script>
        function validate_register(){
            var emailID = document.form_register.email.value;
            atpos = emailID.indexOf("@");
            dotpos = emailID.lastIndexOf(".");
            
            if (atpos < 1 || ( dotpos - atpos < 2 )) {
                document.getElementById('email_er').innerHTML = 'Input Email dengan benar!';
                document.form_register.email.focus() ;
                return false;
            }
        }
    </script>

    <script type="text/javascript"> //POP UP
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

        <?php if($this->session->flashdata('success')){ ?>
            toastr.success("<?php echo $this->session->flashdata('success'); ?>");
        <?php }else if($this->session->flashdata('error')){  ?>
            toastr.error("<?php echo $this->session->flashdata('error'); ?>");
        <?php }else if($this->session->flashdata('warning')){  ?>
            toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
        <?php }else if($this->session->flashdata('info')){  ?>
            toastr.info("<?php echo $this->session->flashdata('info'); ?>");
        <?php } ?>
    </script>
</body>
</html>