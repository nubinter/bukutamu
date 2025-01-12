<div class="content">
  
  <div class="row mt-4">
	<div class="col-sm-4">
      <h6 class="ml-3 content-title">Pengaturan</h6>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-sm-12">
	  <div class="wrapper">
		  <ul class="tabs-box">
		  <li class="tab"><span class="badge tbl mr-2" id="myakun" data-id="<?= $user['id'] ?>" data-nama="<?= $user['nama'] ?>"
			data-email="<?= $user['email'] ?>" data-username="<?= $user['username'] ?>" data-wa="<?= $user['nomor_wa'] ?>">Akun Saya</span></li>
		  <?php if ($user['role'] == '3') : ?>
		  <li class="tab"><a href="whatsapp" class="badge tbl mr-2" >WhatsApp Blast</a></li>
		  <?php endif; ?>
		  <?php if ($user['role'] == '1') : ?>
		  <!--<li class="tab"><span class="badge tbl mr-2" id="addgroup">Grup Tamu</span></li>-->
		  <li class="tab"><span class="badge tbl mr-2" id="addadmin">Setting User & Domain Comment</span></li>
		  <li class="tab"><span class="badge tbl mr-2" id="addevent">New Event</span></li>
		  <li class="tab"><span class="badge tbl mr-2" id="adduser">Add User</span></li>
		  <?php endif; ?>
		  </ul>
      </div>
    </div>
  </div>


  <div class="card mt-1 mb-3 shadow-sm">
    <div class="card-header">
      <div class="count-guest">
        <span>Jumlah Event: <span><b id="jmlevent"></b></span></span>
      </div>
    </div>
    <div class="card-body">
      <div class="list-table">
        <div class="search">
          <input type="text" placeholder="cari event..." id="pencarian">
          <i class="fa fa-search"></i>
        </div>

        <div id="boxListData"></div>

      </div>
    </div>
  </div>


  <div class="card mt-1 mb-3 shadow-sm">
    <div class="card-header">
      <div class="count-guest">
        <span>Sisa kuota kirim WhatsApp Blast: ( <span><b id="jmlevent"><?=$user['kuota_wa']?></b> Kredit )</span></span>
      </div>
    </div>
    <div class="card-body">
        <div class="list-table" id="list-table">
            <ul>
			<?php
			    if(empty($blasts)) {
			        echo '<center><a href="whatsapp"><img src="../assets/img/design/belumadawhatsappblast1.png" style="width:310px;"/></a></center>';
			    } else {
    				$i=1; 
    				foreach($blasts as $blast) {
    					if($blast['status'] == 'finished') {
    						$status = '<span class="badge badge-success">'.$blast['status'].'</span>';
    					}
    					if($blast['status'] == 'waiting') {
    						$status = '<span class="badge badge-secondary">'.$blast['status'].'</span>';
    					}
    					if($blast['status'] == 'starting') {
    						$status = '<span class="badge badge-warning">'.$blast['status'].'</span>';
    					}
    					if($blast['status'] == 'running') {
    						$status = '<span class="badge badge-primary">'.$blast['status'].'</span>';
    					}
    					if($blast['schedule'] == '0000-00-00 00:00:00') {
    						$schedule = 'langsung kirim';
    					} else {
    						$schedule = $blast['schedule'].' WIB';
    					}
    					if($blast['campaign_type'] == 'group') {
    					    if($blast['receivers'] == 'all') {
    						    $receiver = 'Semua tamu';
    					    } else {
    					        $grup = $this->m_grup->byId($blast['receivers']);
    					        $receiver = $grup['nama'];
    					    }
    					}
    					if($blast['campaign_type'] == 'selected') {
    					    $receiver = count(json_decode($blast['receivers'])).' penerima';
    					}
    			?>
    			  <li>
    				<input id="idblast" value="' . $blast['id'] . '" style="display:none">
    				<span class="nomor"><?=$i++?></span>
    				<span class="option">
    					<div class="dropdown">
    						<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"><i class="far fa-cogs"></i></a>
    						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
    							<a class="dropdown-item" href="<?=base_url('whatsapp/history/'.$blast['id'])?>"><i class='fa fa-history' style="font-size: 16px;"></i> Cek Riwayat</a>
    							<?php if($blast['status'] != 'starting') { ?>
    							<a class="dropdown-item btnDelBlast" href="<?=base_url('whatsapp/deleteCampaign/'.$blast['id'])?>"><i class="fa fa-trash mr-2" style="font-size: 16px;"></i>Delete</a>
    							<?php } ?>
    						</div>
    					</div>
    				</span>
    				<span class="title"><?=$blast['name']?></span> <span class="sub-title"><i>(<?=$blast['sender']?>)</i></span>
    				<span class="sub-title"><?=$status?> | Terjadwal <?=$schedule?> | <?=$receiver?></span>
    			  </li>
			    <?php 
			        } 
			    }
			    ?>
			</ul>
		</div>
    </div>

    <div class="card-footer">
    </div>
  </div>
