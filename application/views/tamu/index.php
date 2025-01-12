<div class="content">
    

  <div class="d-block text-center">
    <div class="box-manten box-dua shadow">
      <p id="wed"><?= $event['wedding'] ?></p>
      <h2><?= $event['nama'] ?></h2>
      <p id="dt"><?= $this->m_time->longDate($event['tgl']) ?></p>
    </div>
  </div>




  <div class="row mt-3">

    <div class="col-6">
      <!--<h6 class="ml-3 content-title">Data Tamu</h6>-->
      
      <h6 class="ml-3 content-title">
      <img src="<?= base_url('assets/img/design/contact-list.png') ?>" alt="Data Tamu" style="width: 27px; height: 27px; margin-right: 5px;">
       Data Tamu
      </h6>
      
      
    </div>

    <div class="col-6">
      <div class="count-guest text-right pr-3">
        <span class="">Undangan Terdaftar: <span id="jml">0</span></span>
      </div>
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

          <div class="dropdown d-inline-block ml-2">
            <a class="dropdown-toggle btnIconOption px-4" type="button" id="dropdownMenuButton" data-toggle="dropdown"
              aria-expanded="false">
              <i class="far fa-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" id="btnWaSelected" data-id_event="<?=$event['id']?>"><i class='fab fa-whatsapp mr-2' style="font-size: 15.6px;"></i>Kirim WhatsApp</a>
              <a class="dropdown-item" id="btnPdf" href="#"><i class="fas fa-file-pdf mr-2" style="font-size: 14.5px;" ></i> Cetak PDF QR Code</a>
              <a class="dropdown-item" id="btnDelAll" href="#" style="color: #FF0000;"><i class="fas fa-trash mr-2" style="font-size: 13px; color: #FF0000;"></i> Hapus Tamu</a>
            </div>
          </div>


         <ul style="list-style: none;display: flex;" class="pt-3 text-12">
            <li class="mr-1 p-1 px-3 bg-custom rounded-pill"><a id="btnGroup" href=""
                class="text-decoration-none text-white"><i class="far fa-filter"></i>
                Semua Grup</a></li>
          </ul>

          <input type="text" id="group" hidden>


        </div>
        

        <div class="col-4 text-right">

          <div class="dropdown d-inline-block mr-2">
            <a class="dropdown-toggle btnIconOption px-4" type="button" id="dropdownMenuButton" data-toggle="dropdown"
              aria-expanded="false">
              <i class="far fa-user-plus"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" id="btnAdd" href="#"><i class='fa fa-user-plus mr-2' style="font-size: 12.6px;"></i>Input Manual</a>
              <a class="dropdown-item" href="<?= base_url('tamu/import') ?>"><i class='fas fa-file-import mr-2' style="font-size: 12.6px;"></i> Import Excel</a>
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
          <li><span class="sub-title">Sedang memuat...</span></li>
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



<style>
  .required:after {
    content:" *";
    color: red;
  }
</style>



