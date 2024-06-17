<div class="content">


  <div class="box-count-comment">


    <div class="count-comment">
      <span class="count-2" id="hadir">0</span>
      <span class="lbl-2">Souvenir Diambil</span>
    </div>

  </div>


  <div class="row mt-3">
    <div class="col-12">
      <!--<h6 class="ml-3 content-title">Penukaran Souvenir</h6>-->
      
      <h6 class="ml-3 content-title">
      <img src="https://app.buktamdigital.my.id/assets/img/design/gift-box.png" alt="Data Tamu" style="width: 27px; height: 27px; margin-right: 5px;">
       Gift/Souvenir
      </h6>
      
    </div>

  </div>

  <div class="card mt-1 mb-3 shadow-sm">
    <div class="card-header">
      <div class="d-flex">
        <span class="badge tbl mr-3" id="export"><i class="far fa-file-download"></i> Export PDF</span>
        <span class="badge tbl mr-3" id="qrSouvenir"><i class="fas fa-qrcode"></i> Scan QR Code</span>
        <span class="badge tbl mr-3" id="qrExt"><i class="fas fa-scanner"></i> Scan Ext</span>
      </div>
    </div>
    <div class="card-body">
      <div class="load-comment">
        <ul>
          <li>
            <span class="title">Loading...</span>
          </li>
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
.webcamQr {
  text-align: center;
  padding: 5px;
  width: 100%;
  height: 100%;
}

.webcamQr .well {
  position: relative;
  display: inline-block;
}

.webcamQr #webcodecam-canvas {
  background-color: #272727d2;
  width: 100%;
  height: 100%;
}

.webcamQr .lbl {
  position: absolute;
  opacity: 0.5;
  top: 0px;
  left: 0;
  right: 0;
  margin-top: 120px;
  font-size: 20px;
  color: #ad7a13;
}


.webcamQr .warning {
  position: absolute;
  opacity: 0.8;
  top: 0;
  left: 0;
  right: 0;
  margin-top: 160px;
  font-size: 20px;
  color: #ff0000;
  font-weight: bolder;
}

.webcamQr .scanner-laser {
  position: absolute;
  margin: 35px;
  height: 30px;
  width: 30px;
  opacity: 0.5;
}

.webcamQr .laser-leftTop {
  top: 0;
  left: 0;
  border-top: solid #ad7a13 5px;
  border-left: solid #ad7a13 5px;
}

.webcamQr .laser-leftBottom {
  bottom: 0;
  left: 0;
  border-bottom: solid #ad7a13 5px;
  border-left: solid #ad7a13 5px;
}

.webcamQr .laser-rightTop {
  top: 0;
  right: 0;
  border-top: solid #ad7a13 5px;
  border-right: solid #ad7a13 5px;
}

.webcamQr .laser-rightBottom {
  bottom: 0;
  right: 0;
  border-bottom: solid #ad7a13 5px;
  border-right: solid #ad7a13 5px;
}
</style>

<!-- Modal -->
<div class="modal fade" id="scanQr" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
  aria-labelledby="scanQrLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">



            <div class="webcamQr">
              <div class="well" style="position: relative;display: inline-block;">
                <canvas id="webcodecam-canvas"></canvas>
                <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>

                <span class="lbl">SCAN QR</span>
                <span class="warning"></span>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="modal-footer">
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <select class="form-control" id="camera-select"></select>
            </div>
          </div>

          <div class="col-6">
            <button type="button" class="btn btn-secondary rounded-pill px-4 closeModal"
              data-dismiss="modal">Tutup</button>
          </div>
        </div>

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
        <h5 class="modal-title" id="pencarianTamuLabel">Scanner External</h5>&nbsp;
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
          <input type="text" class="form-control" id="scanNamaTamu" placeholder="Scan dgn Barcode Scanner">
          <span class="mencariData2 text-info text-9">Mencari data.....</span>
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


<?php $this->load->view('template/footer'); ?>


<script>
var UrLBase = '<?= base_url() ?>';
$('[data-toggle="tooltip"]').tooltip()
</script>

<script src="<?= base_url('assets/custom/js/qrcodelib.js?v=' . fileatime('assets/custom/js/qrcodelib.js')) ?>"></script>
<script src="<?= base_url('assets/custom/js/webcodecamjs.js?v=' . fileatime('assets/custom/js/webcodecamjs.js')) ?>">
</script>
<script src="<?= base_url('assets/custom/js/souvenir.js?v=' . fileatime('assets/custom/js/souvenir.js')) ?>"></script>