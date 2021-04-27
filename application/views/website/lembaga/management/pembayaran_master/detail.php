 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Detail Master Pembayaran</h2>
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
                                <a href="<?=base_url()?>admin/pembayaran-master" class="btn btn-md btn-outline-secondary">Kembali</a>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-data2">
                            <table id="table_detail_pembayaran" class="display text-center">
                                <thead>
                                    <tr>
                                        <th width="15px">No</th>
                                        <?php if($pembayaran_master_id == 1) { ?>
                                            <th>Logo Pembayaran</th>
                                            <th>Nama Bank</th>
                                            <th>Nama Akun Bank</th>
                                            <th>No Rekening Bank</th>
                                        <?php } else { ?>
                                            <th>Qris Scan Pembayaran</th>
                                        <?php } ?>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($detail_pembayaran_master as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <?php if($pembayaran_master_id == 1) { ?>
                                            <td><img src="<?=config_item('_dir_website')?>lembaga/grandsbmptn/master_pembayaran/<?=$value->logo_payment?>" alt="<?=$value->bank_number?>" class="img-thumbnail"></td>
                                            <td><?=$value->bank_name?></td>
                                            <td><?=$value->bank_account?></td>
                                            <td><?=$value->bank_number?></td>
                                        <?php } else { ?>
                                            <td><img src="<?=config_item('_dir_website')?>lembaga/grandsbmptn/master_pembayaran/<?=$value->image_payment?>" style="width:30%;" alt="qris-<?=$value->id?>" class="img-thumbnail"></td>
                                        <?php } ?>
                                        <td><?=$value->is_enable == 1 ? 'Aktif' : 'Tidak Aktif'?></td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="<?php echo base_url(); ?>admin/edit-detail-pembayaran-master/<?php echo urlencode(base64_encode($value->id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </a>
                                                <a href="<?php echo base_url(); ?>admin/delete-detail-pembayaran-master/<?php echo urlencode(base64_encode($value->id)); ?>/<?php echo urlencode(base64_encode($value->payment_method_id)); ?>" class="item" data-toggle="tooltip" data-placement="top" title="Delete">
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