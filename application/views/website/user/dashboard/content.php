<!-- Page Content  -->
<div class="isi-content">
    <div class="row">
        <?php if ($this->session->flashdata('portal_error')) { ?>
            <div class="col-sm-12">
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <span class="glyphicon glyphicon-info-sign"></span><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Warning</strong>
                    <hr class="message-inner-separator">
                    <p><?= $this->session->flashdata('portal_error') ?></p>
                </div>
            </div>
            <?php $this->session->unset_userdata('portal_error'); ?>
        <?php } ?>
        <div class="col-sm-12">
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <span class="glyphicon glyphicon-info-sign"></span><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Informasi</strong>
                <hr class="message-inner-separator">
                <p>Dibawah ini ditampilkan daftar ujian anda, diurutkan berdasarkan waktu mulai paling awal. Untuk mengakses ujian anda sebelumnya <a href="<?= base_url() ?>history" class="btn btn-sm btn-success">Klik Disini</a></p>
            </div>
        </div>
    </div>
    <div class="row">
        <?php $now = date('Y-m-d H:i:s');
        foreach ($sesi_pelaksana as $val_sesi) { ?>
            <div class="col-sm-12 col-md-6 col-lg-4 mt-3 mb-3">
                <div class="card border-primary h-100">
                    <div class="card-header bg-transparent border-primary sesi-head"><?= $val_sesi->nama_paket_soal ?></div>
                    <div class="card-body">
                        <div class="m-0"><?php if (!empty($val_sesi->check_status_ujian) && !empty($val_sesi->tgl_selesai_user) && $val_sesi->tgl_selesai_user >= $now && $val_sesi->status_ujian == 0) { ?> <span class="badge badge-danger">Ujian sedang berlangsung harap kembali!</span> <?php } else {
                                                                                                                                                                                                                                                                                                echo '';
                                                                                                                                                                                                                                                                                            } ?></div>
                        <h5 class="card-title"><?= ucwords(strtolower($val_sesi->materi_name)) ?></h5>
                        <table class="table-responsive mb-0 sesi-detail">
                            <tr>
                                <td><i class="fa fa-hourglass-start" aria-hidden="true"></i> <b>Mulai</b></td>
                                <td>:</td>
                                <td><?= format_indo($val_sesi->waktu_mulai) ?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-hourglass-half" aria-hidden="true"></i> <b>Durasi</b></td>
                                <td>:</td>
                                <td><?= $val_sesi->lama_pengerjaan ?> Menit</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-hourglass-end" aria-hidden="true"></i> <b>Batas</b></td>
                                <td>:</td>
                                <td><?= format_indo($val_sesi->batas_pengerjaan) ?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-cogs" aria-hidden="true"></i> <b>Sifat</b></td>
                                <td>:</td>
                                <td><?= $val_sesi->fleksible_name ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer bg-transparent border-primary">
                        <div class="row">
                            <div class="col-sm-8 offset-sm-2">
                                <?php if ($val_sesi->waktu_mulai >= $now) { ?>
                                    <a href="#" class="btn btn-block btn-mulai isDisabled" onclick="return swal('Informasi', 'Waktu ujian belum dimulai!', 'info')">Mulai</a>
                                <?php } elseif ($val_sesi->status_ujian == 1 && $val_sesi->is_pembahasan == 1) { ?>
                                    <a href="<?php echo base_url(); ?>pembahasan/<?= urlencode(base64_encode($val_sesi->paket_soal_id)) ?>/<?= urlencode(base64_encode($val_sesi->check_status_ujian)) ?>/<?= urlencode(base64_encode($val_sesi->is_kunci_pembahasan)) ?>" class="btn btn-block btn-mulai">Pembahasan</a>
                                <?php } elseif (!empty($val_sesi->tgl_selesai_user) && $val_sesi->tgl_selesai_user <= $now && $val_sesi->is_pembahasan == 0) { ?>
                                    <a href="#" class="btn btn-block btn-mulai isDisabled">Selesai</a>
                                <?php } elseif (!empty($val_sesi->tgl_selesai_user) && $val_sesi->tgl_selesai_user <= $now && $val_sesi->is_pembahasan == 1) { ?>
                                    <a href="<?php echo base_url(); ?>pembahasan/<?= urlencode(base64_encode($val_sesi->paket_soal_id)) ?>/<?= urlencode(base64_encode($val_sesi->check_status_ujian)) ?>/<?= urlencode(base64_encode($val_sesi->is_kunci_pembahasan)) ?>" class="btn btn-block btn-mulai">Pembahasan</a>
                                <?php } elseif ($val_sesi->batas_pengerjaan <= $now) { ?>
                                    <a href="#" class="btn btn-block btn-mulai isDisabled">Selesai</a>
                                <?php } elseif (!empty($val_sesi->check_status_ujian) && !empty($val_sesi->tgl_selesai_user) && $val_sesi->tgl_selesai_user >= $now && $val_sesi->status_ujian == 0) { ?>
                                    <a href="<?php echo base_url(); ?>ujian/<?= urlencode(base64_encode($val_sesi->sesi_pelaksanaan_id)) ?>/<?= $encrypt ?>" class="btn btn-block btn-mulai">Lanjut</a>
                                <?php } elseif ($val_sesi->status_ujian == 1 && $val_sesi->is_pembahasan == 0) { ?>
                                    <a href="#" class="btn btn-block btn-mulai isDisabled">Selesai</a>
                                <?php } else { ?>
                                    <a href="<?php echo base_url(); ?>pre-ujian/<?= urlencode(base64_encode($val_sesi->sesi_pelaksanaan_id)) ?>" class="btn btn-block btn-mulai">Mulai</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>