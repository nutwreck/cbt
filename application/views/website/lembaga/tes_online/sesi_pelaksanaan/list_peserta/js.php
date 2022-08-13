<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<!-- Moment JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.min.js" integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ==" crossorigin="anonymous"></script>
<!-- DateTimePicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#table_list').DataTable({

        });

        $('.delete_checkbox').click(function() {
            if ($(this).is(':checked')) {
                $(this).closest('tr').addClass('removeRow');
            } else {
                $(this).closest('tr').removeClass('removeRow');
            }
        });

        $('#delete_all').click(function() {
            var checkbox = $('.delete_checkbox:checked');
            if (checkbox.length > 0) {
                var checkbox_value = [];
                $(checkbox).each(function() {
                    checkbox_value.push($(this).val());
                });
                $.ajax({
                    url: "<?php echo base_url(); ?>website/lembaga/Tes_online/sesi_peserta_multiple_delete",
                    method: "POST",
                    data: {
                        checkbox_value: checkbox_value
                    },
                    success: function() {
                        $('.removeRow').fadeOut(1500);
                        alert('Hapus peserta sesi sukses!');
                    }
                })
            } else {
                alert('Pilih minimal 1 data');
            }
        });
    });

    function export_excel() {
        window.location.href = "<?php echo base_url(); ?>admin/export-peserta-sesi-pelaksana/<?= $id_sesi_pelaksana ?>";
    }
</script>

<script type="text/javascript">
    $(function() {
        let date = moment();

        date.set({
            hour: 1,
            minute: 0,
        });

        $('#datetimepicker10').datetimepicker({
            locale: 'id',
            format: 'HH:mm',
            autoclose: true,
            defaultDate: date
        });
    });
</script>

<script type="text/javascript">
    //Modal tambah waktu peserta
    $('#tambah_waktu_modal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var user_id = button.data('userid') // Extract info from data-* attributes
        var modal_sesi = $(this)
        modal_sesi.find('#user_id').val(user_id)
    })

    function proses_waktu_tambahan_peserta() {
        var sesiids = document.getElementById("sesi_id").value;
        var paketsoalids = document.getElementById("paket_soal_id").value;
        var userids = document.getElementById("user_id").value;
        var tambahanwaktu = document.getElementById("datetimepicker10").value;

        $.ajax({
            url: "<?php echo base_url(); ?>website/lembaga/Tes_online/tambahan_waktu_peserta_ujian",
            method: "POST",
            data: {
                sesi_id: sesiids,
                paket_soal_id: paketsoalids,
                user_id: userids,
                tambahan_waktu: tambahanwaktu
            },
            success: function(response) {
                if (response.status = "berhasil") {
                    alert(response.text);
                    $('#tambah_waktu_modal').modal('hide');
                } else {
                    alert(response.text);
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        })
    }

    function hitung_ulang_ujian(ujian_id) {
        $.ajax({
            url: "<?php echo base_url(); ?>website/user/Ujian/simpan_akhir",
            method: "POST",
            data: {
                id: ujian_id
            },
            beforeSend: function() {
                return confirm("Apakah anda yakin menghitung ulang hasil ujian peserta ini?");
            },
            success: function(response) {
                if (response.status) {
                    alert("Hitung ulang ujian peserta berhasil");
                } else {
                    alert("Hitung ulang ujian peserta gagal. Silahkan ulangi kembali!");
                }
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        })
    }
</script>