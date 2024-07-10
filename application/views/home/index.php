<div class="content">
  
  
  <div class="text-center img-event">
    <a href="<?= base_url('seting') ?>">
        <img class="img-fluid" src="<?= base_url('assets/img/event/' . $event['poto']) ?> " alt="img">
    </a>
</div>
  
  

  <!--<div class="d-block text-center">-->
  <!--  <div class="box-manten shadow">-->
  <!--    <p id="wed"><?= $event['wedding'] ?></p>-->
  <!--    <h2><?= $event['nama'] ?></h2>-->
  <!--    <p id="dt"><?= $this->m_time->longDate($event['tgl']) ?></p>-->
  <!--  </div>-->
  <!--</div>-->

  <!--<div class="menu-box">-->
  <!--  <div class="row">-->
  <!--    <div class="col-sm-3 col-6">-->
  <!--      <a href="<?= base_url('tamu') ?>" class="menu">-->
  <!--        <span class="icon-menu"><i class="far fa-book-alt"></i></span>-->
  <!--        <p>Data Tamu</p>-->
  <!--      </a>-->
  <!--    </div>-->
  <!--    <div class="col-sm-3 col-6">-->
  <!--      <a href="<?= base_url('tamu/report') ?>" class="menu">-->
  <!--        <span class="icon-menu"><i class="far fa-users"></i></span>-->
  <!--        <p>Kehadiran</p>-->
  <!--      </a>-->
  <!--    </div>-->
  <!--    <div class="col-sm-3 col-6">-->
  <!--      <a href="" class="menu" id="calScan">-->
  <!--        <span class="icon-menu"><i class="far fa-qrcode"></i></span>-->
  <!--        <p>Checkin</p>-->
  <!--      </a>-->
  <!--    </div>-->
  <!--    <div class="col-sm-3 col-6">-->
  <!--      <a href="<?= base_url('souvenir') ?>" class="menu">-->
  <!--        <span class="icon-menu"><i class="far fa-hand-holding-heart"></i></span>-->
  <!--        <p>Souvenir</p>-->
  <!--      </a>-->
  <!--    </div>-->

  <!--    <div class="col-sm-3 col-6">-->
  <!--      <a href="<?= base_url('comment') ?>" class="menu">-->
  <!--        <span class="icon-menu"><i class="far fa-comments-alt"></i></span>-->
  <!--        <p>Ucapan/RSVP</p>-->
  <!--      </a>-->
  <!--    </div>-->
  <!--    <div class="col-sm-3 col-6">-->
  <!--      <a target="_blank" href="<?= base_url('welcome') ?>" class="menu">-->
  <!--        <span class="icon-menu"><i class="far fa-desktop"></i></span>-->
  <!--        <p>Layar Sapa</p>-->
  <!--      </a>-->
  <!--    </div>-->
    
      <!--<div class="col-sm-3 col-6">-->
      <!--  <a href="<?= base_url('doorprize') ?>" class="menu">-->
      <!--    <span class="icon-menu"><i class="fa fa-gift"></i></span>-->
      <!--    <p>Doorprize</p>-->
      <!--  </a>-->
      <!--</div>-->
  <!--  </div>-->
  <!--</div>-->
  
  
  <style>
    .menu-img {
        width: 90%; /* Sesuaikan lebar gambar sesuai kebutuhan */
        height: auto; /* Biarkan tinggi otomatis agar tidak terdistorsi */
        max-width: 100%; /* Pastikan gambar tidak melebihi lebar container */
    }

    .menu-text {
        font-size: 2px; /* Sesuaikan ukuran teks sesuai kebutuhan */
        text-align: center; /* Sesuaikan alignment teks sesuai kebutuhan */
        margin: 0; /* Hapus margin bawaan agar tata letak lebih konsisten */
    }


.card2 {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #f2f2f2;
    background-clip: border-box;
    /*border: 1px solid rgba(0,0,0,.125);*/
    border-radius: 2rem;
}
</style>

  

 
<div class="d-block text-center">
    <div class="box-manten shadow">
        <p id="wed"><?= $event['wedding'] ?></p>
        <h2><?= $event['nama'] ?></h2>
        <p id="dt"><?= $this->m_time->longDate($event['tgl']) ?></p>
    </div>
</div>

<div class="card2 menu-box">
    <div class="row">
        <?php
        $menuItems = [
            ['url' => base_url('tamu'), 'img' => 'DATATAMU.png', 'text' => 'Data Tamu'],
            ['url' => 'class="menu" id="calScan"' , 'img' => 'CHECKIN.png', 'text' => 'Check-In', 'id' => 'calScan'],
            ['url' => base_url('tamu/report'), 'img' => 'KEHADIRAN.png', 'text' => 'Kehadiran'],
            ['url' => base_url('souvenir'), 'img' => 'SOUVENIR.png', 'text' => 'Souvenir'],
            ['url' => base_url('comment'), 'img' => 'RSVP.png', 'text' => 'Ucapan'],
            ['url' => base_url('welcome'), 'img' => 'LAYARSAPA.gif', 'text' => 'Layar Sapa', 'target' => '_blank'],
            // ['url' => base_url('doorprize'), 'img' => 'menu_doorprize.jpg', 'text' => 'Doorprize'],
        ];

        foreach ($menuItems as $menuItem) :
        ?>
            <!--<div class="col-sm-3 col-6">-->
                <div class="col col-4">
    <a href="<?= $menuItem['url'] ?>" class="menu" <?php echo isset($menuItem['target']) ? 'target="' . $menuItem['target'] . '"' : ''; ?>>
        <img src="Https://app.buktamdigital.my.id/assets/img/design/<?= $menuItem['img'] ?>" class="icon-menu-img menu-img" alt="<?= $menuItem['text'] ?>"style="margin-bottom: 10px;">
        <p class="menu-text"><?= $menuItem['text'] ?></p>
    </a>
