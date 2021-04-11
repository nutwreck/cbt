<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_group').DataTable( {
            
        } );
    } );

    function add_data() {
        window.location.href = "<?php echo base_url(); ?>admin/add-group-participants";
    }
</script>