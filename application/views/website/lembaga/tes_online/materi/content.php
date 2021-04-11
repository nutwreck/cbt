 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Materi</h2>
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
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-data2">
                            <table id="table_materi" class="display text-center">
                                <thead>
                                    <tr>
                                        <th width="15px">No</th>
                                        <th>Materi</th>
                                        <th>Dibuat Oleh</th>
                                        <th>Perubahan Oleh</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($materi_data as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$value->name?></td>
                                        <td><h6><?=$value->user_created_name?><br /><small><?=$value->created_datetime?></small></h6></td>
                                        <td><h6 class="text-danger"><?=$value->user_edited_name?><br /><small><?=$value->updated_datetime?></small></h6></td>
                                        <td><?php if($value->is_enable == 1){ echo 'Aktif'; } else { echo 'Tidak Aktif'; }; ?></td>
                                        <td>
                                            <?php if($value->is_enable == 1) { ?>
                                            <div class="table-data-feature">
                                                <a href="<?php echo base_url(); ?>admin/edit-materi/<?php echo $value->id; ?>" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </a>
                                                <a href="<?php echo base_url(); ?>admin/delete-materi/<?php echo $value->id; ?>" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </a>
                                            </div>
                                            <?php } else { ?>
                                                <div class="table-data-feature">
                                                    <a href="<?php echo base_url(); ?>admin/active-materi/<?php echo $value->id; ?>" class="item" data-toggle="tooltip" data-placement="top" title="Active">
                                                        <i class="zmdi zmdi-check"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>