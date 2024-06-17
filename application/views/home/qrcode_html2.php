<link rel="stylesheet"
  href="<?= base_url('assets/custom/css/camera2.css?v=' . filemtime('assets/custom/css/camera2.css')) ?>">

<script src="https://unpkg.com/html5-qrcode" type="text/javascript">
<!--<script src="<?= base_url('assets/custom/js/html5qr.js?v=' . fileatime('assets/custom/js/html5qr.js')) ?>">
</script>-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

<div class="content text-center" id="content">

  <div class="container area-scanqr" id="area-scanqr">

    <div class="row">
      <div class="col-12 mt-5">
        <div id="reader">

        </div>
      </div>
    </div>
     <br />
     <button id="switchCameraButton">Switch Camera</button>
     <button id="fullscreenButton">Fullscreen</button>
  </div>
 

  <div class="container area-jumlah-tamu mt-5">
    <div class="row">
      <div class="col-12">
          <?php 
          
          ?>
        <label for="jmlTamu">Jumlah Tamu</label>
        <div class="input-group">
          <input type="number" id="jmlTamu" class="form-control rounded">
          <div class="input-group-append">
            <button class="btn btn-outline-custom rounded" id="btnJml">Submit</button>
          </div>
        </div>
        <input type="text" id="idTamu" style="display:none">
      </div>
    </div>
  </div>



</div>

<?php $this->load->view('template/footer'); ?>


<script>
var UrLBase = '<?= base_url() ?>';

$(document).ready(function() {
    $('.area-jumlah-tamu').hide();
    $('.area-jumlah-tamu input#jmlTamu').val("");
    $('.area-jumlah-tamu input#idTamu').val("");
})
</script>


<script>

/*const scanner = new Html5QrcodeScanner('reader', {
  qrbox: {
    width: 200,
    height: 200,
  },
  fps: 10,
  aspectRatio: 1.7777778
});
scanner.render(success, error);*/
const fullscreenButton = document.getElementById('fullscreenButton');
const scan = document.getElementById('content');

fullscreenButton.addEventListener('click', () => {
    if (scan.requestFullscreen) {
        scan.requestFullscreen();
    } else if (scanner.mozRequestFullScreen) { // Untuk Firefox
        scan.mozRequestFullScreen();
    } else if (scanner.webkitRequestFullscreen) { // Untuk Chrome, Safari, dan Opera
        scan.webkitRequestFullscreen();
    } else if (scanner.msRequestFullscreen) { // Untuk Internet Explorer dan Edge
        scan.msRequestFullscreen();
    }
});

const screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
const screenHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
var devices;
var cameraId;
var scanner;
var ratio = window.devicePixelRatio || 1;
var w = screen.width * ratio;
var h = screen.height * ratio;
function initializeScanner(cameraId) {
    scanner = new Html5Qrcode('reader', false);
    scanner.start(cameraId, {
        fps: 10,
        qrbox: 250,
        aspectRatio: h/w
    }, (decodedText) => {
        success(decodedText); // do something when code is read
    }, (errorMessage) => {
        // parse error, ignore it.
    });
}

Html5Qrcode.getCameras().then(deviceList => {
    devices = deviceList;
    if (devices && devices.length >= 1) {
        cameraId = devices[0].id;
        initializeScanner(cameraId);
    }
}).catch(err => {
    // Handle error
});

document.getElementById('switchCameraButton').addEventListener('click', function () {
    if (devices && devices.length >= 1) {
        cameraId = (cameraId === devices[0].id) ? devices[1].id : devices[0].id;
        scanner.stop();
        initializeScanner(cameraId);
    }
});

function success(result) {
  $.ajax({
    url: UrLBase + 'home/chekcode',
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
        $("#LoadingPage").fadeOut();
        $('#html5-qrcode-button-camera-stop').click();

        $('.area-scanqr').hide();
        $('.area-jumlah-tamu input#jmlTamu').val(1);
        $('.area-jumlah-tamu input#idTamu').val(respon.idt);
        $('.area-jumlah-tamu input#jmlTamu').focus();
        $('.area-jumlah-tamu').show();
        return false;
      }
      if (respon.kode == 3) {
        $.toast({
          heading: 'ERROR',
          text: respon.pesan,
          showHideTransition: 'slide',
          icon: 'error',
          loaderBg: '#cccc10',
          position: 'top-center'
        });
        setTimeout(() => {
          $('#html5-qrcode-button-camera-stop').click();
        }, 1000);
        return false;
      }

      if (respon.kode == 0) {
        console.log('ok');
        return false;
      }

      if (respon.kode == 2) {
        $.toast({
          heading: 'Terimakasih',
          text: respon.pesan,
          showHideTransition: 'slide',
          icon: 'success',
          loaderBg: '#cccc10',
          position: 'top-center'
        });
        setTimeout(() => {
          $('#html5-qrcode-button-camera-stop').click();
        }, 1000);
        return false;
      }
    }
  })
}

function error(err) {
  //console.error(err);
}



$('.area-jumlah-tamu #btnJml').on('click', function(e) {
  e.preventDefault();
  var jml = $('.area-jumlah-tamu input#jmlTamu').val();
  var id = $('.area-jumlah-tamu input#idTamu').val();
  if (jml == "" || jml == null) {
    $('.area-jumlah-tamu input#jmlTamu').focus();
    return false;
  }

  $.ajax({
    url: UrLBase + 'home/jumlahTamu',
    type: "POST",
    dataType: "JSON",
    data: {
      jml: jml,
      id: id
    },
    cache: false,
    success: function(respon) {
      if (respon.kode == 1) {
        $.toast({
          heading: 'SELAMAT DATANG',
          text: respon.pesan,
          showHideTransition: 'slide',
          icon: 'success',
          loaderBg: '#cccc10',
          position: 'top-center'
        });


        $('.area-scanqr').show();
        $('#html5-qrcode-button-camera-start').click();
        $('.area-jumlah-tamu').hide();
        $('.area-jumlah-tamu input#jmlTamu').val("");
        $('.area-jumlah-tamu input#idTamu').val("");
        return false;
      } else {
        $.toast({
          heading: 'ERROR',
          text: respon.pesan,
          showHideTransition: 'slide',
          icon: 'error',
          loaderBg: '#cccc10',
          position: 'top-center'
        });
        return false;
      }
    }
  })
})
</script>