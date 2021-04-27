<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Tambah Group Peserta</div>
                            <div class="col text-right">
                                <a href="<?=base_url()?>admin/group-participants" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                    <form action="<?php echo base_url(); ?>website/lembaga/User/submit_add_group_peserta" class="form-group-peserta" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <input type="hidden" id="lembaga_id" name="lembaga_id" value="<?=$lembaga_id?>" style="display: none" required>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Nama Group Peserta</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <input id="name" name="name" type="text" class="form-control" aria-required="true" aria-invalid="false" placeholder="Masukkan Nama Group Peserta" required>
                                    </div>
                                    <div class="alert alert-info">
                                        <p>
                                            Nama group peserta digunakan untuk membuat group pada peserta sehingga memudahkan management peserta saat pembuatan sesi pelaksanaan ujian online
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 offset-sm-3">
                                    <button type="submit" class="btn btn-md btn-info btn-block">
                                        <i class="fa fa-check fa-md"></i>&nbsp;
                                        <span>Submit</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>