<div class="content">
  
  <div class="row mt-4">
	<div class="col-sm-4">
      <h6 class="ml-3 content-title">Settings</h6>
    </div>
  </div>
  <div class="row mt-4">
    <div class="col-sm-12">
	  <div class="wrapper">
		  <ul class="tabs-box">
		  <li class="tab"><span class="badge tbl mr-2" id="myakun" data-id="<?= $user['id'] ?>" data-nama="<?= $user['nama'] ?>"
			data-email="<?= $user['email'] ?>" data-username="<?= $user['username'] ?>" data-wa="<?= $user['nomor_wa'] ?>">Akun Saya</span></li>
		  <?php if ($user['role'] == '2' OR $user['role'] == '3') : ?>
		  <li class="tab"><span class="badge tbl mr-2" id="myWaSetting" data-id="<?= $user['id'] ?>">WhatsApp Blast</span></li>
		  <li class="tab"><span class="badge tbl mr-2" id="myWaNumber">Add Whatsapp Device</span></li>
		  <?php endif; ?>
		  <?php if ($user['role'] == '1') : ?>
		  <li class="tab"><span class="badge tbl mr-2" id="addgroup">Group Tamu</span></li>
		  <li class="tab"><span class="badge tbl mr-2" id="addadmin">Setting Admin</span></li>
		  <?php endif; ?>
		  <?php if ($user['role'] == '2') : ?>
		  <li class="tab"><span class="badge tbl mr-2" id="addevent">New Event</span></li>
		  <li class="tab"><span class="badge tbl mr-2" id="adduser">Add User</span></li>
		  <li class="tab"><span class="badge tbl mr-2" id="addkuota">Kuota WhatsApp</span></li>
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
          <input type="text" placeholder="search event..." id="pencarian">
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
		{campaigns}
		<div id="campaign{id}">
		  <div id="list-event">
			<div class="figura">
				<img src="<?=base_url('assets/img/event/')?>{poto}" alt="ev">
			</div>
			<div class="detail">
				<span class="title" style="font-size: 18px !important; font-weight: 700;">{id} - {name}</span>
				<span id="user">User: <span class="text-bold"><?=$user['nama']?></span></span>
				<span id="user">Schedule:  {schedule}</span>
				<span id="user">Status:  <span id="user{id}" class="badge {status_class}">{status}</span></span>
				{control}
			</div>
		  </div>
		</div>
		{/campaigns}
    </div>

    <div class="card-footer">
    </div>
  </div>
</div>



<?php if ($user['role'] == '2') : ?>


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
            <label for="link">Undangan</label>
            <input type="url" name="link" id="link" class="form-control" placeholder="https://domain.com/rome-juliet/"
              required>
          </div>

          <div class="form-group mt-3">
            <span class="badge badge-custom"><?= $undangan_url ?></span>
          </div>

          <div class="form-group">
            <label for="post">Post ID</label>
            <input type="text" name="post" id="post" required class="form-control" value="11354"
              placeholder="Post ID: Ex. 11354">
          </div>

          <input type="text" name="url" id="url" style="display: none;" value="<?= $undangan ?>">
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
<div class="modal fade" id="addkuota" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="useraddLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="useraddLabel">Transfer Kuota <?=$user['nama']?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('whatsapp/transferkuota') ?>" method="post" class="formInput">
		  <div class="form-group">
			<p>Sisa kuota WhatsApp anda : <b><?=$user['kuota_wa']?></b> Kredit</p>
		  </div>
          <div class="form-group">
            <input type="number" name="transfer_kuota" id="transfer_kuota" class="form-control" placeholder="Jumlah kuota yang akan ditransfer" required>
          </div>

          <div class="form-group">
            <select name="user" id="user" class="form-control" required>
              <option value="">Pilih User</option>
			  <?php foreach($myuser as $u) { ?>
				<option value="<?=$u['id']?>"><?=$u['nama']?></option>
			  <?php } ?>
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

          <?php if ($user['role'] == '2') : ?>

          <div class="form-group">
            <label for="link">Undangan</label>
            <input type="url" name="link" id="link" class="form-control" placeholder="https://domain.com/romeo-juliet/"
              required>
          </div>

          <div class="form-group mt-3">
            <span class="badge badge-custom"><?= $undangan_url ?></span>
          </div>

          <div class="form-group">
            <label for="post">Post ID</label>
            <input type="text" name="post" id="post" required class="form-control" placeholder="Post ID: Ex. 11354">
          </div>


          <input type="text" name="url" id="url" style="display: none;" value="<?= $undangan ?>">

          <?php else : ?>
          <input style="display: none;" type="text" name="post" id="post" class="form-control">
          <input style="display: none;" type="text" name="link" id="link" class="form-control">
          <input style="display: none;" type="text" name="url" id="url" value="<?= $undangan ?>">
          <?php endif; ?>

          <input style="display: none;" type="text" name="id" id="id">
          <?php if ($user['role'] == '1' OR $user['role'] == '2') :?>
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
          <div class="form-group">            
            <input type="number" name="nomor_wa" id="nomor_wa" class="form-control" placeholder="Nomor WA (diawali dengan 62)">
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
            <button type="submit" class="btn btn-outline-custom rounded-pill btn-block btnSubmit">Update</button>
          </div>
        </form>

        <span class="d-block text-11"><b>Keterangan:</b></span>
        <span class="d-block text-11">Kode/Parameter <b>[NAMA-TAMU]</b> = untuk Generate nama Tamu</span>
        <span class="d-block text-11">Kode/Parameter <b>[LINK]</b> = untuk Generate Undangan</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalImage" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalImageLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalImageLabel">Edit Poto</h5>
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
</div>
<!-- Modal -->
<div class="modal fade" id="waSetting" data-backdrop="static" data-keyboard="false" tabindex="-1"  aria-labelledby="modalWaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalWaLabel">WhatsApp Blast</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>      
            </div>
            <div class="modal-body">		
                <div id="qrImg"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('template/footer'); ?>


<script>
var UrLBase = '<?= base_url() ?>';
</script>


<script src="<?= base_url('assets/custom/js/event.js?v=' . fileatime('assets/custom/js/event.js')) ?>"></script>

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