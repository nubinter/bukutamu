<link rel="stylesheet"
  href="<?= base_url('assets/custom/css/camera2.css?v=' . filemtime('assets/custom/css/camera2.css')) ?>">


<script src="<?= base_url('assets/custom/js/html5qr.js?v=' . fileatime('assets/custom/js/html5qr.js')) ?>">
</script>
<div class="content text-center">

  <div class="container area-scanqr">

    <div class="row">
      <div id="camera-container" class="col-12 mt-5">
        <div id="reader">

        </div>
      </div>
		<!--<button id="fullscreenButton">Fullscreen</button>-->
      <div class="col-12 mt-3">
        <h5 id="resulte"></h5>
      </div>

    </div>

  </div>



</div>

<?php $this->load->view('template/footer'); ?>


<script>
var UrLBase = '<?= base_url() ?>';
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

<script>
    const scanner = new Html5QrcodeScanner('reader', {
      qrbox: {
        width: 200,
        height: 200,
      },
      fps: 10,
    });
    scanner.render(success, error);


function success(result) {
  $.ajax({
    url: UrLBase + 'souvenir/checkin',
    type: "POST",
    dataType: "JSON",
    cache: false,
    data: {
      barcode: result
    },
    beforeSend: function() {
      $("#LoadingPage").fadeIn();
      scanner.pause();
    },
    success: function(respon) {
      $("#LoadingPage").fadeOut();

      if (respon.kode == 1) {
        Swal.fire({
          icon: 'success',
          title: respon.pesan,
          text: respon.pesan1 ,
          showConfirmButton: false,
          timer: 7500
        });
        $('#resulte').html(respon.pesan1);
        setTimeout(() => {
          $('#html5-qrcode-button-camera-stop').click();
        }, 1500);
        setTimeout(() => {
          $('#resulte').html("");
        }, 7000);
        return false;
      }
      if (respon.kode == 3) {
        Swal.fire({
          icon: 'error',
          title: respon.pesan,
          text: respon.pesan1,
          showConfirmButton: false,
          timer: 5000
        });
        setTimeout(() => {
          $('#html5-qrcode-button-camera-stop').click();
          $('#resulte').html("");
        }, 2000);
        return false;
      }

      if (respon.kode == 0) {
        console.log('ok');
        return false;
      }

      if (respon.kode == 2) {
        Swal.fire({
          icon: 'error',
          title: respon.pesan,
          text: respon.pesan1,
          showConfirmButton: false,
          timer: 5000
        });
        setTimeout(() => {
          $('#html5-qrcode-button-camera-stop').click();
          $('#resulte').html("");
        }, 2000);
        return false;
      }
    }
  })
}


function error(err) {
}
</script>