<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">Reject Bukti Pembayaran INV #<?=$invoice->invoice_number?> A/N <?=$invoice->user_name?></div>
                        </div>
                    </div>
                    <form id="formdata" name="formdata" action="<?php echo base_url(); ?>website/lembaga/Management/submit_reject_invoice" class="form-data-lembaga" method="POST" enctype="multipart/form-data" onsubmit="return(validate_form());">
                    <input type="hidden" id="csrf-hash-form" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <input type="hidden" id="id_invoice" name="id_invoice" value="<?=$id_invoice?>" style="display: none" required>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-3" style="margin-top:1%">
                                    <h5 class="label-text">Alasan Reject</h5>
                                </div>
                                <div class="col-sm-12 col-lg-9">
                                    <div class="form-group">
                                        <textarea class="form-control" id="reject_desc" name="reject_desc" rows="3" required><?=!empty($invoice->reject_desc) ? $invoice->reject_desc : ''?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 offset-sm-3">
                                    <button type="submit" class="btn btn-md btn-info btn-block">
                                        <i class="fa fa-check fa-md"></i>&nbsp;
                                        <span>Submit</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>