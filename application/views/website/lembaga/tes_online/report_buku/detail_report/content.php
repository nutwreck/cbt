 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Detail Report Tes Buku</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 mb-3">
                        <table class="table table-striped text-center">
                            <tr>
                                <td>Deskripsi Buku</td><td>:</td><td><?=$list_ujian->buku_name?> (<?=$list_ujian->nama_paket_soal?> <?=$list_ujian->materi_name?>)</td>
                            </tr>
                            <tr>
                                <td>Peserta Mengerjakan</td><td>:</td><td><?=$list_ujian->total_user_ujian?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <div class="table-data__tool">
                            <div class="table-data__tool-right">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="export_excel()">
                                    <i class="fa fa-file-excel-o"></i>Export Excel
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-data2">
                            <table id="table_detail_report" class="display text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Aksi</th>
                                        <th>Nomor Peserta</th>
                                        <th>Nama Peserta</th>
                                        <th>Waktu Mulai</th>
                                        <th>Waktu Selesai</th>
                                        <th>Total Skor</th>
                                        <th>Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($list_ujian_detail as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td>
                                            <a href="<?=base_url()?>admin/detail-buku-peserta/<?=urlencode(base64_encode($value->id_ujian))?>/<?=urlencode(base64_encode($value->paket_soal_id))?>/<?=urlencode(base64_encode($value->buku_id))?>" class="btn btn-sm btn-primary" title="soal & jawaban peserta">
                                                <i class="fa fa-book"></i>
                                            </a>
                                        </td>
                                        <td><?=$value->user_no?></td>
                                        <td><?=$value->user_name?></td>
                                        <td><?=$value->tgl_mulai_peserta?></td>
                                        <td><?=$value->tgl_selesai_peserta?></td>
                                        <td><?=$value->total_skor?></td>
                                        <td><?=$value->nilai?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>