</div>



<?php if ($user['role'] == '1') : ?>


<!-- Modal -->
<div class="modal fade" id="eventadd" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="eventaddLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventaddLabel">Add New Event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('seting/add') ?>" method="post" class="formInput">

          <div class="form-group">
            <label for="wedding">Event</label>
            <input type="text" name="wedding" id="wedding" class="form-control" placeholder="Ex: THE WEDDING OF"
              required>
          </div>

          <div class="form-group">
            <label for="namae">Nama Event</label>
            <input type="text" name="nama" id="namae" class="form-control" placeholder="Ex: Romeo & Juliet" required>
          </div>


          <div class="form-group">
            <label for="tgl">Tanggal Event</label>
            <input type="date" name="tgl" id="tgl" class="form-control" required>
          </div>
          
          <div class="form-group">
			<label for="undangan">Domain Integrasi Comment</label>
            <select name="undangan" id="undangan" class="form-control" required>
              <option value="">Pilih Domain</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="link">Undangan</label>
            <input type="url" name="link" id="link" class="form-control" placeholder="https://domain.com/rome-juliet/"
              required>
          </div>

          <div class="form-group">
            <label for="post">Post ID</label>
            <input type="text" name="post" id="post" required class="form-control" value=""
              placeholder="Post ID: Ex. 11354">
          </div>

          <input style="display: none;" type="text" name="kode" value="<?= $kodea ?>">
          
		  <div class="custom-control custom-switch">
			  <input type="checkbox" class="custom-control-input" name="is_qr" id="is_qr_add">
			  <label class="custom-control-label" for="is_qr_add">WhatsApp QR Code</label>
		  </div>
		  
		  <div class="custom-control custom-switch">
			  <input type="checkbox" class="custom-control-input" name="fitur_meja" id="fitur_meja_add">
			  <label class="custom-control-label" for="fitur_meja_add">Fitur Nomor Meja</label>
		  </div>
		  <div class="custom-control custom-switch">
			  <input type="checkbox" class="custom-control-input" name="fitur_ampao" id="fitur_ampao_add">
			  <label class="custom-control-label" for="fitur_ampao_add">Fitur Nomor Ampao</label>
		  </div>
          <!--ROLE : <?=$user['role']?>-->
          <div class="form-group mt-4">
            <button type="submit" class="btn btn-outline-custom rounded-pill btn-block btnSubmit">Save</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="useradd" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="useraddLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraddLabel">Add User <?=$user['nama']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('seting/adduser') ?>" method="post" class="formInput">

          <div class="form-group">
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama User" required>
          </div>

          <div class="form-group">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email User" required>
          </div>

          <div class="form-group">
            <input type="text" name="username" id="username" class="form-control" placeholder="Username Login" required>
          </div>

          <div class="form-group">
            <input type="password" name="pass" id="password" class="form-control" placeholder="Password Login" required>
          </div>

          <div class="form-group">
            <select name="event" id="event" class="form-control" required>
              <option value="">Pilih Event</option>
            </select>
          </div>

          <div class="form-group mt-4">
            <button class="btn btn-outline-custom rounded-pill btn-block btnSubmit">Save</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php endif; ?>


