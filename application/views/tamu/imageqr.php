<!doctype html>
<html lang="en">
<head>
	<style>
	  .custom-text {
		font-weight: bold;
		color: navy; /* Anda dapat mengganti "navy" dengan kode warna yang Anda inginkan */
	  }
	  .img-header {
		  border: solid 2mm black; border-radius: 5mm;              -moz-border-radius: 5mm;             
		}
	</style>
</head>
<body>

  <div class="container container-page">
		  <img class="img-header" src="/assets/img/event/<?= $event['poto'] ?>" alt="img" style="border-radius:50%; width: 102%;">
		  <br />
		  <div>
			<table style="width: 100%;">
				<tr>
					<td style="width: 50%;">
						<p style="font-size: 24px; color: blue;">
						<?= $event['wedding'] ?>
						<br />
						<span class="custom-text"><?= $event['nama'] ?></span><br />
						<?= $this->m_time->longDate(date('Y-m-d', strtotime($event['tgl']))) ?>
						</p>
						<br/>
						<p style="font-size: 20px;">Kepada Yth.<br />
						Bapak/Ibu/Saudara/i:<br />
						<span class="custom-text"><?= $tamu['nama'] ?></span><br />
						di/sebagai<br /></p>
						<?= $tamu['alamat'] ?><br />
						<?php 
							if($tamu['vip'] == 1) {
						?>
						<span class="badge badge-custom badges-vip">VIP</span>
						<?php 
							}
						?>
					</td>
					<td style="width: 50%;">
						<img width="250" src="/assets/img/page/LOGO-BIRU.png" alt="qr"><br />
						<img width="250" height="250" src="<?= $qr ?>" alt="qr" id="imgqr">
					</td>
				</tr>
			</table>
			<div>
			  <img src="/assets/img/page/TEXT-BAWAH-QR1.png" alt="img" style="width: 100%;">
			</div>
		  </div>
  </div>
</body>
</html>