<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>

<script type="text/javascript">
    var table;
    $(document).ready(function(){
        //datatables
        table = $('#table').DataTable({ 
            "oLanguage": {
              "sProcessing": "Mohon Tunggu..."
            },
            "processing": true, 
            "serverSide": true, 
            "order": [], 
            
            "ajax": {
                "url": "<?php echo site_url('admin/invoice-all')?>",
                "type": "POST"
            },

            "columnDefs": [
            { 
                "targets": [ 0 ], 
                "orderable": false, 
            },
            ],

        });
 
    });

    function export_data() {
        window.location.href = "<?php echo base_url(); ?>admin/export-all-invoice";
    }
</script>