 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Report Ujian</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <div class="table-responsive table-responsive-data2">
                            <table id="table_report" class="display text-center">
                                <thead>
                                    <tr> 
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Aksi</th>
                                        <th rowspan="2">Sesi</th> 
                                        <th rowspan="2">Kelompok</th> 
                                        <th colspan="2">Nilai</th> 
                                        <th colspan="2">Peserta</th> 
                                    </tr> 
                                    <tr>
                                        <th>Tertinggi</th>
                                        <th>Terendah</th>
                                        <th>Terdaftar</th>
                                        <th>Mengerjakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($list_ujian as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td>
                                            <a href="<?=base_url()?>admin/detail-report-ujian/<?=urlencode(base64_encode($value->sesi_pelaksanaan_id))?>/<?=urlencode(base64_encode($value->paket_soal_id))?>" class="btn btn-sm btn-primary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                        <td><h6><?=$value->sesi_pelaksanaan_name?><br /><small><?=$value->paket_soal_name?> <?=$value->materi_name?></small></h6></td>
                                        <td><?=empty($value->group_peserta_name) ? 'Manual Input '.$value->total_user_sesi.' Peserta' : $value->group_peserta_name?></td>
                                        <td><?=$value->nilai_tertinggi?></td>
                                        <td><?=$value->nilai_tertinggi?></td>
                                        <td><?=$value->total_user_sesi?></td>
                                        <td><?=$value->total_user_ujian?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>