<!-- MAIN CONTENT-->
<?php
    foreach($konversi_data as $value){
        $id = $value->id;
        $name = $value->name;
    }
?>
<div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div id="info_user" class="col-sm-12 col-lg-6">
                                <div class="row mt-3 ml-0 mr-0 mb-0">
                                    <div class="col-sm-12">
                                       
                                    </div>
                                </div>
                            </div>
                            <div id="content_add" class="col-sm-12 col-lg-6">
                                <div class="card">
                                    <div class="card-header">Edit Konversi</div>
                                    <div class="card-body">
                                        <form id="formedit" name="formedit" action="<?php echo base_url(); ?>website/lembaga/Konversi_skor/submit_edit_konversi" method="post" onsubmit = "return(validate_editform());">
                                        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                         <input type="hidden" id="id" name="id" value="<?=$id?>" style="display: none" required>-
                                            <div class="form-group">
                                                <label for="nama" class="control-label mb-1">Nama Materi</label>
                                                <small for="nama" id="materi_er" class="bg-danger text-white"></small>
                                                <input id="konversi" name="konversi" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan nama konversi" value="<?=$name?>">
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-lg btn-info btn-block">
                                                    <i class="fa fa-check fa-md"></i>&nbsp;
                                                    <span>Update</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>