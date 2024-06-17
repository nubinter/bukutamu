<div class="content">
    
  <div class="row mt-3">

    <div class="col-6">
      <h6 class="ml-3 content-title">Data Akun WA</h6>
    </div>

  </div>

  <div class="card mt-1 mb-3 shadow-sm">
    <div class="card-header">
      <div class="row">
        <div class="col-8">

          <div class="roundedOne d-inline-block">
            <input type="checkbox" value="" id="roundedOne" name="check" />
            <label for="roundedOne"></label>
          </div>

        </div>
        

        <div class="col-4 text-right">

          <div class="dropdown d-inline-block mr-2">
            <a class="dropdown-toggle btnIconOption px-4" type="button" id="dropdownMenuButton" data-toggle="dropdown"
              aria-expanded="false">
              <i class="far fa-user-plus"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" id="btnAdd" href="#"><i class='fa fa-user-plus' style="font-size: 12.6px;"></i> Tambah Akun</a>
            </div>

          </div>
        </div>

      </div>

    </div>
    <div class="card-body">
      <div class="list-table">
        <div class="search">
          <input type="text" placeholder="Search..." id="pencarian">
          <i class="fa fa-search"></i>
        </div>
        <ul>
          <li><span class="sub-title">Loading...</span></li>
        </ul>
      </div>
    </div>

    <div class="card-footer">

      <div class="pagination-custom">
        <ul>
          <li class="pagina-left"><i class="far fa-chevron-left"></i></li>
          <li class="pagina-number">1</li>
          <li class="pagina-right"><i class="far fa-chevron-right"></i></li>
        </ul>
      </div>

    </div>
  </div>



</div>


