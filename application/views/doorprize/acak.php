<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=base_url('assets/custom/css/doorprize.css') ?>?time=<?=time()?>">
    <title>Document</title>
</head>
<body>
    <section class="wrapping">
        <div class="wrapp__content" style="background-image: url(<?=base_url('assets/img/doorprize/frame/default.png') ?>)">
            <div class="bg__siluet flex_row">
                <div class="wrapping__text">
                    <div class="flex_col relative">
                        <h1 class="text__xl absolute">DOORPRIZE</h1>
                        <div class="wrapp__text_center">
                            <h2 class="text__l text-format" id="lblNama">PILIH PEMENANG</h2>
                            <span class="text__m" id="lblAlamat">Alamat/Keterangan</span>
                        </div>
                    </div>
                </div>
                <div class="wrapping__image">
                    <img src="./assets/DEFAULTIMG-HADIAH.png" alt=""  >
                </div>
				<button class="btn" id="btnMulai" onclick="mulai()">Pilih Pemenang</button>
				<button
					type="submit"
					class="btn btn-success hidden"
					id="btnBerhenti"
					onclick="berhenti()">BERHENTI</button>
            </div>
        </div>
    </section>

    <script>
        const nama = [
        <?php 
            foreach($tamus as $tamu) {
                echo '{ nama : "'.$tamu['nama'].'", alamat : "'.$tamu['alamat'].'"},';
            }
        ?>
        ];
    </script>
    <script src="<?= base_url('assets/custom/js/doorprize/scriptv3.js') ?>?time=<?=time()?>"></script>
</body>
</html>