<!doctype html>
<html lang="en">

<head>

  <!-- Bootstrap CSS -->

  <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
  <!--<link rel="stylesheet"
    href="<?= base_url('assets/custom/css/style.css?v=' . filemtime('assets/custom/css/style.css')) ?>">-->
  <style>
	@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,700&display=swap');
	body {

	  overflow-x           : hidden;

	  font-family: 'Poppins', sans-serif;

	  background-color: #ffffff;

	}
	.container-page {

	  max-width       : 600px;

	  background-color: #ffffff;

	  padding         : 0px;

	  border-left: 1px solid #e3e3e3;

	  border-right: 1px solid #e3e3e3;

	}
	#areaDownloadQr .qrEvent {

	text-align: left;

	}



	#areaDownloadQr .qrEvent div {

	  color: #261b6f;

	}



	#areaDownloadQr .qrEvent .qrWeding {

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

		font-size: 11px;

	  }



	  #areaDownloadQr .qrEvent .qrManten {

		font-size: 15px;

	  }



	  #areaDownloadQr .qrEvent .qrTgl {

		font-size: 12px;

	  }

	}





	#areaDownloadQr .qrTamu {

	  text-align: left;

	  margin-top: 20px;

	  }



	#areaDownloadQr .qrTamu div {

	  color: #202020;

	  font-size: 12px;

	  }



	#areaDownloadQr .qrTamu #qrTamuNama {

	  font-size: 19px;

	  font-weight: 600;

	  }



	#areaDownloadQr .qrTamu #qrTamuAlamat {

	color: #0a0a0a;

	font-size: 16px;

	}









	  @media (max-width: 576px) {

		#areaDownloadQr .qrTamu div {

		font-size: 12px;

		}



		

		#areaDownloadQr .qrTamu #qrTamuNama {

		font-size: 15px;
		page-break-inside: avoid;
		page-break-before: auto;

		}

		

		#areaDownloadQr .qrTamu #qrTamuAlamat {

		font-size: 13px;

		}

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
	
	  .badge-custom {
		  font-size: 20px;
		  
		  color: #fff;

		  background-color: #ff7c00;

		  border-radius: 0rem;

		  padding-left: 10px;

		  padding-right: 10px;

		}
  
	<!--@page { margin: 0px; }-->
  </style>
</head>

<body>

  <div class="container container-page">
	  
	  <div id="areaDownloadQr" class="text-center">
<div class="vip-badge-container">
  <img class="img-fluid mb-3" src="<?= base_url('assets/img/event/' . $event['poto']) ?>" alt="img">
  	  		<?php 
			if($tamu['vip'] == 1) {
		?>
			<div class="vip-badge">
				<h1><span class="badge-custom">VIP</span></h1>
			</div>
		<?php 
			}
		?>
</div>
  <table style="width: 100%;">
	<tr>
		<td style="width: 50%; padding: 5px;">
	<div class="qrEvent">
	  <div class="qrWeding"><?= $event['wedding'] ?></div>
	  <div class="qrManten"><?= $event['nama'] ?></div>
	  <div class="qrTgl"><?= $this->m_time->longDate(date('Y-m-d', strtotime($event['tgl']))) ?></div>
	  <div class="qrTamu">
		<div>Kepada Yth.</div>
		<div>Bapak/Ibu/Saudara/i:</div>
		<div id="qrTamuNama"><?= $tamu['nama'] ?></div>
		<div class="ml-3">di/sebagai</div>
		<div id="qrTamuAlamat"><?= $tamu['alamat'] ?></div>

	  </div>
	</div>
	</td>
	<td style="width: 50%;">
	<div class="col-6 text-center">
	  <img class="img-fluids mb-1 d-inline-block" width="150" src="<?= base_url('assets/img/page/LOGO-BIRU.png') ?>"
		alt="qr">
	  <img src="<?= $qr ?>" alt="qr" id="imgqr" width="150" height="150">
	</div>
	</td>
	</tr>
	</table>
	  <img class="img-fluid mb-3" src="<?= base_url('assets/img/page/TEXT-BAWAH-QR1.png') ?>" alt="img">
</div>
</div>
</body>
</html>