<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_user').DataTable( {
            
        } );
    } );

    function add_data() {
        window.location.href = "<?php echo base_url(); ?>admin/add-user-lembaga";
    }
</script>

<!-- Validasi Form add -->
<script>
    function validate_addform(){
        var emailID = document.formadd.email.value;
        atpos = emailID.indexOf("@");
        dotpos = emailID.lastIndexOf(".");
        
        if (atpos < 1 || ( dotpos - atpos < 2 )) {
            document.getElementById('email_er').innerHTML = 'Input Email dengan benar!';
            document.formadd.email.focus() ;
            return false;
        }
    }
</script>