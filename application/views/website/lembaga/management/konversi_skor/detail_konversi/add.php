<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div id="content_add" class="col-sm-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">Tambah Detail Konversi Skor</div>
                        <div class="card-body">
                            <form id="formadd" name="formadd" action="<?php echo base_url(); ?>website/lembaga/Management/submit_add_detail_konversi" method="post">
                            <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                            <input type="hidden" id="id_konversi" name="id_konversi" value="<?=$id_konversi?>" style="display: none">
                                <div class="form-group">
                                    <label for="nama" class="control-label mb-1">Skor Asal</label>
                                    <input id="skor_asal" name="skor_asal" type="number" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Skor Asal" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama" class="control-label mb-1">Skor Konversi</label>
                                    <input id="skor_konversi" name="skor_konversi" type="number" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Skor Konversi" required>
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