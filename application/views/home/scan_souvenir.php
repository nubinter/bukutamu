<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/custom/css/checkin.css') ?>">
    <title>Souvenir - Bukutamu Digital</title>
</head>
<body>
    <div class="wrapp_content">
        <div class="container">
            <div id="area_camera">
                <div id="reader"></div>
                <br />
                <center>
                    <button id="switchCameraButton" class="style_btn_submit">Switch Camera</button>
                    <button id="fullscreenButton" class="style_btn_submit">Fullscreen</button>
                    <button id="stopCameraButton" class="style_btn_submit" data-status="1">Stop Camera</button>
                    <br />
                    <div class="select-camera">
                        <select id="cameraSelect">
                            <option>Pilih Kamera</option>
                        </select>
                    </div>
                </center>
            </div>
        </div>
    </div>
    
    <script src="<?= base_url('assets/custom/js/jquery.min.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script>
        var UrLBase = '<?= base_url() ?>';
        const fullscreenButton = document.getElementById('fullscreenButton');
        const scan = document.getElementById('area_camera');
        
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
        // Mengatur elemen kamera sesuai dengan lebar dan tinggi layar
        const area_camera = document.getElementById('area_camera');
        area_camera.style.width = screenWidth + 'px';
        area_camera.style.height = screenHeight+110 + 'px';
        var devices;
        var cameraId;
        var scanner;
        var ratio = window.devicePixelRatio || 1;
        function initializeScanner(cameraId) {
            const videoConstraints = {
                deviceId: cameraId,
                width: screenWidth,
                height: screenHeight,
            };
            scanner = new Html5Qrcode('reader', false);
            scanner.start(cameraId, {
                fps: 10,
                qrbox: Math.min(screenWidth, screenHeight) * 0.8,
                aspectRatio: 1.7777778,
                videoConstraints: videoConstraints
            }, (decodedText) => {
                sendAjaxRequest(decodedText)
                .then(response => {
                    console.log('AJAX request successful', response);
                })
                .catch(error => {
                    console.error('AJAX request failed', error);
                });
            }, (errorMessage) => {
                // parse error, ignore it.
            });
        }
        
        Html5Qrcode.getCameras().then(deviceList => {
            devices = deviceList;
            var cameraSelect = document.getElementById('cameraSelect');
            for (var i = 0; i < devices.length; i++) {
                var option = document.createElement('option');
                option.value = devices[i].id;
                option.text = devices[i].label;
                cameraSelect.appendChild(option);
            }
            if (devices && devices.length >= 1) {
                cameraId = devices[0].id;
                initializeScanner(cameraId);  
            }
            cameraSelect.addEventListener('change', function () {
                cameraId = this.value;
                scanner.stop();
                initializeScanner(cameraId);
            });
        }).catch(err => {
            // Handle error
        });
        
        document.getElementById('switchCameraButton').addEventListener('click', function () {
            if (devices && devices.length >= 1) {
                // Temukan indeks kamera saat ini
                const currentIndex = devices.findIndex(device => device.id === cameraId);
                // Beralih ke kamera berikutnya
                if (currentIndex !== -1) {
                    const nextIndex = (currentIndex + 1) % devices.length;
                    cameraId = devices[nextIndex].id;
                    scanner.stop();
                    initializeScanner(cameraId);
                }
            }
        });
        
                
        document.getElementById('stopCameraButton').addEventListener('click', function () {
            // Temukan indeks kamera saat ini
            const currentIndex = devices.findIndex(device => device.id === cameraId);
            cameraId = devices[currentIndex].id;
            const status = $(this).data('status');
            if(status == 1) {
                scanner.stop();
                $(this).data('status', 0);
                $(this).html('Start Camera');
            } else {
                initializeScanner(cameraId);
                $(this).data('status', 1);
                $(this).html('Stop Camera');
            }
            //initializeScanner(cameraId);
        });

        function sendAjaxRequest(decodedText) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: UrLBase + 'souvenir/checkin',
                    type: 'POST',
                    dataType: 'JSON',
                    cache: false,
                    data: {
                        barcode: decodedText
                    },
                    beforeSend: function() {
                        scanner.pause();
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.kode == 1) {
                            showSuccessAlert(response.pesan);
                            return false;
                          }
                          if (response.kode == 3) {
                            showErrorAlert(response.pesan);
                            return false;
                          }
                    
                          if (response.kode == 0) {
                            console.log('ok');
                            return false;
                          }
                    
                          if (response.kode == 2) {
                            showInfoAlert(response.pesan);
                            return false;
                          }
                    },
                    error: function(xhr, status, error) {
                        reject(error);
                    }
                });
            });
        }
 
 
        
        function showErrorAlert(pesan) {
          Swal.fire({
            title: 'Maaf!',
            text: pesan,
            icon: 'error',
            showConfirmButton: true,
            position: 'top-center'
          }).then((result) => {
              if (result.isConfirmed) {
                  scanner.resume();
              }
            })
        }
        
        // Fungsi SweetAlert2 untuk pesan sukses
        function showSuccessAlert(pesan) {
          Swal.fire({
            title: 'Halo!',
            text: pesan,
            icon: 'success',
            showConfirmButton: true,
            position: 'top-center'
          }).then((result) => {
              if (result.isConfirmed) {
                  scanner.resume();
              }
            })
        }
        
        // Fungsi SweetAlert2 untuk pesan sukses
        function showInfoAlert(pesan) {
          Swal.fire({
            title: 'Maaf!',
            text: pesan,
            icon: 'info',
            showConfirmButton: true,
            position: 'top-center'
          }).then((result) => {
              if (result.isConfirmed) {
                  scanner.resume();
              }
            })
        }
    </script>
</body>
</html>