<!-- Modal -->
<div class="modal fade" id="eventedit" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="eventeditLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventeditLabel">Edit Event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('seting/edit') ?>" method="post" class="formInput">

          <div class="form-group">
            <label for="wedding">Event </label>
            <input type="text" name="wedding" id="wedding" class="form-control" placeholder="Ex: THE WEDDING OF"
              required>
          </div>

          <div class="form-group">
            <label for="namae">Nama Event</label>
            <input type="text" name="nama" id="namae" class="form-control" placeholder="Ex: Romeo & Juliet" required>
          </div>


          <div class="form-group">
            <label for="tgl">Tanggal Event</label>
            <input type="date" name="tgl" id="tgl" class="form-control" required>
          </div>
          


          <?php if ($user['role'] == '1') : ?>

          <div class="form-group">
            <label for="link">Undangan</label>
            <input type="url" name="link" id="link" class="form-control" placeholder="https://domain.com/romeo-juliet/"
              required>
          </div>
          
		  <div class="form-group">
			<label for="undangan">Domain Integrasi Comment</label>
            <select name="undangan" id="undangan" class="form-control" required>
              <option value="">Pilih Domain</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="post">Post ID</label>
            <input type="text" name="post" id="post" required class="form-control" placeholder="Post ID: Ex. 11354">
          </div>
          


          <input type="text" name="url" id="url" style="display: none;" value="<?= $undangan ?>">

          <?php else : ?>
          <input style="display: none;" type="text" name="post" id="post" class="form-control">
          <input style="display: none;" type="text" name="link" id="link" class="form-control">
          <input style="display: none;" type="text" name="undangan" id="domain_id" >
          <?php endif; ?>

          <input style="display: none;" type="text" name="id" id="id">
          
          
          
          
          <?php if ($user['role'] == '1' OR $user['role'] == '2') :?>
          
          <label for="is_qr" class="font-weight-bold">Fitur ini hanya bisa diedit oleh admin.</label>
          <div class="custom-control custom-switch">
			  <input type="checkbox" class="custom-control-input" name="is_qr" id="is_qr_edit">
			  <label class="custom-control-label" for="is_qr_edit">WhatsApp QR Code</label>
		  </div>
		  		  
		  <div class="custom-control custom-switch">
			  <input type="checkbox" class="custom-control-input" name="fitur_meja" id="fitur_meja_edit">
			  <label class="custom-control-label" for="fitur_meja_edit">Fitur Nomor Meja</label>
		  </div>
		  <div class="custom-control custom-switch">
			  <input type="checkbox" class="custom-control-input" name="fitur_ampao" id="fitur_ampao_edit">
			  <label class="custom-control-label" for="fitur_ampao_edit">Fitur Nomor Ampao</label>
		  </div>
          <?php else :
			  
		  endif;?>
		        
          <div class="form-group mt-4">
            <button type="submit" class="btn btn-outline-custom rounded-pill btn-block btnSubmit">Update</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="userEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="userEditLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userEditLabel">Update User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('seting/edituser') ?>" method="post" class="formInput">

          <div class="form-group">
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama User" required>
          </div>

          <div class="form-group">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email User" required>
          </div>

          <div class="form-group">
            <input type="text" name="username" id="username" class="form-control" placeholder="Username Login" required>
          </div>

          <div class="form-group">
            <input type="password" name="pass" id="password" class="form-control"
              placeholder="Kosongkan jika tidak ubah password">
          </div>

          <input style="display: none;" type="text" name="id" id="id">


          <div class="form-group mt-4">
            <button class="btn btn-outline-custom rounded-pill btn-block btnSubmit">Update</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Myakun -->
