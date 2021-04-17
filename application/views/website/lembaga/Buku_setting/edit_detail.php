<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div id="content_add" class="col-sm-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">Edit Buku Setting</div>
                        <div class="card-body">
                            <form id="formadd" name="formadd" action="<?php echo base_url(); ?>website/lembaga/Buku_setting/submit_edit_buku" method="post">
                            <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                            <input type="hidden" id="id_buku" name="id_buku" value="<?=$id_buku?>" style="display: none">
                                <div class="form-group">
                                    <label for="nama" class="control-label mb-1">Nama Buku Setting</label>
                                    <input id="name" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan judul konversi" value="<?=$buku_data->name?>" required>
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