<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div id="content_add" class="col-sm-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">Edit Setting Buku</div>
                        <div class="card-body">
                            <form id="form-edit-buku" name="form-edit-buku" action="<?php echo base_url(); ?>website/lembaga/Management/submit_edit_setting_buku" method="post">
                            <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                            <input type="hidden" id="id_config_buku" name="id_config_buku" value="<?=$id_config_buku?>" style="display: none">
                                <div class="form-group">
                                    <label for="nama" class="control-label mb-1">Total Free Paket</label>
                                    <input id="free_paket" name="free_paket" type="number" class="form-control" aria-required="true" aria-invalid="false" value="<?=$config_buku->free_paket?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama" class="control-label mb-1">Harga Buku</label>
                                    <input id="price" name="price" type="number" class="form-control" aria-required="true" aria-invalid="false" value="<?=$config_buku->price?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama" class="control-label mb-1">Deskripsi Buku</label>
                                    <textarea class="summernote-buku" id="summernote-buku" name="desc" rows='10'><?=$config_buku->desc?></textarea>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-lg btn-info btn-block">
                                        <i class="fa fa-check fa-md"></i>&nbsp;
                                        <span>Submit</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>