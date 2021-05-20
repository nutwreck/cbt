 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Detail Report Ujian</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12 mb-3">
                        <table class="table table-striped text-center">
                            <tr>
                                <td>Deskripsi Sesi</td><td>:</td><td><?=$list_ujian->sesi_pelaksanaan_name?> (<?=$list_ujian->paket_soal_name?> <?=$list_ujian->materi_name?>)</td>
                            </tr>
                            <tr>
                                <td>Waktu Pelaksanaan</td><td>:</td><td><?=format_indo($list_ujian->tgl_mulai_sesi)?> - <?=format_indo($list_ujian->tgl_selesai_sesi)?> (<?=$list_ujian->fleksible_name?> - <?=$list_ujian->lama_pengerjaan?> Menit)</td>
                            </tr>
                            <tr>
                                <td>Kelompok</td><td>:</td><td><?=empty($list_ujian->group_peserta_name) ? 'Manual Input '.$list_ujian->total_user_sesi.' Peserta' : $list_ujian->group_peserta_name?></td>
                            </tr>
                            <tr>
                                <td>Peserta Mengerjakan</td><td>:</td><td><?=$list_ujian->total_user_ujian?> dari total <?=$list_ujian->total_user_sesi?> peserta</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <div class="table-data__tool">
                            <div class="table-data__tool-right">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="export_excel()">
                                    <i class="fa fa-file-excel-o"></i>Export Excel Nilai
                                </button>
                                <button class="au-btn au-btn-icon au-btn--blue au-btn--small" onclick="export_excel_statistik()">
                                    <i class="fa fa-area-chart"></i>Export Excel Statistik
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
                                            <a href="<?=base_url()?>admin/detail-ujian-peserta/<?=urlencode(base64_encode($value->ujian_id))?>/<?=urlencode(base64_encode($value->sesi_pelaksanaan_id))?>/<?=urlencode(base64_encode($value->paket_soal_id))?>" class="btn btn-sm btn-primary" title="soal & jawaban peserta">
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