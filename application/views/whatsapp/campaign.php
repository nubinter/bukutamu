<div class="content">

  
  <div class="row mt-4">
    <div class="col">
      <h6 class="col-9 content-title"><b>WhatsApp Blast</b></h6>
    </div>
  </div>


<style>
  .required:after {
    content:" *";
    color: red;
  }
</style>


  <div class="card mt-1 mb-3 shadow-sm">
    <div class="card-body">
		<div class="card-title">
			<span><b>Buat WhatsApp Blast Baru</b></span>
		</div>
		<form action="<?= base_url('whatsapp/saveCampaign') ?>" method="post" class="formInput">
			<input type="hidden" name="user_id" value="<?=$user['id']?>" required>
			<input type="hidden" id="event_id" name="event_id" value="<?=$event['id']?>" required>
			<?php 
				if($user['role'] == 2) {
			?>
			<input type="hidden" id="leader_id" name="leader_id" value="<?=$user['id']?>" required>
			<div class="form-group">
			  <label for="receivers">Pilih Event</label>
			  <select id="events_select" class="form-control" required>
				<option value="">Pilih Event</option>
				<?php foreach($events as $event) : ?>
					<option value="<?= $event['id'] ?>" data-wa="<?= $event['wa'] ?>" data-name="<?= $event['nama'] ?>" data-wedding="<?= $event['wedding'] ?>"><?= $event['nama'] ?></option>
				<?php endforeach; ?>
			  </select>
			</div>
			<?php
				} else {
			?>
				<input type="hidden" id="leader_id" name="leader_id" value="<?=$event['leader_id']?>" required>
			<?php
				}
			?>
			<div class="form-group">
				<label class="required" for="namae">Nama Event</label>
				<input type="text" name="name" id="name" class="form-control" placeholder="Ex: Romeo & Juliet" value="<?=$event['wedding']?> <?=$event['nama']?>" required>
			</div>
			
			
			
			<div class="form-group">
            <label for="pesan">Edit kata pengantar Undangan:</label>
            <textarea name="template" id="template" rows="10" class="form-control" required><?=$event['wa']?></textarea>
            <span class="d-block text-11"><br><b>Keterangan:</b></span>
            <span class="d-block text-11 copy-text" data-text="[NAMA-TAMU]">Kode/Parameter <b>[NAMA-TAMU]</b> = untuk Generate Nama Tamu</span>
            <span class="d-block text-11 copy-text" data-text="[LINK]"><br>Kode/Parameter <b>[LINK]</b> = untuk Generate Undangan</span>
            <span class="d-block text-11 copy-text" data-text="[E-INVITATION]"><br>Kode/Parameter <b>[E-INVITATION]</b> = untuk Generate Link QR Code (E-Invitation)</span>
            <span class="d-block text-11"><br><b>Perhatian:</b></span>
            <span class="d-block text-11">Silakan gunakan ataupun hapus Kode/Parameter sesuai kebutuhan</span>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function () {
        // Menambahkan event listener untuk setiap elemen dengan class 'copy-text'
        var copyTextElements = document.querySelectorAll('.copy-text');
        copyTextElements.forEach(function (element) {
            element.addEventListener('click', function () {
                copyToClipboard(element.getAttribute('data-text'));
            });
        });

        function copyToClipboard(text) {
        // Buat elemen input untuk menampung teks yang akan disalin
        var input = document.createElement('input');
        input.setAttribute('value', text);
        document.body.appendChild(input);

        // Pilih teks dalam elemen input
        input.select();
        input.setSelectionRange(0, 99999); // Untuk mendukung perangkat mobile

        // Salin teks ke clipboard
        document.execCommand('copy');

        // Hapus elemen input yang sudah tidak diperlukan
        document.body.removeChild(input);

        // Tampilkan SweetAlert2
            Swal.fire({
                icon: 'success',
                // title: 'Parameter berhasil disalin!',
                text: 'Parameter ' + text + ' berhasil disalin!',
                showConfirmButton: false,
                timer: 2000
            });
    }
    });
</script>

			
			
			
			
			
			
			<div class="form-group">
                <label class="required" for="delay">Delay antar Pesan (Detik)</label>
                <select name="delay" id="delay" class="form-control" required>
                    <option value="15" >15 Detik</option>
                    <option value="20">20 Detik</option>
                    <option value="30">30 Detik</option>
                    <option value="35" selected>35 Detik</option> <!-- Nilai default -->
                    <option value="40">40 Detik</option>
                    <option value="50">50 Detik</option>
                    <option value="60">60 Detik</option>
                </select>
            </div>
			
			
			<div class="form-group">
			  <label class="required" for="senders">Pilih WhatsApp Pengirim</label>
			  <select name="sender" id="sender_select" class="form-control" required>
				<!--<option value="">Pilih Whatsapp Pengirim</option>-->
				<?php foreach($senders as $sender) : ?>
				    <?php
				        if($sender['status'] == 'authenticated') {
				            $disabled = '';
				            $status = 'Terhubung';
				        } else {
				            $disabled = 'disabled';
				            $status = 'Tidak Terhubung';
				        }
				    ?>
					<option value="<?= $sender['nomor_wa'] ?>" <?=$disabled?>><?= $sender['nomor_wa'] ?> (<?=$status?>)</option>
				<?php endforeach; ?>
			  </select>
			  <span class="d-block text-11" >Jika belum ada nomor terhubung, silakan <b><a href="<?=base_url('whatsapp')?>">tambahkan device pengirim</a></b>.</span>
			</div>
			<div class="form-group">
				<label for="schedule">Atur Kirim Terjadwal</label>
				<input type="datetime-local" name="schedule" class="form-control" placeholder="Pilih tanggal dan waktu" >
				<span class="d-block text-11"><b>Kosongkan</b> apabila <b>pesan langsung dikirim</b></span>
			</div>
			<div class="form-group">
			  <label class="required" for="receivers">Kirim Berdasarkan Grup Tamu</label>
			  <select id="grouptamu" name="receivers" class="form-control" required>
				<option value="">Pilih Grup Tamu</option>
				<option value="all">Semua Grup Tamu</option>
				<?php foreach($group as $grp) : ?>
				<option value="<?= $grp['id'] ?>"><?= $grp['nama'] ?></option>
				<?php endforeach; ?>
			  </select>
			  <div id="hasil-cek-kuota"></div>
			</div>
			<div class="form-group mt-4">
				<button type="submit" class="btn btn-warning btn-block rounded-pill px-4 font-weight-bold btnSubmit">Buat WhatsApp Blast</button>
			</div>
		</form>
    </div>
  </div>