<div class="modal fade" id="userEdit1" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="userEditLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userEditLabel">Update User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('seting/editAkun') ?>" method="post" class="formInput">

          <div class="form-group">
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama User" required>
          </div>

          <div class="form-group">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email User" required>
          </div>

          <div class="form-group">
            <input type="text" name="username" id="username" class="form-control" placeholder="Username Login" required>
          </div>

          <div class="form-group">
            <input type="password" name="pass" id="password" class="form-control"
              placeholder="Kosongkan jika tidak ubah password">
          </div>
          <div class="form-group">            <input type="number" name="nomor_wa" id="nomor_wa" class="form-control" placeholder="Nomor WA (diawali dengan 62)">          </div>
          <input style="display: none;" type="text" name="id" id="id">


          <div class="form-group mt-4">
            <button class="btn btn-outline-custom rounded-pill btn-block btnSubmit">Update</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalWa" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalWaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalWaLabel">WhatsApp Template</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('seting/editWa') ?>" method="post" class="formInput">


          <div class="form-group">
            <label for="pesan">Edit kata pengantar Undangan:</label>
            <textarea name="pesan" id="pesan" rows="10" class="form-control" required></textarea>
          </div>
          <input style="display: none;" type="text" name="id" id="id">

          <div class="form-group mt-4">
            <button type="submit" class="btn btn-warning btn-block rounded-pill px-4 font-weight-bold btnSubmit">Simpan</button>
            <button type="button" class="btn btn-light btn-block rounded-pill px-4" data-dismiss="modal">Tutup</button>
          </div>
        </form>

            <span class="d-block text-11"><br><b>Keterangan:</b></span>
            <span class="d-block text-11 copy-text" data-text="[NAMA-TAMU]">Kode/Parameter <b>[NAMA-TAMU]</b> = untuk Generate Nama Tamu</span>
            <span class="d-block text-11 copy-text" data-text="[LINK]"><br>Kode/Parameter <b>[LINK]</b> = untuk Generate Undangan</span>
            <span class="d-block text-11"><br><b>Perhatian:</b></span>
            <span class="d-block text-11">Silakan ubah Kata Pengantar sesuai keinginan namun jangan Ubah/hapus Kode Parameter cukup ditambahkan tanpa ubah apapun!</span>
      </div>
      
      
      
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-light btn-block rounded-pill px-4" data-dismiss="modal">Tutup</button>-->
      </div>
    </div>
  </div>
</div>



<!--<script>-->
<!--        document.addEventListener('DOMContentLoaded', function () {-->
<!--        // Menambahkan event listener untuk setiap elemen dengan class 'copy-text'-->
<!--        var copyTextElements = document.querySelectorAll('.copy-text');-->
<!--        copyTextElements.forEach(function (element) {-->
<!--            element.addEventListener('click', function () {-->
<!--                copyToClipboard(element.getAttribute('data-text'));-->
<!--            });-->
<!--        });-->

<!--        function copyToClipboard(text) {-->
<!--        // Buat elemen input untuk menampung teks yang akan disalin-->
<!--        var input = document.createElement('input');-->
<!--        input.setAttribute('value', text);-->
<!--        document.body.appendChild(input);-->

<!--        // Pilih teks dalam elemen input-->
<!--        input.select();-->
<!--        input.setSelectionRange(0, 99999); // Untuk mendukung perangkat mobile-->

<!--        // Salin teks ke clipboard-->
<!--        document.execCommand('copy');-->

<!--        // Hapus elemen input yang sudah tidak diperlukan-->
<!--        document.body.removeChild(input);-->

<!--        // Tampilkan SweetAlert2-->
<!--            Swal.fire({-->
<!--                icon: 'success',-->
<!--                // title: 'Parameter berhasil disalin!',-->
<!--                text: 'Parameter ' + text + ' berhasil disalin!',-->
<!--                showConfirmButton: false,-->
<!--                timer: 2000-->
<!--            });-->
<!--        }-->
<!--        });-->
<!--        </script>-->


