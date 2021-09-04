<link rel="stylesheet" href="<?php echo config_item('_assets_website'); ?>css/opsi.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="<?php echo config_item('_assets_general'); ?>summernote-0.8.18-dist/summernote-bs4.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.13.0/dist/katex.min.css" integrity="sha384-t5CR+zwDAROtph0PXGte6ia8heboACF9R5l/DiY+WZ3P2lxNgvJkQk5n7GPvLMYw" crossorigin="anonymous">

<style>
    .box-head {
        border-radius: 25px;
        background: #ffffff;
        padding: 0.5%;
        width: 100%;
        height: auto;
    }

    .box-search {
        border-radius: 25px;
        background: #ededed;
        opacity: 1;
        padding: 0.5%;
        width: 100%;
        height: auto;
    }
    .button-round {
        display: inline-block;
        position: relative;
        height: 50px;
        width: 50px;
        border-radius: 50%;
        margin: 2%;
        padding: 0;
        font-size: 100%;
        font-weight: bold;
    }
    .custom-file-input {
        cursor: pointer;
    }
    .custom-file-label {
        display: inline-block;
        z-index: 0;
        cursor: pointer;
    }
    .math{width:10%;}
    .button-config{text-align: right;}
    .label-text{text-align: right;}
    @media only screen and (max-width: 991px) {
        .button-config{text-align: center;}
        .label-text {
            text-align: center;
            margin: 2% 0 3% 0;
            font-size:100%;
        }
    }
</style>