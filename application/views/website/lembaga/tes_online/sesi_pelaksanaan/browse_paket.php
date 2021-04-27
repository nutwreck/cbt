 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Pilihan Paket Soal</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <div class="table-data__tool">
                            <div class="table-data__tool-right col text-right">
                                <a href="<?=base_url()?>admin/sesi-pelaksana" class="btn btn-sm btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-data2">
                            <table id="table_paket" class="display text-center">
                                <thead>
                                    <tr>
                                        <th width="15px">No</th>
                                        <th>Aksi</th>
                                        <th>Nama Paket Soal</th>
                                        <th>Jumlah Soal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($paket_soal as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><a href="<?=base_url()?>admin/add-sesi-pelaksana/<?=urlencode(base64_encode($value->paket_soal_id))?>" class="btn btn-sm btn-primary">Pilih</a></td>
                                        <td><h6><?=$value->nama_paket_soal?><br /><small><?=$value->materi_name?> <?=$value->kelas_name?></small></h6></td>
                                        <td><?=$value->total_soal?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>