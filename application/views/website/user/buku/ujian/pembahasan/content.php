<div class="container-fluid mt-100-st">
    <div class="row lembar_pembahasan">
        <div id="lembar_soal" class="col-sm-12 col-md-8 mb-3">
            <?=form_open('', array('id'=>'ujian'), array('id'=> $ujian_id));?>
                <h3 class="box-title" style="display:none;"><span class="badge bg-blue">Soal #<span id="soalke"></span> </span></h3>
                <?=$lembar_jawaban?>
                <input type="hidden" name="jml_soal" id="jml_soal" value="<?=$jumlah_soal; ?>">
            <?=form_close();?>
        </div>
        <div id="panel-toogle-soal" class="col-sm-12 col-md-4 mb-3" style="display:block;">
            <div class="card text-center font-poppins">
                <h5 class="m-3">Navigasi Soal</h5>
                <div class="m-0 row">
                    <div class="col-sm-6 text-right">
                        <h5><span class="badge badge-success"><i class="fas fa-check"></i> <?=$ujian->jml_benar?> Benar</span></h5>
                    </div>
                    <div class="col-sm-6 text-left">
                        <h5><span class="badge badge-danger"><i class="fas fa-times"></i> <?=$ujian->jml_salah+$ujian->jml_kosong?> Salah</span></h5>
                    </div>
                </div>
                <div id="tampil_jawaban" class="card-body text-white btn-navigasi">
                
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal" id="petunjukModal" data-backdrop="false">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 id="title-group" class="modal-title"></h4>
        </div>
        <div id="body-group" class="modal-body">

        </div>
        <div id="footer-group" class="modal-footer">
            
        </div>
    </div>
</div>