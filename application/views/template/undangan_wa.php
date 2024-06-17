<!doctype html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<style>
		#areaDownloadQr {
		  border: 1px solid #0000;
		  border-bottom: 4px solid #0000;
		  height: 578px;
		}

		#areaDownloadQr .qrEvent {
			text-align: left;
			padding-left: 30px;
		}
		
		#areaDownloadQr .imgQr {
			text-align: left;
			padding-right: 30px;
		}

		#areaDownloadQr .qrEvent div {
		  color: black;
		}

		#areaDownloadQr .qrEvent .qrWeding {
		  margin-top: 5px;
		  font-size: 13px;
		}

		#areaDownloadQr .qrEvent .qrManten {
		  font-size: 20px;
		  font-weight: bolder;
		}

		#areaDownloadQr .qrEvent .qrTgl {
		  font-size: 15px;
		}

		@media (max-width: 576px) {
		  #areaDownloadQr .qrEvent .qrWeding {
			font-size: 15px;
		  }

		  #areaDownloadQr .qrEvent .qrManten {
			font-size: 20px;
		  }

		  #areaDownloadQr .qrEvent .qrTgl {
			font-size: 14px;
		  }
		}


		#areaDownloadQr .qrTamu {
		  text-align: left;
		  margin-top: 20px;
		  }

		#areaDownloadQr .qrTamu div {
		  color: #202020;
		  font-size: 14px;
		  }

		#areaDownloadQr .qrTamu #qrTamuNama {
		  font-size: 16px;
		  font-weight: 600;
		  }

		#areaDownloadQr .qrTamu #qrTamuAlamat {
		  color: #202020;
		  font-size: 14px;
		}
		#logo_brand {
		  border: 1px solid #0000;
		  background-color: black;
		  height: 53px;
		  font-size: 12px;
		  color: white;
		}
		.img_brand {
		  display: grid;
		  place-items: center;
		  margin-left: 20px;
		  margin-top: 10px;
		}
		.info_text {
		  margin-top: 6px;
		}
		
		.vip-badge-container {
		  position: relative;
		  display: inline-block; /* Important for positioning */
		}

		.vip-badge {
		  position: absolute;
		  top: 0;
		  right: 0;
		  z-index: 1; /* Ensure the badge appears above the image */
		}

		/* Additional CSS for badge styling (you can adjust this as needed) */
		.badge-custom {
		  color: #fff;
		  background-color: #FFD700;
		  padding-left: 10px;
		  padding-right: 10px;
		}
	
	</style>
</head>
<body>
	<div id="areaDownloadQr" class="text-center position-relative">
		<!--<div class="vip-badge-container position-relative">-->
		    <?php if ($tamu['vip'] == 1): ?>
			  <div class="vip-badge">
				<h3><span class="badge-custom position-absolute bg-warning font-weight-bolder" style="top:0;right:0;padding: 2px 8px;border:2px solid #000;color:#000;font-style:italic">VIP</span></h3>
			  </div>
			<?php endif; ?>
			<img class="img-responsive" src="<?=base_url('assets/img/event/'.$event['poto'])?>" alt="img">
		<!--</div>-->
		<div class="row">
			<div class="col-xs-4 qrEvent">
			<div class="vertical-center">
				<div class="qrWeding text-left"><?= $event['wedding'] ?></div>
				<div class="qrManten text-left"><?= $event['nama'] ?></div>
				<div class="qrTgl text-left"><?= $this->m_time->longDate(date('Y-m-d', strtotime($event['tgl']))) ?></div>
				<div class="qrTamu text-left">
					<!--<div>Kepada Yth.</div>-->
					<div>Dear,</div>
					<div id="qrTamuNama"><?=$tamu['nama']?></div>
					<div class="ml-3">Alamat/Keterangan:</div>
					<div id="qrTamuAlamat"><b><?=$tamu['alamat']?></b></div>
				</div>
			</div>
			</div>
			<div class="col-xs-8 imgQr">
				<img class="img-responsive" width="240" height="240" src="<?=$qr?>">
			</div>
		</div>
	</div>	
	<div id="logo_brand">
		<div class="row">
			<div class="col-xs-3 img_brand">
				<img class="img-responsive" width="350" height="150" src="<?=base_url('assets/img/page/logo.png')?>">
			</div>
			<div class="col-xs-9 info_text">
				HARAP TUNJUKKAN KARTU INI<br />
				SEBAGAI AKSES MASUK LOKASI ACARA!
			</div>
		</div>
	</div>
</body>
</html>
