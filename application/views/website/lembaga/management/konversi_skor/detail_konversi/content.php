 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Detail Konversi Skor</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <div class="table-data__tool">
                            <div class="table-data__tool-right">
                                <button class="au-btn au-btn-icon au-btn--blue au-btn--small" onclick="add_data()">
                                    <i class="zmdi zmdi-plus"></i>Tambah
                                </button>
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="import_excel()">
                                    <i class="zmdi zmdi-import"></i>Import Excel
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-data2">
                            <table id="table_detail_konversi" class="display text-center">
                                <thead>
                                    <tr>
                                        <th width="15px">No</th>
                                        <th>Skor Asal</th>
                                        <th>Skor Konversi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($detail_konversi as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$value->skor_asal?></td>
                                        <td><?=$value->skor_konversi?></td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="<?php echo base_url(); ?>admin/edit-detail-konversi-skor/<?php echo urlencode(base64_encode($value->id)); ?>/<?php echo urlencode(base64_encode($value->konversi_skor_id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </a>
                                                <a href="<?php echo base_url(); ?>admin/delete-detail-konversi-skor/<?php echo urlencode(base64_encode($value->id)); ?>/<?php echo urlencode(base64_encode($value->konversi_skor_id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>