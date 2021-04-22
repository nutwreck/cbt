<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
    $(document).ready(function() {
        $('#table_participants').DataTable( {
            "columnDefs": [
                { "orderable": false, "targets": 1 },
                { "orderable": false, "targets": 2 }
            ]
        } );

        $('.delete_checkbox').click(function(){
            if($(this).is(':checked')) {
                $(this).closest('tr').addClass('removeRow');
            } else {
                $(this).closest('tr').removeClass('removeRow');
            }
        });

        $('#delete_all').click(function(){
            var checkbox = $('.delete_checkbox:checked');
            if(checkbox.length > 0) {
                var checkbox_value = [];
                $(checkbox).each(function(){
                    checkbox_value.push($(this).val());
                });
                $.ajax({
                    url:"<?php echo base_url(); ?>website/lembaga/User/user_multiple_delete_all",
                    method:"POST",
                    data:{checkbox_value:checkbox_value},
                    success:function()
                    {
                        $('.removeRow').fadeOut(1500);
                        alert('Hapus peserta sukses!');
                    }
                })
            } else {
                alert('Pilih minimal 1 data');
            }
        });
    } );

    function add_data() {
        window.location.href = "<?php echo base_url(); ?>admin/add-participants";
    }

    function import_excel() {
        window.location.href = "<?php echo base_url(); ?>admin/add-import-participants";
    }

    function export_excel() {
        window.location.href = "<?php echo base_url(); ?>admin/export-participants";
    }
</script>

<!-- Nama file muncul saat upload -->
<script>
    if (document.getElementById('data_peserta') != null) {
        document.querySelector("#data_peserta").onchange = function(){
            document.querySelector("#file-name").textContent = this.files[0].name;
        }
    }
</script>