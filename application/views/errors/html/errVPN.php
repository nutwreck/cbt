<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>404</title>
      <link rel="shortcut icon" href="<?php echo config_item('_assets_general'); ?>favicon/favicon.ico">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    </head>
    <body>
       <section style="height: 100%; width: 100%; box-sizing: border-box; background-color: #141432">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        .main-empty-4-7{
                padding-left: 2rem;
                padding-right: 2rem;
                padding-top: 2.5rem;
                padding-bottom: 2rem;
            }
        .main-img-empty-4-7{
            object-fit: cover;
            object-position: center;
            margin-bottom: 0.5rem;
            width: 83.333333%;
        }
        .title-text-empty-4-7{
            font-size: 1.875rem;
            line-height: 2.25rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
        }
        .title-caption-empty-4-7{
            margin-bottom: 4rem;
            letter-spacing: 0.025em;
            line-height: 1.75rem;
        }
        .btn-empty-4-7{
            color: #FFFFFF;
            font-weight: 600;
            font-size: 1.125rem;
            line-height: 1.75rem;
            line-height: 1.75rem;
            padding: 1rem 1.5rem 1rem 1.5rem;
            border-radius: 0.75rem;
            border: none;
        }
        .btn-empty-4-7:hover{
            color: #FFFFFF;
            --tw-shadow: inset 0 0px 25px 0 rgba(20, 20, 50, 0.7);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        }
        @media(min-width: 425px){
          .title-text-empty-4-7{
            font-size: 40px;
          }
        }
        @media (min-width: 576px) {
            .main-empty-4-7{
                padding-left: 2rem;
                padding-right: 2rem;
                padding-top: 3.5rem;
                padding-bottom: 4rem;
            }
            .main-img-empty-4-7{
            margin-bottom: 0.625rem;
            width: auto;
            }
        }
        @media (min-width: 768px) {
            .main-empty-4-7{
                padding-left: 4rem;
                padding-right: 4rem;
            }
            .lg-show-empty-4-7{
            display: block;
            }
            .lg-hide-empty-4-7{
                display: none;
            }
        }
        @media (min-width: 992px) {
            .main-empty-4-7{
                padding-left: 6rem;
                padding-right: 6rem;
            }
        }
        @media (max-width: 768px) {
            .lg-show-empty-4-7{
            display: none;
            }
            .lg-hide-empty-4-7{
                display: block;
            }
        }
    </style>
    <div class="main-empty-4-7 container mx-auto d-flex align-items-center justify-content-center flex-column" style="font-family: 'Poppins', sans-serif;">    

        <div class="text-center w-100">
            <h1 class="title-text-empty-4-7"
            style="color: #FFFFFF;">Opss! Something Missing</h1>
            <p class="lg-show-empty-4-7 title-caption-empty-4-7"
            style="color: #707092;">Lokasi anda terdeteksi tidak berada diwilayah Indonesia. Silahkan matikan VPN jika anda memakai VPN dan Restart koneksi anda.</p>
            <div class="d-flex justify-content-center">
                <button class="btn btn-empty-4-7 d-inline-flex"
                style="background: #524EEE;" onclick="goBack()">Kembali</button>
            </div>
        </div>
    </div>

  </section> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    </body>
  </html>