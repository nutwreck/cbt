 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Report Tes Buku</h2>
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
                                        <th rowspan="2">Buku</th> 
                                        <th rowspan="2">Peserta Tes</th> 
                                        <th colspan="3">Nilai</th> 
                                        <th rowspan="2">Total Skor</th> 
                                    </tr> 
                                    <tr>
                                        <th>Tertinggi</th>
                                        <th>Rata-Rata</th>
                                        <th>Terendah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($list_buku as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td>
                                            <a href="<?=base_url()?>admin/detail-report-buku/<?=urlencode(base64_encode($value->paket_soal_id))?>/<?=urlencode(base64_encode($value->buku_id))?>" class="btn btn-sm btn-primary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                        <td><h6><?=$value->buku_name?><br /><small><?=$value->nama_paket_soal?> <?=$value->materi_name?></small></h6></td>
                                        <td><?=$value->total_user_ujian?></td>
                                        <td><?=$value->nilai_tertinggi?></td>
                                        <td><?=$value->nilai_rata?></td>
                                        <td><?=$value->nilai_terendah?></td>
                                        <td><?=$value->total_skor?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>