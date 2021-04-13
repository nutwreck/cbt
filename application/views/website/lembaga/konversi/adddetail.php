<!-- MAIN CONTENT-->

<div class="main-content">

                            <div id="content_add" class="col-sm-12 col-lg-4">
                                <div class="card">
                                    <div class="card-header">Skor Asal</div>
                                    <div class="card-body">
                                        <form id="formadd" name="formadd" action="<?php echo base_url(); ?>website/lembaga/Konversi_skor/submit_add_detail_konversi" method="post" onsubmit = "return(validate_addform());">
                                        <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                                            <div class="form-group">
                                                <label for="nama" class="control-label mb-1">Skor Asal</label>
                                                <small for="nama" id="materi_er" class="bg-danger text-white"></small>
                                                <input id="materi" name="materi" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Skor Asal Konversi">
                                            </div>
                                            <div class="form-group">
                                                <label for="nama" class="control-label mb-1">Hasil skor Konversi</label>
                                                <small for="nama" id="materi_er" class="bg-danger text-white"></small>
                                                <input id="materi" name="materi" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Skor Konversi">
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