 <!-- MAIN CONTENT-->
 <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Data Peserta</h2>
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
                                    <i class="fa fa-upload"></i>Import Excel
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive table-responsive-data2">
                            <table id="table_participants" class="display text-center">
                                <thead>
                                    <tr>
                                        <th width="15px">No</th>
                                        <th width="2%"><button type="button" name="delete_all" id="delete_all" class="btn btn-sm btn-danger btn-xs"><i class="fa fa-trash"></i></button></th>
                                        <th>Aksi</th>
                                        <th>Nomor</th>
                                        <th>Nama</th>
                                        <th>Kelompok</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                    foreach($participants as $value){
                                ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><input type="checkbox" class="delete_checkbox" value="'.$value->peserta_id.'" /></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="<?=base_url()?>admin/edit-participants/<?=urlencode(base64_encode($value->peserta_id))?>/<?=urlencode(base64_encode($value->user_id))?>" class="btn btn-sm btn-primary mr-1"><i class="fa fa-pencil"></i></a>
                                                <a href="<?=base_url()?>admin/disable-participants/<?=urlencode(base64_encode($value->peserta_id))?>/<?=urlencode(base64_encode($value->user_id))?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin menghapus peserta ini?')"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                        <td><?=$value->no_peserta?></td>
                                        <td><?=$value->peserta_name?></td>
                                        <td><?=$value->group_peserta_name?></td>
                                        <td><?=$value->username?></td>
                                        <td><?=$this->encryption->decrypt($value->password)?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>