</div>


<?php $this->load->view('template/footer'); ?>



<script>
    document.getElementById('delay').addEventListener('change', function () {
        var delayInput = document.getElementById('delay');
        var delayTextInput = document.getElementById('delay-text');

        // Variabel untuk menandai apakah opsi "Random" dipilih
        var isRandom = false;

        if (delayInput.value === 'random') {
            // Set nilai secara acak di antara 10 dan 60 (gantilah sesuai kebutuhan)
            var randomValue = Math.floor(Math.random() * (20 - 1 + 1)) + 1;

            // Ganti placeholder dengan teks penggantian
            delayTextInput.innerHTML = 'Nilai acak: ' + randomValue + ' detik';

            // Set nilai pada elemen input
            delayInput.value = randomValue;

            // Set variabel isRandom menjadi true
            isRandom = true;
        } else {
            // Jika bukan opsi "random", reset placeholder
            delayTextInput.innerHTML = '';

            // Set variabel isRandom menjadi false
            isRandom = false;
        }

        // Set nilai kembali ke "random" jika opsi "Random" dipilih
        if (isRandom) {
            delayInput.value = 'random';
        } else {
            // Jika nilai bukan "random", sesuaikan dengan nilai dari controller
            // Pastikan nilai yang diambil dari controller disesuaikan dengan nilai yang mungkin dalam dropdown
            var nilaiDariController = <?php echo json_encode($nilaiDariController); ?>;
            delayInput.value = nilaiDariController; // Ganti dengan nilai yang benar dari controller
        }
    });
</script>











<script>
var UrLBase = '<?= base_url() ?>';
$(document).ready(function () {
	var group = $('#grouptamu');
	var events_select = $('#events_select');
	events_select.on('change', function () {
		var selectedOption = $(this).find("option:selected");
		var eventId = events_select.val();
		var eventName = selectedOption.data("name");
		var eventWedding = selectedOption.data("wedding");
		var eventWa = selectedOption.data("wa");
		var event_id = $('#event_id').val(eventId);
		var campaign_name = $('#name').val(eventWedding+' '+eventName);
		var template = $('#template').val(eventWa);
		$.ajax({
            type: 'POST',
            url: UrLBase+'whatsapp/listGroup',
            data: { 
				event_id: eventId
			},
            success: function (hasil) {
                group.html(hasil);
            },
            error: function () {
                console.error('Kesalahan dalam permintaan AJAX');
            }
        });
	});
	
    group.on('change', function () {
        var selectedOption = group.val();
		var event_id = $('#event_id').val();
        $.ajax({
            type: 'POST',
            url: UrLBase+'whatsapp/cekJumlahTamu',
            data: { 
				group_id: selectedOption,
				event_id: event_id
			},
            success: function (hasil) {
                $('#hasil-cek-kuota').html(hasil);
            },
            error: function () {
                console.error('Kesalahan dalam permintaan AJAX');
            }
        });
    });
	
	$('.btnSubmit').on('click', function (e) {
        e.preventDefault(); 
        var selectedOption = $('#grouptamu').val();
		if (!selectedOption) {
            $('#hasil-cek-kuota').html('<span style="color: red;">Pilih grup tamu yang akan dikirim terlebih dahulu</span>');
            return; 
        }
        $.ajax({
            type: 'POST',
            url: '<?= base_url('whatsapp/saveCampaign') ?>',
            data: $('.formInput').serialize(),
            success: function (response) {
                console.log('Berhasil:', response);
                if(response.kode == 1) {
    				Swal.fire({
    					title: 'Sukses',
    					text: 'WhatsApp Blast berhasil dibuat. Pesan akan dikirim berdasarkan jadwal yang telah ditentukan.',
    					icon: 'info',
    					showConfirmButton: false,
    					timer: 3500,
    				}).then(function () {
                        window.location.href = '<?= base_url('seting') ?>';
                    });
                }
                if(response.kode == 2) {
    				Swal.fire({
    					title: 'Gagal',
    					text: response.pesan,
    					icon: 'error',
    					showConfirmButton: false,
    				});
                }
            },
            error: function (error) {
                console.error('Kesalahan:', error);
            }
        });
    });
});
</script>
