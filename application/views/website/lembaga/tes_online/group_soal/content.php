 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Group Soal</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <!-- DATA TABLE -->
                        <div class="table-data__tool">
                            <div class="table-data__tool-right">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small" onclick="add_data()">
                                    <i class="zmdi zmdi-plus"></i>Tambah
                                </button>
                                <button class="au-btn au-btn-icon au-btn--blue au-btn--small" onclick="paket_soal_page()">
                                    Kembali
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-data2">
                            <table id="table_group" class="display text-center">
                                <thead>
                                    <tr>
                                        <th width="15px">No</th>
                                        <th>Aksi</th>
                                        <th>Nama Group</th>
                                        <th>Parent Group</th>
                                        <th>Konversi Skor</th>
                                        <th>Kode Group Soal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($group_soal as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="<?php echo base_url(); ?>admin/detail-group-soal/<?php echo urlencode(base64_encode($value->id_group_soal)); ?>/<?php echo urlencode(base64_encode($value->paket_soal_id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Detail">
                                                    <i class="zmdi zmdi-eye"></i>
                                                </a>
                                                <a href="<?php echo base_url(); ?>admin/edit-group-soal/<?php echo urlencode(base64_encode($value->id_group_soal)); ?>/<?php echo urlencode(base64_encode($value->paket_soal_id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </a>
                                                <a href="<?php echo base_url(); ?>admin/disable-group-soal/<?php echo urlencode(base64_encode($value->id_group_soal)); ?>/<?php echo urlencode(base64_encode($value->paket_soal_id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td><?=$value->name_group_soal?></td>
                                        <td><?=$value->name_parent?></td>
                                        <td><?=$value->name_konversi_skor?></td>
                                        <td><?=$value->kode_group?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>