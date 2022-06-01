<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<!-- Moment JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.min.js" integrity="sha512-he8U4ic6kf3kustvJfiERUpojM8barHoz0WYpAUDWQVn61efpm3aVAD8RWL8OloaDDzMZ1gZiubF9OSdYBqHfQ==" crossorigin="anonymous"></script>
<!-- DateTimePicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous"></script>

<script>
	$(document).ready(function() {
		$('#table_event').DataTable({

		});

		try {
			var kuota_sisa = parseInt(document.getElementById('kuota_sisa').value);
		} catch (err) {
			var kuota_sisa = "err";
		}

		if (kuota_sisa != "err") {
			document.getElementById('sisa-kuota-kelompok').innerHTML = kuota_sisa;
		}

		//Mode Kuota Peserta
		var radio_kuota = document.querySelector('input[name="mode_kuota"]:checked').value;
		if (radio_kuota == 1) { //Tak Terbatas
			unlimited_function();
		} else { //Terbatas
			limited_function();
		}

		//Mode Kelompok Peserta
		try {
			var radio_kelompok = document.querySelector('input[name="mode_kelompok"]:checked').value;
		} catch (err) {
			var radio_kelompok = 1;
		}
		if (radio_kelompok == 1) { //Otomatis
			otomatis_function();
		} else { //Manual
			manual_function();
		}
	});

	function add_data() {
		window.location.href = "<?php echo base_url(); ?>admin/event-add";
	}

	function unlimited_function() {
		var kuota_peserta = document.getElementById('kuota_peserta');
		var kelompok_peserta = document.getElementById('kelompok_peserta');
		kuota_peserta.style.display = 'none';
		kelompok_peserta.style.display = 'none';
	}

	function limited_function() {
		var kuota_peserta = document.getElementById('kuota_peserta');
		var kelompok_peserta = document.getElementById('kelompok_peserta');
		kuota_peserta.style.display = 'block';
		kelompok_peserta.style.display = 'block';
	}

	function otomatis_function() {
		var tbl_group_peserta_manual = document.getElementById('tbl_group_peserta_manual');
		tbl_group_peserta_manual.style.display = 'none';
	}

	function manual_function() {
		var tbl_group_peserta_manual = document.getElementById('tbl_group_peserta_manual');
		tbl_group_peserta_manual.style.display = 'block';
	}

	function add_form_kelompok() {
		var jumlah = parseInt($("#jumlah-form-kelompok").val());
		var nextform = jumlah + 1;

		$("#tbody-form-kelompok").append("<div id='clm-" + nextform + "'>" +
			"<table class='table text-center'>" +
			"<tr>" +
			"<td>" +
			"<input id='multi_kelompok_peserta' name='multi_kelompok_peserta[]' type='text' class='form-control text-center' aria-required='true' aria-invalid='false' required>" +
			"</td>" +
			"<td>" +
			"<input id='multi_kuota_kelompok' name='multi_kuota_kelompok[]' type='number' class='form-control text-center' aria-required='true' aria-invalid='false' onChange='refresh_sisa_kuota()' required>" +
			"</td>" +
			"<td>" +
			"<button type='button' class='btn btn-sm btn-danger' onclick='delete_form_kelompok(" + nextform + ")'>" +
			"<i class='zmdi zmdi-minus'></i>" +
			"</button>" +
			"</td>" +
			"</tr>" +
			"</table>" +
			"</div"
		);

		$("#jumlah-form-kelompok").val(nextform);
	}

	function delete_form_kelompok(tableId) {
		const element = document.getElementById('clm-' + tableId);
		element.remove();

		refresh_sisa_kuota();
	}

	function sisa_kuota_kelompok() {
		var val_kuota = document.getElementById('kuota').value;
		document.getElementById('sisa-kuota-kelompok').innerHTML = val_kuota;
	}

	function refresh_sisa_kuota() {
		var val_kuota_max = parseInt(document.getElementById('kuota').value);

		//DISABLE
		var disableExists = $('input[name^=skip_kuota_kelompok]');
		var count_quota_disable = 0;
		if (typeof(disableExists) != 'undefined' && disableExists != null) {
			var numbers_quota_disable = $('input[name^=skip_kuota_kelompok]').map(function(idx, elem) {
				return parseInt($(elem).val());
			}).get();

			for (var i = numbers_quota_disable.length; i--;) {
				count_quota_disable += numbers_quota_disable[i];
			}
		}

		//EDIT
		var editExists = $('input[name^=old_multi_kuota_kelompok]');
		var count_quota_old = 0;
		if (typeof(editExists) != 'undefined' && editExists != null) {
			var numbers_quota_old = $('input[name^=old_multi_kuota_kelompok]').map(function(idx, elem) {
				return parseInt($(elem).val());
			}).get();

			for (var i = numbers_quota_old.length; i--;) {
				count_quota_old += numbers_quota_old[i];
			}
		}

		//NEW
		var numbers_quota = $('input[name^=multi_kuota_kelompok]').map(function(idx, elem) {
			return parseInt($(elem).val());
		}).get();
		var count_quota = 0;
		if (typeof(numbers_quota) != 'undefined' && numbers_quota != null) {
			for (var i = numbers_quota.length; i--;) {
				count_quota += numbers_quota[i];
			}
		}

		var result_quota = val_kuota_max - (count_quota + count_quota_old + count_quota_disable);

		if (isNaN(result_quota)) {
			result_quota = val_kuota_max;
		}

		document.getElementById('sisa-kuota-kelompok').innerHTML = result_quota;
	}

	function check_validasi_prefix() {
		var value_prefix_url = document.getElementById('prefix_url').value;

		$.ajax({
			type: "POST",
			url: base_url + "website/lembaga/Management/event_check_prefix",
			data: 'value=' + value_prefix_url,
			dataType: 'json',
			success: function(data) {
				document.getElementById('prefix_url_scs').innerHTML = "";
				document.getElementById('prefix_url_er').innerHTML = "";
				if (data.status == 1) { //belum digunakan
					document.getElementById('prefix_url_scs').innerHTML = data.message;
				} else { //sudah digunakan
					document.getElementById('prefix_url_er').innerHTML = data.message;
				}
			}
		});
	}

	function delete_banner_edit(id_banner) {
		if (confirm('Apakah anda yakin menghapus banner ini?')) {
			//delete banner
			const element = document.getElementById('banner-head-' + id_banner);
			element.remove();

			//set banner is 1
			const delete_banner = document.getElementById('event-banner-image-' + id_banner).value;
			const delete_banner_split = delete_banner.split("-");
			document.getElementById('event-banner-image-' + id_banner).value = delete_banner_split[0] + "-1";
		}
	}
</script>

<!-- Info Close -->
<script>
	function close_info() {
		var cont = document.getElementById('info_user');
		cont.style.display = 'none';
		document.getElementById('content_add').className = 'col-lg-6'; //Ganti ukuran form add
	}
</script>

<!-- Datetime -->
<script type="text/javascript">
	$(function() {
		$('#datetimepicker5').datetimepicker({
			locale: 'id',
			format: 'DD-MM-YYYY HH:mm',
			autoclose: true,
		});
	});

	$(function() {
		$('#datetimepicker6').datetimepicker({
			locale: 'id',
			format: 'DD-MM-YYYY HH:mm',
			autoclose: true,
		});
	});
</script>

<!-- Preview Image Upload -->
<script type="text/javascript">
	function preview_image() {
		var total_file = document.getElementById("banner_image").files.length;
		var html = "";
		for (var i = 0; i < total_file; i++) {
			html += "<div class='mb-2 text-center'>";
			html += "<img src='" + URL.createObjectURL(event.target.files[i]) + "' class='img-fluid img-rounded' style='width: 50%'>";
			html += "<hr class='dashed'>";
			html += "</div>";
		}
		$('#banner_image_preview').append(html);
	}
</script>