<!-- Modal -->
<div class="modal fade" id="modaladd" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modaladdLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaladdLabel">New Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('tamu/addData') ?>" method="post" class="formInput">
          <div class="form-group">
            <label for="nama" class="text-custom">Nama Tamu</label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Isikan Nama Tamu" required>
          </div>
          <div class="form-group">
            <label for="alamat" class="text-custom">Alamat/Keterangan Lain</label>
            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Isikan (-) Jika nihil" required>
          </div>
          <div class="form-group">
            <label for="nomor_wa" class="text-custom">Nomor WhatsApp</label>
            <input type="int" class="form-control" name="nomor_wa" id="nomor_wa" placeholder="Contoh : 628971851xxx">
			<div id="hasil-cek-nomor"></div>
          </div>
          <div class="form-group">
            <label for="vip" class="text-custom">Tamu VIP</label>
            <select name="vip" id="vip" class="form-control" required>
              <option value="1">Ya</option>
              <option selected value="0">Tidak</option>
            </select>
          </div>

          <div class="form-group mb-3">
            <select name="group" id="group" class="form-control" required>
              <option value="">Pilih Group Tamu</option>
              <?php foreach($group as $grp) : ?>
              <option value="<?= $grp['id'] ?>"><?= $grp['nama'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <input type="text" id="id" name="id" style="display: none;">

          <div class="form-group">
            <button type="submit" class="btn btn-block btn-outline-custom rounded-pill btnSubmit">Save</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modaledit" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modaleditLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaleditLabel">Update Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('tamu/editData') ?>" method="post" class="formInput">
          <div class="form-group">
            <label for="nama" class="text-custom">Nama Tamu</label>
            <input type="text" class="form-control" name="nama" id="nama" required>
          </div>
          <div class="form-group">
            <label for="alamat" class="text-custom">Alamat</label>
            <input type="text" class="form-control" name="alamat" id="alamat" required>
          </div>
          <div class="form-group">
            <label for="nomor_wa" class="text-custom">Nomor WhatsApp</label>
            <input type="int" class="form-control" name="nomor_wa" id="nomor_wa" placeholder="Contoh : 628971851xxx">
			<div id="hasil-cek-nomor"></div>
          </div>

          <div class="form-group">
            <label for="vip" class="text-custom">VIP</label>
            <select name="vip" id="vip" class="form-control" required>
              <option value="1">Ya</option>
              <option value="0">Tidak</option>
            </select>
          </div>


          <div class="form-group mb-3">
            <select name="group" id="group" class="form-control" required>
              <option value="">All Group</option>
              <?php foreach($group as $grp) : ?>
              <option value="<?= $grp['id'] ?>"><?= $grp['nama'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <input type="text" id="id" name="id" style="display: none;">

          <div class="form-group">
            <button type="submit" class="btn btn-block btn-outline-custom rounded-pill btnSubmit">Update</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalQr" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalQrLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div id="areaDownloadQr" class="text-center">
          <img class="img-fluid mb-3" src="<?= base_url('assets/img/event/' . $event['poto']) ?>" alt="img">
          <div class="row pl-2 pr-1">
            <div class="col-6 qrEvent">
              <div class="qrWeding"><?= $event['wedding'] ?></div>
              <div class="qrManten"><?= $event['nama'] ?></div>
              <div class="qrTgl"><?= $this->m_time->longDate(date('Y-m-d', strtotime($event['tgl']))) ?></div>

              <div class="qrTamu">
                <div>Kepada Yth.</div>
                <div>Bapak/Ibu/Saudara/i:</div>
                <div id="qrTamuNama">Nama Tamu</div>
                <div class="ml-3">di/sebagai</div>
                <div id="qrTamuAlamat"></div>
                <span class="badge badge-custom badges-vip">VIP</span>
                
              </div>
            </div>
            <div class="col-6 text-center">
              <img class="img-fluids mb-1 d-inline-block" width="150" src="<?= base_url('assets/img/page/LOGO-BIRU.png') ?>"
                alt="qr">
              <img class="img-fluid" src="" alt="qr" id="imgqr">
            </div>
            <div id="areaDownloadQr" class="text-center">
              <img class="img-fluid mb-3" src="<?= base_url('assets/img/page/TEXT-BAWAH-QR1.png') ?>" alt="img">
            </div>
          </div>
        </div>
		  <div class="modal-footer">
			<button type="button" id="btnDwlQr" class="btn btn-custom rounded-pill px-4">DOWNLOAD <span
				class="d-none d-sm-inline-block">QR-CODE</span></button>
			<button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close</button>
		  </div>
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
        <h5 class="modal-title" id="modalWaLabel">Text Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-4">
          <label for="pesan" class="text-custom">Message</label>
          <textarea id="pesan" rows="6" class="form-control"></textarea>
        </div>

        <div class="form-group">
          <button type="button" class="btn btn-block btn-custom rounded-pill" onclick="copyTeks()">Copy</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="modalGroup" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalGroupLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="modalGroupLabel">Filter Group</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <select id="grouptamu" class="form-control">
            <option value="">All Group Tamu</option>
            <?php foreach($group as $grp) : ?>
            <option value="<?= $grp['id'] ?>"><?= $grp['nama'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<?php $this->load->view('template/footer'); ?>


<script>
var UrLBase = '<?= base_url() ?>';
var carinya = '';
</script>

<script src="<?= base_url('assets/custom/js/tamu.js?v=' . fileatime('assets/custom/js/tamu.js')) ?>"></script>
<script src="<?= base_url('assets/custom/js/canvas2.js') ?>"></script>

<script>
function copyTeks() {
  $('.modal#modalWa').modal('hide');
  var text = $('.modal#modalWa textarea#pesan').select().val();
  document.execCommand("copy");
  /*$.toast({
    heading: 'Success',
    text: 'Message copyed!',
    showHideTransition: 'slide',
    icon: 'success',
    loaderBg: '#e834eb',
    position: 'top-center'
  });*/
  
//   showSuccessAlert('Message copyed!')

Swal.fire({
                title: 'Kata Pengantar Tersalin.',
                text: 'Silahkan paste dan kirim ke tamu undangan.',
                icon: 'info',
                showConfirmButton: false,
                timer: 3500,
              })
}
</script>