</div>

        <?php endforeach; ?>
    </div>
</div>







  <div class="row mt-3">
    <div class="col-8">
      <!--<h6 class="ml-3 content-title">List Tamu Hadir</h6>-->
      
      <h7 class="ml-2 content-title">
  <img src="https://app.buktamdigital.my.id/assets/img/design/guest-list.png" alt="Guest Icon" style="width: 22px; height: 22px; margin-right: 3px;">
  List Tamu Hadir
</h7>
     </div>
    
    <div class="col-4">
      <span class="badge tblKode mr-3" data-kode="<?= $event['kode'] ?>"></span>
    </div>
  </div>
  
  
  
  
  
  
  <!--<div class="count-guest">-->

  <!--  <div class="count-comment">-->
  <!--    <span class="text-bold" id="jmlu">0</span>-->
  <!--    <span class="lbl">Tamu Undangan</span>-->
  <!--  </div>-->

  <!--  <div class="count-comment">-->
  <!--    <span class="text-bold" id="jmlh">0</span>-->
  <!--    <span class="lbl">Tamu Hadir</span>-->
  <!--  </div>-->

  <!--  <div class="count-comment">-->
  <!--    <span class="text-bold" id="jmluh">0</span>-->
  <!--    <span class="lbl">Jumlah Tamu Hadir</span>-->
  <!--  </div>-->

  <!--</div>-->
  
  
  
  
  
  
  
  

  <div class="card mt-1 mb-3 shadow-sm">
    <div class="card-header">
      <div class="count-guest">
        <span>Tamu Undangan: <span class="text-bold" id="jmlu">0</span> | </span>
        <span>Hadir: <span class="text-bold" id="jmlh">0</span></span>
        <span class=""> | Tamu Masuk (<span class="text-bold" id="jmluh">0</span> Orang)</span>
      </div>
    </div>
    <div class="card-body">
      <div class="list-table">
        <div class="search">
          <input type="text" placeholder="search..." id="pencarian">
          <i class="fa fa-search"></i>
        </div>
        <ul>
          <li><span class="sub-title">Sedang memuat data...</span></li>
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
<div class="modal fade" id="moadlListCekin" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="moadlListCekinLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="moadlListCekinLabel">Check-in Tamu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <style>
  .btn {
    background: #261b6f;
    border-radius: 999px;
    box-shadow: #5E5DF0 0 10px 20px -10px;
    box-sizing: border-box;
    color: #FFFFFF;
    cursor: pointer;
    font-family: Inter,Helvetica,"Apple Color Emoji","Segoe UI Emoji",NotoColorEmoji,"Noto Color Emoji","Segoe UI Symbol","Android Emoji",EmojiSymbols,-apple-system,system-ui,"Segoe UI",Roboto,"Helvetica Neue","Noto Sans",sans-serif;
    font-size: 16px;
    font-weight: 700;
    line-height: 24px;
    opacity: 1;
    outline: 0 solid transparent;
    padding: 8px 18px;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    width: 100%;
    word-break: break-word;
    border: 0;
        }
        
    .btnclose {
        
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 6px 14px;
    font-family: -apple-system, BlinkMacSystemFont, 'Roboto', sans-serif;
    border-radius: 6px;
    border: none;
    background: #6E6D70;
    box-shadow: 0px 0.5px 1px rgba(0, 0, 0, 0.1), inset 0px 0.5px 0.5px rgba(255, 255, 255, 0.5), 0px 0px 0px 0.5px rgba(0, 0, 0, 0.12);
    color: #DFDEDF;
    width: 100%;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    
    }
