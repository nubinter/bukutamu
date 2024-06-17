<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/custom/css/checkin.css') ?>">
    <title>Checkin - Bukutamu Digital</title>
</head>

<body>
    <div class="wrapp_content">
        <div class="container">
            <?php 
                if($detail == 'hide') {
                    $show_detail = 'display:none;';
                    $show_camera = 'display:block;';
                } else {
                    $show_detail = 'display:block;';
                    $show_camera = 'display:none;';
                }
            ?>
            <div class="wrapp_bg_content" style="<?=$show_detail?>">
                <div class="bg_content">

                    <div class="text_content_top">
                        <span class="text_style_S"><?= $event['wedding'] ?></span>
                        <h1 class="text_style_bold text-format"><?= $event['nama'] ?></h1>
                        <span class="text_style_S"><?= $this->m_time->longDate($event['tgl']) ?></span>
                    </div>
                    <?php if($tamu['vip']) { ?>
                    <div class="style_bg_vip">
                        <div class="text_style_bold" id="vip">VIP</div>
                    </div>
                    <?php } else { ?>
                    <div class="style_bg_vip" style="background:gray;">
                        <div class="text_style_bold" id="vip">REGULER</div>
                    </div>
                    <?php } ?>
                    <div class="wrapp_col_content">
                        <div class="text_content_bottom">
                            <div class="">
                                <div class="wrapp_text_content">
                                    <span class="text_style_S">Selamat Datang</span>
                                    <h1 class="text_style_bold text-format" id="nama_tamu"><?= $tamu['nama'] ?></h1>
                                </div>
                                <div class="wrapp_text_content">
                                    <span class="text_style_S">Alamat / Keterangan</span>
                                    <h1 class="text_style_bold text-format" id="alamat"><?= $tamu['alamat'] ?></h1>
                                </div>
                            </div>


                            <div class="flew_row">
                                <?php if($event['fitur_meja'] == 1) { ?>
                                <div class="wrapp_text_content">
                                    <span class="text_style_S">NO. MEJA</span>
                                    <h1 class="text_style_bold" id="no_meja"><?= $tamu['nomor_meja'] ?></h1>
                                </div>
                                <?php 
                                }
                                if($event['fitur_meja'] == 1 AND $event['fitur_ampao'] == 1) {
                                    echo '<div class="garis_tengah"></div>';
                                }
                                if($event['fitur_ampao'] == 1) {
                                ?>
                                <div class="wrapp_text_content">
                                    <span class="text_style_S">NO. AMPAO</span>
                                    <h1 class="text_style_bold" id="no_ampao"><?=$nomorAmpao?></h1>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="col_column">
                                <div class="style_text_tamu">
                                    <span class="text_style_S">Jumlah Tamu</span>
                                </div>
                                <div class="wrapp_text_content">
                                    <form action="#" class="form_input_value" id="formJumlahTamu">
                                        <input type="hidden" name="id_tamu" value="<?= $tamu['id'] ?>" id="id_tamu" />
                                        <div class="icon"></div>
                                        <select name="jumlah_tamu" class="select-number" id="jumlah_tamu">
                                            <option value="1" selected>1 TAMU</option>
                                            <option value="2">2 TAMU</option>
                                            <option value="3">3 TAMU</option>
                                            <option value="4">4 TAMU</option>
                                            <option value="5">5 TAMU</option>
                                            <option value="6">6 TAMU</option>
                                            <option value="7">7 TAMU</option>
                                            <option value="8">8 TAMU</option>
                                            <option value="9">9 TAMU</option>
                                            <option value="10">10 TAMU</option>
                                        </select>
                                        <input type="submit" class="style_btn_submit" value="CHECK IN" id="btnJml" />
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="style_footer">

                            <span>Powered by :</span>
                            <img src="<?= base_url('assets/img/page/LOGO_UTAMA_BUKUTAMU_DIGITAL.gif') ?>" alt="">
                        </div>
                    </div>

                </div>
            </div>

            <div id="area_camera" style="<?=$show_camera?>">
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
        } else if (scanner.mozRequestFullScreen) {
            scan.mozRequestFullScreen();
        } else if (scanner.webkitRequestFullscreen) {
            scan.webkitRequestFullscreen();
        } else if (scanner.msRequestFullscreen) {
            scan.msRequestFullscreen();
        }
    });

    const screenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    const screenHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
    // Mengatur elemen kamera sesuai dengan lebar dan tinggi layar
    const area_camera = document.getElementById('area_camera');
    area_camera.style.width = screenWidth + 'px';
    area_camera.style.height = screenHeight + 110 + 'px';
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
            <?php if($detail == 'hide') { ?>
            initializeScanner(cameraId);
            <?php } ?>
        }
        cameraSelect.addEventListener('change', function() {
            cameraId = this.value;
            scanner.stop();
            initializeScanner(cameraId);
        });
    }).catch(err => {
        // Handle error
    });

    document.getElementById('switchCameraButton').addEventListener('click', function() {
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


    document.getElementById('stopCameraButton').addEventListener('click', function() {
        // Temukan indeks kamera saat ini
        const currentIndex = devices.findIndex(device => device.id === cameraId);
        cameraId = devices[currentIndex].id;
        const status = $(this).data('status');
        if (status == 1) {
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
                url: UrLBase + 'home/chekcode',
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
                        $('.wrapp_bg_content').css('display', 'block');
                        $('#area_camera').css('display', 'none');
                        $('#nama_tamu').html(response.nama)
                        $('#alamat').html(response.alamat)
                        $('#id_tamu').val(response.idt)
                        $('#no_meja').html(response.nomor_meja)
                        $('#no_ampao').html(response.nomor_ampao)
                        if (response.vip == 1) {
                            $('#vip').html('VIP')
                            $('.style_bg_vip').css('background',
                                'linear-gradient(180deg, #FF8317 0%, #FF4700 100%)')
                            const audio = new Audio("../assets/img/music/beepVIP.mp3");
                            audio.play();
                        } else {
                            $('#vip').html('REGULER')
                            $('.style_bg_vip').css('background', 'gray')
                            const audio = new Audio("../assets/img/music/beepReguler.mp3");
                            audio.play();
                        }
                        return false;
                    }
                    if (response.kode == 3) {
                        showErrorAlert(response.pesan);
                        const audio = new Audio("../assets/img/music/error.mp3");
                        audio.play();
                        return false;
                    }

                    if (response.kode == 0) {
                        console.log('ok');
                        return false;
                    }

                    if (response.kode == 2) {
                        showInfoAlert(response.pesan);
                        const audio = new Audio("../assets/img/music/error.mp3");
                        audio.play();
                        return false;
                    }
                },
                error: function(xhr, status, error) {
                    const audio = new Audio("../assets/img/music/error.mp3");
                    audio.play();
                    reject(error);
                }
            });
        });
    }

    $('#formJumlahTamu').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: UrLBase + 'home/jumlahTamu',
            type: "POST",
            dataType: "JSON",
            data: $(this).serialize(),
            cache: false,
            success: function(respon) {
                if (respon.kode == 1) {
                    <?php if($detail == 'show') { 
                    if($tamu['vip']) { ?>
                    const audio = new Audio("../../../assets/img/music/beepVIP.mp3");
                    audio.play();
                    <?php } else { ?>
                    const audio = new Audio("../../../assets/img/music/beepReguler.mp3");
                    audio.play();
                    <?php } ?>
                    Swal.fire({
                        title: 'Success',
                        text: respon.pesan,
                        icon: 'success',
                        showConfirmButton: true,
                        position: 'top-center'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.replace(UrLBase + 'home');
                        }
                    })
                    <?php } else { ?>
                    $('#area_camera').css('display', 'block');
                    $('.wrapp_bg_content').css('display', 'none');
                    scanner.resume();
                    showSuccessAlert('Checkin sukses');
                    <?php } ?>
                    return false;
                } else {
                    showErrrAlert('Check in gagal, ulangi kembali.')
                    return false;
                }
            }
        })
    })

    function showErrorAlert(pesan) {
        Swal.fire({
            title: 'Error',
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
            title: 'Success',
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
            title: 'Informasi',
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
    document.addEventListener("DOMContentLoaded", function() {
        let ii = document.getElementById("nama_tamu");
        let textContent = ii.innerHTML;
        ii.innerHTML = enterAfterThreeWords(textContent);
    });

    function enterAfterThreeWords(sentence) {
        let words = sentence.split(" ");
        let result = "";

        for (let i = 0; i < words.length; i++) {
            if (i % 3 === 0 && i !== 0) {
                result += "<br>";
            }
            result += words[i] + " ";
        }
        return result.trim();
    }



    let sentenceB = document.getElementsByClassName("text-format");
    let ii = sentenceB;

    for (let p = 0; p < ii.length; p++) {
        let textContent = ii[p].innerHTML
        let resultDiv = ii[p]
        resultDiv.innerHTML = enterAfterThreeWords(textContent);
    }

    function enterAfterThreeWords(sentence) {
        let words = sentence.split(" ");
        let result = "";

        for (let i = 0; i < words.length; i++) {
            if (i % 3 === 0 && i !== 0) {
                result += "<br>";
            }
            result += words[i] + " ";
        }
        return result.trim();
    }
    resultDiv.innerHTML = enterAfterThreeWords(sentence);
    </script>
</body>

</html>