<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div id="content_add" class="col-sm-8 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col">Tambah Group Modul Buku</div>
                                <div class="col text-right">
                                    <a href="<?=base_url()?>admin/group-buku/<?=$id_buku?>" class="btn btn-sm btn-outline-secondary">Kembali</a>
                                </div>
                            </div>
                        </div>
                        <form id="formadd" name="formadd" action="<?php echo base_url(); ?>website/lembaga/Management/submit_add_group_modul" method="post">
                        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                        <input type="hidden" id="id_config_buku" name="id_config_buku" value="<?=$id_config_buku?>">
                        <input type="hidden" id="id_buku" name="id_buku" value="<?=$id_buku?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="materi" class="control-label mb-1">Nama Group Modul</label>
                                <small for="name" id="name" class="bg-danger text-white"></small>
                                <input id="name" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Group Modul" required>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-lg btn-info btn-block">
                                    <i class="fa fa-check fa-md"></i>&nbsp;
                                    <span>Submit</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>