<!-- Modal -->
<div class="modal fade" id="modalImage" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalImageLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalImageLabel">Edit Foto Display</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <form action="<?= base_url('seting/editPoto') ?>" method="post" class="formInput2">

          <img src="" class="img-fluid" id="preview" alt="img">

          <input style="display: none;" type="text" name="id" id="id">
          <input style="display: none;" oninput="readURL(this)" accept="image/*" type="file" name="poto" id="poto">

          <div class="form-group mt-4">
            <button type="button" class="btn btn-outline-custom px-4 rounded-pill btnUpload ">Upload</button>
            <button type="submit" class="btn btn-custom px-4 rounded-pill  btnSubmit">Update</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div><!-- Modal --><div class="modal fade" id="waSetting" data-backdrop="static" data-keyboard="false" tabindex="-1"  aria-labelledby="modalWaLabel" aria-hidden="true">  <div class="modal-dialog">    <div class="modal-content">      <div class="modal-header">        <h5 class="modal-title" id="modalWaLabel">WhatsApp Blast</h5>        <button type="button" class="close" data-dismiss="modal" aria-label="Close">          <span aria-hidden="true">&times;</span>        </button>      </div>      <div class="modal-body">		<div id="qrImg"></div>      </div>      <div class="modal-footer">        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>      </div>    </div>  </div></div>



<?php $this->load->view('template/footer'); ?>


<script>
var UrLBase = '<?= base_url() ?>';
</script>




<script>

$('.custom-file-input').on('change', function() {
  let fileName = $(this).val().split('\\').pop();
  $(this).next('.custom-file-label').addClass("selected").html(fileName);
});

function updateStatus(id, status, badge) {
	$.ajax({
		type: "POST",
		url: "<?= base_url('whatsapp/updatestatuscampaign') ?>",
		data: { id: id, status: status },
		success: function (response) {
			var statusElement = $('#user'+id);
			statusElement.removeClass(); // Remove existing classes
			statusElement.disabled = true; // Remove existing classes
			statusElement.addClass('badge badge-' + badge); // Add new classes
			statusElement.text(status); // Set new status text
		},
		error: function (xhr, textStatus, errorThrown) {
			// Handle errors here if the AJAX request fails
			console.error('Error updating status:', errorThrown);
		}
	});
}

// Add click event listeners to your buttons
$(document).ready(function () {
    
    loadUndangan();
    
    function loadUndangan() {
      $.ajax({
        url: UrLBase + 'seting/loadDomain',
        type: "post",
        cache: false,
        success: function(respon) {
          $('.modal#eventadd input').val('');
          $('.modal#eventadd select#undangan').html(respon);
          $('.modal#eventedit select#undangan').html(respon);
        }
      })
    }
    
	$('.play').click(function () {
		var status = $(this).data('status');
		var id = $(this).data('id');
		var badge = $(this).data('class');
		updateStatus(id, status, badge);
	});
	$('.delete').click(function () {
		var id = $(this).data('id');
		Swal.fire({
		  title: 'Yakin ingin hapus?',
		   text: "WhatsApp blast ini akan dihapus!!",
		   showCancelButton: true,
		   confirmButtonColor: '#3085d6',
		   cancelButtonColor: '#d33',
		   confirmButtonText: 'Yaa, Hapus!',
		   position: 'top-center',
		   showLoaderOnConfirm: true,
		}).then((result) => {
		  if (result.isConfirmed) {
			$.ajax({
				  url: UrLBase + 'whatsapp/deleteCampaign',
				  type: "POST",
				  data: {
					id: id
				  },
				  cache: false,
				  beforeSend: function () {
					$("#LoadingPage").fadeIn();
				  },
				  success: function () {
					var campaignElement = $('#campaign'+id);
					campaignElement.remove();
					$("#LoadingPage").fadeOut();
				  }
				})
			
		  } else if (result.dismiss === Swal.DismissReason.cancel) {
		  }
		});
	});
});
</script>



<script src="<?= base_url('assets/custom/js/event.js?v=' . fileatime('assets/custom/js/event.js')) ?>"></script>