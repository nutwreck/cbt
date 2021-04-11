 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Group Peserta</h2>
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
                            <table id="table_group" class="display text-center">
                                <thead>
                                    <tr>
                                        <th width="15px">No</th>
                                        <th>Aksi</th>
                                        <th>Nama Kelompok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($group_peserta as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?=base_url()?>admin/edit-group-participants/<?=urlencode(base64_encode($value->id))?>" class="btn btn-sm btn-primary mr-1"><i class="fa fa-pencil"></i></a>
                                                <a href="<?=base_url()?>admin/disable-group-participants/<?=urlencode(base64_encode($value->id))?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin menghapus group ini?')"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                        <td><?=$value->name?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>