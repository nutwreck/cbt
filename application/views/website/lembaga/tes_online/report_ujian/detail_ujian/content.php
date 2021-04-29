<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title><?=$title?></title>
    <style media="all" type="text/css" rel="stylesheet" href="<?=config_item('_assets_website')?>css/print.css"></style>
    <style>
    *{
        box-sizing:border-box;
        margin:0;
    }
    body{
        background-color:#ffffff;
    }
    html,body{
        font-family: "Arial",sans-serif;
        font-weight: 400;
        font-size: 1em;
    }
    container {
        width: 100%;
    }
    .header{
        margin:20px;
        padding:10px;
        border: 2px solid;
    }
    soal {
        margin-left:20px;
        position:relative;
        width:100%;
        max-width:400px;
        border-radius:0px;
    }
    panel {
        top:-1px;
        position:relative;
        width:100%;
    }
    quiz {
        top:-1px;
        position:relative;
        width:100%;
    }
    .btn {
        display: block;
        height: 20px;
        width: 20px;
        border-radius: 50%;
        border: 1px solid black;
        text-align: center;
        margin: 4px;
    }
    .group-name{
        margin-top:10px;
        margin-bottom:5px;margin-left:20px
    }
    .tbl-soal{
        border:0;table-layout: fixed;margin-left:30px;
    }
    .tbl-jwb {
        border:0;
        table-layout: fixed;
        margin-left:60px;
    }
    .jawaban {
        background-color: green;
        color: white;
    }
    a,
    a:hover,
    a:focus {
        color: inherit;
        text-decoration: none;
        transition: all 0.3s;
    }
    </style>
</head>
<body>
    <container>
        <div class="header">
            <table style="border:0;">
                <tr>
                    <td>Nama Paket Soal</td><td>:</td><td><?=$sesi_pelaksana->nama_paket_soal?></td>
                </tr>
                <tr>
                    <td>Materi</td><td>:</td><td><?=$sesi_pelaksana->materi_name?></td>
                </tr>
                <tr>
                    <td>Nomor Peserta</td><td>:</td><td><?=$ujian->user_no?></td>
                </tr>
                <tr>
                    <td>Nama Peserta</td><td>:</td><td><?=$ujian->user_name?></td>
                </tr>
            </table>
        </div>
        <?=$ljk?>
    </container>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" integrity="sha512-3P8rXCuGJdNZOnUx/03c1jOTnMn3rP63nBip5gOP2qmUh5YAdVAvFZ1E+QLZZbC1rtMrQb+mah3AfYW11RUrWA==" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            window.print();
        });
    </script>
</body>
</html>