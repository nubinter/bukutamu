<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $judul ?></title>
</head>

<style>

#box {
  width: 33%;
  /* border: 1px solid whitesmoke; */
  display: inline;
}

.median {
  margin: 10px auto;
  border: 1px solid #fff;
  padding: 2px;
  width: auto;
  height: auto;
  position: relative;
  text-align: center;
  display: block;
}

#box img#hero {
  width: auto;
  height: 315px;
  /* position: absolute; */
  display: block;
}

img#qr {
  width: 125px;
  height: 125px;
  position: absolute;
  top: 66px;
  left: 42px;
  /* display: inline-block; */
}


.des {
  width: 200px;
  height: auto;
  position: absolute;
  top: 20px;
  
  text-align: center;
}

.des2 {
  width: 200px;
  height: auto;
  position: absolute;
  top: 200px;
  padding-bottom: 10px;
  text-align: center;
  left: 4px;
    margin: 0px;
}

.des p {
  margin: 0px;
  text-align: center;
  font-size: 11px;
  /*font-family: 'Poppins', sans-serif;*/
}


.des p#wed {
  font-size: 15px;
  margin-bottom: 5px;
  font-weight: bolder;
  color: #595959;
  /*font-family: 'Poppins', sans-serif;*/
}

.des p#manten {
  font-size: 14px;
  margin-bottom: 10px;
  font-weight: bolder;
  /*font-family: 'Poppins', sans-serif;*/
  color: #000;
}

.des2 p#manten {
  font-size: 14px;
  margin-bottom: 10px;
  font-weight: bolder;
  /*font-family: 'Poppins', sans-serif;*/
  color: #000;
}
  
  
.badge {
  margin: 0px;
  text-align: center;
  font-size: 11px;
  /*font-family: 'Poppins', sans-serif;*/
}  
</style>
<body>
  <?php 
	$no = 0;
	foreach ($tamu as $row) : 
  ?>
  <div id="box">
	  <div class="median" style="text-align: center;">
		<img id="hero" src="<?= base_url('assets/img/event/card.png')?>">
		<img id="qr" src="<?= base_url('assets/img/qr/'.$row['qr'].'.png')?>">
		<div class="des">
		  <p id="wed"><?= $event['wedding'] ?></p>
		  <p id="manten"><?= $event['nama'] ?></p>
		</div>
		<div class="des2">
			<div id="nama" style="margin-left: -200px; margin-bottom: 5px; font-weight: bold; word-wrap: break-word; max-width: 200px; font-size: <?= max(10, 18 - (2 * (count(explode(' ', $row['tamu'])) - 1))) ?>px;">
				<?= $row['tamu'] ?>
			</div>
			<?php if ($row['vip'] == 1) { ?>
				<div style="text-align: center; font-weight: bold; color: #000; background-color: #FECC15; border-radius: 10px; padding: 5px 10px; width: 25px; margin-left: -20px;">VIP</div>
			<?php } ?>
		</div>
	  </div>
   </div>
   <?php 
		$no++;
		if($no == 9) {
			echo '<br />';
		}
   endforeach; ?>
</body>
</html>