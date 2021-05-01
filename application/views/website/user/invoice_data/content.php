 <!-- MAIN CONTENT-->
 <div class="isi-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="overview-wrap">
                    <h2 class="title-1">Status Pembelian</h2>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="row mt-1 ml-0 mr-0 mb-0">
                    <div class="col-sm-12">
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <span class="glyphicon glyphicon-info-sign"></span><i class="fa fa-info-circle" aria-hidden="true"></i> <strong>Informasi</strong>
                            <hr class="message-inner-separator">
                            <ol>
                                <li>Jika pembayaran anda menggunakan Qris klik tombol centang untuk konfirmasi manual.</li>
                                <li>Jika pembayaran anda transfer bank dan dalam 2 Jam setelah transfer belum mendapat email konfirmasi silahkan upload bukti pembayaran anda manual.</li>
                                <li>Jika status upload bukti anda direject admin, klik tombol centang dan perbaiki upload bukti anda sesuai pesan dari admin.</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="table-responsive table-responsive-data2">
                    <table id="table_invoice" class="display text-center">
                        <thead>
                            <tr>
                                <th width="10px" rowspan="2">No</th>
                                <th rowspan="2">Aksi</th>
                                <th colspan="3">Invoice</th>
                                <th rowspan="2">Pembelian</th>
                                <th rowspan="2">Pembayaran</th>
                            </tr>
                            <tr>
                                <th>No</th>
                                <th>Status</th>
                                <th>Kadaluarsa</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $no = 1;
                            foreach($invoice as $value){
                        ?>
                            <tr>
                                <td><?=$no++?></td>
                                <td>
                                    <?php if($value->status == 0 || $value->status == 4) { ?>
                                    <a href="<?php echo base_url(); ?>manual-confirm/<?php echo urlencode(base64_encode($value->id_invoice)); ?>/<?=$value->status?>" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Konfirmasi Manual">
                                        <i class="fa fa-check"></i>
                                    </a>
                                    <?php } else { ?>
                                    <a href="#" class="btn btn-sm btn-primary isDisabled" data-toggle="tooltip" data-placement="top" title="Konfirmasi Manual">
                                        <i class="fa fa-check"></i>
                                    </a>
                                    <?php } ?>
                                </td>
                                <td><?=$value->invoice_number?></td>
                                <td><?=$value->status_invoice?></td>
                                <td><?=format_indo($value->invoice_date_expirate)?></td>
                                <td><?=$value->buku_name?> <?=!empty($value->detail_buku_name) ? '('.$value->detail_buku_name.')' : ''?></td>
                                <td><h6><?=$value->payment_method_detail_name?><br /><span class="text-danger"><?=rupiah($value->invoice_total_cost)?></span></h6></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
</div>