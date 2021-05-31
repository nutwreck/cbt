<!-- 
|
| CSS By Candra Aji Pamungkas
| candraajipamungkas@gmail.com
|
-->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

<style>
    .sesi-head{
        font-size: 20px;
        letter-spacing: 0.5px;
    }

    .sesi-detail{
        font-size:80%;
    }

    .btn-mulai {
        font-weight: 700;
        color: rgba(103, 192, 103, 1);
        letter-spacing: 1px;
        border: 2px solid rgba(103, 192, 103, 0.75);
        border-radius: 40px;
        background: transparent;
        transition: all 0.3s ease 0s;
    }
    
    .btn-mulai:hover {
        color: #FFF;
        background: rgb(103, 192, 103, 0.75);
        border: 2px solid rgb(103, 192, 103, 0.75);
    }

    #main {
        margin: 50px 0;
    }

    #main #faq .card {
        margin-bottom: 30px;
        border: 0;
    }

    #main #faq .card .card-header {
        border: 0;
        -webkit-box-shadow: 0 0 20px 0 rgba(213, 213, 213, 0.5);
                box-shadow: 0 0 20px 0 rgba(213, 213, 213, 0.5);
        border-radius: 2px;
        padding: 0;
    }

    #main #faq .card .card-header .btn-header-link {
        color: #fff;
        display: block;
        text-align: left;
        font-size: 100%;
        background: rgb(117,115,224);
        background: -moz-linear-gradient(90deg, rgba(117,115,224,1) 0%, rgba(89,137,255,1) 29%, rgba(0,212,255,1) 100%);
        background: -webkit-linear-gradient(90deg, rgba(117,115,224,1) 0%, rgba(89,137,255,1) 29%, rgba(0,212,255,1) 100%);
        background: linear-gradient(90deg, rgba(117,115,224,1) 0%, rgba(89,137,255,1) 29%, rgba(0,212,255,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#7573e0",endColorstr="#00d4ff",GradientType=1);
        color: #fff;
        padding: 20px;
    }

    #main #faq .card .card-header .btn-header-link:after {
        content: "\f107";
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        float: right;
    }

    #main #faq .card .card-header .btn-header-link.collapsed {
        background: rgb(91,47,252);
        background: -moz-linear-gradient(90deg, rgba(91,47,252,1) 0%, rgba(83,64,252,1) 29%, rgba(0,108,255,1) 100%);
        background: -webkit-linear-gradient(90deg, rgba(91,47,252,1) 0%, rgba(83,64,252,1) 29%, rgba(0,108,255,1) 100%);
        background: linear-gradient(90deg, rgba(91,47,252,1) 0%, rgba(83,64,252,1) 29%, rgba(0,108,255,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#5b2ffc",endColorstr="#006cff",GradientType=1);
        color: #fff;
    }

    #main #faq .card .card-header .btn-header-link.collapsed:after {
        content: "\f106";
    }

    #main #faq .card .collapsing {
        background: #E8FFFE;
        line-height: 30px;
    }

    #main #faq .card .collapse {
        border: 0;
    }

    #main #faq .card .collapse.show {
        background: #E8FFFE;
        line-height: 30px;
        color: #222;
    }

    .pointer{
        cursor: pointer;
    }

    .table-responsive3 {
        display: table;
        width: 100%;
    }

    .borderless td, .borderless th {
        border: none;
    }
</style>