</style>

      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">

            <div class="text-left">
              <div class="text-12">Pilih Salah satu Cara Check-in</div>
              <button class="btn btn-sm btn-outline-custom m-1" id="scanQrcode"><i class="far fa-qrcode"></i> Scan
                QR-Code</button><br>
              <button class="btn btn-sm btn-outline-custom m-1" id="cariTamuHome"><i class="fa fa-search"></i> Cari Tamu
                Terdaftar</button>
              <button class="btn btn-sm btn-outline-custom m-1" id="manualHome"><i class="fas fa-user-plus"></i> Input Tamu
                Baru</button>
                <button class="btn btn-sm btn-outline-custom m-1" id="scanTamuHome"><i class="fas fa-scanner"></i> Scanner External</button>
            </div>

          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btnclose btn-light rounded-pill text-14 px-4 closeModal"
          data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="setHadirCari" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="setHadirCariLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="setHadirCariLabel">Tamu Terdaftar</h5>
        <button type="button" class="close closedModalCari" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <h5 id="hasilNamaTamu" class="mb-3">Nama Tamu</h5>
        <input type="text" id="hasilIdTamu" style="display:none">

        <div class="form-group">
          <label for="hasilJmlTamu">Jumlah tamu</label>
          <div class="input-group">
            <input type="number" id="hasilJmlTamu" class="form-control rounded">
            <div class="input-group-append">
              <button class="btn btn-outline-custom" id="hasilCheckinTamu">Check-in</button>
            </div>
          </div>
        </div>


        <div class="mt-4">
          <button data-dismiss="modal" class="btn btn-sm btn-outline-secondary">Cancel</button>
        </div>

      </div>

    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modaldwlApk" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="modaldwlApkLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaldwlApkLabel">ANDROID APPS DOWNLOAD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">

            <div class="text-center">
              <h6>SILAHKAN DOWNLOAD APLIKASI ANDROID UNTUK SCAN QR-CODE TAMU</h6>
              <button class="btn btn-outline-custom" id="dwlApk"><i class="far fa-download"></i> ANDROID APPS</button>
            </div>

          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill text-14 px-4 closeModal"
          data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal Scan External-->
<div class="modal fade" id="scannerExt" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="pencarianTamuLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pencarianTamuLabel">Checkin Tamu</h5>&nbsp;
		<span data-toggle="tooltip" data-placement="top" title="Pastikan scanner anda sudah mendukung auto enter setelah qrcode dipindai.">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
				<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
				<path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94"/>
			</svg>
		</span>
        <button type="button" class="close closedModalCari" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control" id="scanNamaTamu" placeholder="Tap box untuk mendapatkan fokus scanner">
          <span class="mencariData2 text-info text-9">Mencari data.....</span>
        </div>
         <div>
         <img src="https://i.pinimg.com/originals/be/ed/ce/beedce7109ab7228d1c6f4d028f30b08.gif" alt="Girl in a jacket" width="100%" height="auto">
        </div>

        <hr>

        <div class="menu-pencarian2"></div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill text-14 px-4 closeModal closedModalCari"
          data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalJumlah" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalJumlahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalJumlahLabel">Jumlah Tamu Hadir</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-4">
          <label for="jumlaht" class="text-custom">Jumlah Tamu</label>
          <input type="number" class="form-control" id="jumlaht" value="1" placeholder="input jumlah" required>
        </div>

        <input type="text" id="id" style="display: none;">

        <div class="form-group">
          <button type="button" class="btn btn-block btn-custom rounded-pill" onclick="jumlahTamuHadir()">Save</button>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Modal Foto Display -->
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
</div>


<?php $this->load->view('template/footer'); ?>


<script>
var UrLBase = '<?= base_url() ?>';
$('[data-toggle="tooltip"]').tooltip()
</script>


<script src="<?= base_url('assets/custom/js/event.js?v=' . fileatime('assets/custom/js/event.js')) ?>"></script>
<script src="<?= base_url('assets/custom/js/qrcodelib.js?v=' . fileatime('assets/custom/js/qrcodelib.js')) ?>"></script>
<script src="<?= base_url('assets/custom/js/webcodecamjs.js?v=' . fileatime('assets/custom/js/webcodecamjs.js')) ?>">
</script>
<script src="<?= base_url('assets/custom/js/home1.js?v=' . fileatime('assets/custom/js/home1.js')) ?>"></script>

<script>
    <?php if($scan == 'show') { ?>
    $('.modal#scannerExt').modal('show');
    <?php } ?>
    $('#cariTamuHome').on('click', function (e) {
      e.preventDefault();
      $('.modal#moadlListCekin').modal('hide');
      $('.modal#pencarianTamu').modal('show');
      $('.modal#pencarianTamu .menu-pencarian').addClass('hide');
      $(".modal#pencarianTamu .mencariData").fadeOut();
    })
    
    $('.modal#pencarianTamu').on('shown.bs.modal', function () {
      $('.modal#pencarianTamu input#cariNamaTamu').trigger('focus')
      $('.modal#pencarianTamu input#cariNamaTamu').val("");
      $('.modal#pencarianTamu .menu-pencarian').addClass('hide');
    })

$('#manualHome').on('click', function (e) {
      e.preventDefault();
      $('.modal#modalManual #formInput input').val('');
      $('.modal#modalManual #formInput input#jml').val(1);
      $('.modal#modalManual').modal('show');
    })

$('.modal#modalManual .modal-body .btnJmlTamu').on('click', function(e) {
  e.preventDefault();
  var tx = $(this).text();
  $('.modal#modalManual .modal-body .btnJmlTamu').removeClass('bg-primary');
  $(this).addClass('bg-primary');
  $('.modal#modalManual .modal-body input#jml').val(tx);
})
</script>