<!-- Modal -->
<div class="modal fade" id="modaladd" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modaladdLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaladdLabel">Tambah Data Tamu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('tamu/addData') ?>" method="post" class="formInput">
          <div class="form-group">
            <label for="nama" class="text-custom required">Nama Tamu:</label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Isikan Nama Tamu" required>
          </div>
          <div class="form-group">
            <label for="alamat" class="text-custom required">Alamat/Keterangan Lain:</label>
            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Isikan (-) Jika nihil" required>
          </div>
          <div class="form-group">
            <label for="nomor_wa" class="text-custom">Nomor WhatsApp:</label>
            <input type="tel" class="form-control" name="nomor_wa" id="nomor_wa" placeholder="Contoh : 628971851xxx">
			<div id="hasil-cek-nomor"></div>
          </div>
          <?php if($event['fitur_meja'] == 1) { ?>
          <div class="form-group">
            <label for="nomor_meja" class="text-custom">Nomor Meja:</label>
            <input type="text" class="form-control" name="nomor_meja" id="nomor_meja" placeholder="Nomor Meja">
          </div>
          <?php } ?>
          <div class="form-group">
            <label for="vip" class="text-custom required">Tamu VIP ?</label>
            <select name="vip" id="vip" class="form-control" required>
              <option value="1">Ya</option>
              <option selected value="0">Tidak</option>
            </select>
          </div>

          <div class="form-group mb-3">
            <label for="group" class="text-custom required">Grup Tamu:</label>
            <select name="group" id="group" class="form-control" required>
              <?php foreach($group as $grp) : ?>
              <option value="<?= $grp['id'] ?>"><?= $grp['nama'] ?></option>
              <?php endforeach; ?>
            </select>
            <span class="d-block text-11" >Jika belum ada grup tamu, silakan <b><a href="<?=base_url('tamu/group/'.$event['id'])?>">buat grup tamu</a></b>.</span>
          </div>

          <input type="text" id="id" name="id" style="display: none;">

          <div class="modal-footer">
            <button type="submit" class="btn btn-warning btn-block rounded-pill px-4 font-weight-bold btnSubmit">Simpan</button>
            
            <button type="button" class="btn btn-light btn-block rounded-pill px-4" data-dismiss="modal">Tutup</button>
          </div>
        </form>
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
        <h5 class="modal-title" id="modaleditLabel">Perbarui Data Tamu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('tamu/editData') ?>" method="post" class="formInput">
          <div class="form-group">
            <label for="nama" class="text-custom required">Nama Tamu:</label>
            <input type="text" class="form-control" name="nama" id="nama" required>
          </div>
          <div class="form-group">
            <label for="alamat" class="text-custom required">Alamat/Keterangan Lain:</label>
            <input type="text" class="form-control" name="alamat" id="alamat" required>
          </div>
          <div class="form-group">
            <label for="nomor_wa" class="text-custom">Nomor WhatsApp:</label>
            <input type="tel" class="form-control" name="nomor_wa" id="nomor_wa" placeholder="Contoh : 628971851xxx">
			<div id="hasil-cek-nomor"></div>
          </div>
          <?php if($event['fitur_meja'] == 1) { ?>
          <div class="form-group">
            <label for="nomor_meja" class="text-custom">Nomor Meja:</label>
            <input type="text" class="form-control" name="nomor_meja" id="nomor_meja" placeholder="Nomor Meja">
          </div>
          <?php } ?>
          <div class="form-group">
            <label for="vip" class="text-custom required">Tamu VIP ?</label>
            <select name="vip" id="vip" class="form-control" required>
              <option value="1">Ya</option>
              <option value="0">Tidak</option>
            </select>
          </div>


          <div class="form-group mb-3">
              <label for="group" class="text-custom required">Grup Tamu:</label>
            <select name="group" id="group" class="form-control" required>
              <?php foreach($group as $grp) : ?>
              <option value="<?= $grp['id'] ?>"><?= $grp['nama'] ?></option>
              <?php endforeach; ?>
            </select>
            <span class="d-block text-11">Jika belum ada grup tamu, silakan <b><a href="<?=base_url('tamu/group/'.$event['id'])?>">buat grup tamu</a></b>.</span>
          </div>

          <input type="text" id="id" name="id" style="display: none;">

          <div class="modal-footer">
            <button type="submit" class="btn btn-warning btn-block rounded-pill px-4 font-weight-bold btnSubmit">Perbarui</button>
            
            <button type="button" class="btn btn-light btn-block rounded-pill px-4" data-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<style>
    
    .bg-black{
        
        background-color: #261b6f;
    }
    
    .container2 {
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.info_text2 {
  max-width: 100%;
  margin: 0 auto;
}

@media (max-width: 576px) {
  .container2 {
    flex-direction: column;

    
</style>


<!-- Modal -->
<div class="modal fade" id="modalQr" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalQrLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div id="areaDownloadQr" class="text-center position-relative">
            
            <span class="badges-vip position-absolute bg-warning font-weight-bolder" style="top:0;right:0;padding: 2px 8px;border:2px solid #000;color:#000;font-style:italic">VIP</span>
          <img class="img-fluid mb-3" src="<?= base_url('assets/img/event/' . $event['poto']) ?>" alt="img">
          <div class="row pl-2 pr-1">
            <div class="col-6 qrEvent">
              <div class="qrWeding"><?= $event['wedding'] ?></div>
              <div class="qrManten"><?= $event['nama'] ?></div>
              <div class="qrTgl"><?= $this->m_time->longDate(date('Y-m-d', strtotime($event['tgl']))) ?></div>

              <div class="qrTamu">
                <!--<div>Kepada Yth.</div>-->
                <div>Dear,</div>
                <div id="qrTamuNama">Nama Tamu</div>
                <div>Alamat/Keterangan:</div>
                <div id="qrTamuAlamat"></div>
                <!--<span class="badge badge-custom badges-vip">VIP</span>-->
                
              </div>
              <div>   </div>
            </div>
            <div class="col-6 text-center">
              <!--<img class="img-fluids mb-1 d-inline-block" width="150" src="<?= base_url('assets/img/page/LOGO-BIRU.png') ?>"-->
              <!--  alt="qr">-->
              <img class="img-fluid" src="" alt="qr" id="imgqr">
            </div>
        
          </div>
          
  <!--        <div class="container2 mt-4 bg-black text-white pt-1 pb-1">-->
  <!--<div class="row">-->
  <!--  <div class="col">-->
    
  <!--  </div>-->
  <!--  <div class="col-xs-9 text-center info_text2 lh-1">-->
  <!--    HARAP TUNJUKKAN KARTU INI<br />-->
	 <!-- SEBAGAI AKSES MASUK LOKASI ACARA!-->
  <!--  </div>-->
  <!--  <div class="col">-->
      
  <!--  </div>-->
  <!--</div>-->
  <!--      </div>-->
  
  
  <br />
		  <div id="logo_brand" style="background-color: #000000; height: 53px; color: white; font-size: 12px;">
			<div class="row">
				<div class="col-4 img_brand" style="display: grid; place-items: center; margin-top: 9px; padding-left: 25px;">
					<img width="90" src="<?= base_url('assets/img/page/logo.png') ?>">
				</div>
				<div class="col-8" style="margin-top: 9px; text-align: left;">
					HARAP TUNJUKAN KARTU INI<br />
					UNTUK CHECK-IN DI LOKASI ACARA.
				</div>
			</div>
		  </div>
  
  
        </div>
		  <div class="modal-footer">
			<button type="button" id="btnDwlQr" class="btn btn-warning btn-block rounded-pill px-4 font-weight-bold">UNDUH <span
				class="d-none d-sm-inline-block">QR CODE</span></button>
			<button type="button" class="btn btn-light btn-block rounded-pill px-4" data-dismiss="modal">Tutup</button>
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
        <h5 class="modal-title" id="modalWaLabel">Hasil Kalimat Undangan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-4">
          <label for="pesan" class="text-custom">Kalimat Undangan</label>
          <textarea id="pesan" rows="6" class="form-control"></textarea>
        </div>

        <div class="form-group">
          <button type="button" class="btn btn-warning btn-block rounded-pill px-4 font-weight-bold" onclick="copyTeks()">Salin Kalimat Undangan</button>
          
          <button type="button" class="btn btn-light btn-block rounded-pill px-4" data-dismiss="modal">Tutup</button>
        </div>
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
        <h6 class="modal-title" id="modalGroupLabel">Filter Grup</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <select id="grouptamu" class="form-control">
            <option value="">Semua Grup</option>
            <?php foreach($group as $grp) : ?>
            <option value="<?= $grp['id'] ?>"><?= $grp['nama'] ?></option>
            <?php endforeach; ?>
          </select>
          <span class="d-block text-11">Jika belum ada grup tamu, silakan <b><a href="<?=base_url('tamu/group/'.$event['id'])?>">buat grup tamu</a></b>.</span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-light btn-block rounded-pill px-4" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalSelectedBlast" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalGroupLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="modalGroupLabel">Kirim Whatsapp Tamu Terseleksi</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="sender_select">Pilih Whatsapp Pengirim</label>
          <select id="sender_select" class="form-control">
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
            <label for="delay">Delay antar Pesan (Detik)</label>
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-block rounded-pill px-4 font-weight-bold" id="saveBlast">Kirim</button>
        <button type="button" class="btn btn-light btn-block rounded-pill px-4" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalSendWa" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalGroupLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="modalGroupLabel">Kirim WhatsApp (Auto)</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="id_tamu">Pilih WhatsApp Pengirim</label>
          <input type="hidden" id="id_tamu" value="" />
          <select id="sender_select2" class="form-control">
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-block rounded-pill px-4 font-weight-bold" id="kirimWa">Kirim</button>
        <button type="button" class="btn btn-light btn-block rounded-pill px-4" data-dismiss="modal">Tutup</button>
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
  
    Swal.fire({
                title: 'Kalimat Undangan Tersalin.',
                text: 'Silahkan tempel/paste dan kirim ke tamu undangan.',
                icon: 'info',
                showConfirmButton: false,
                timer: 3500,
              })
}
</script>