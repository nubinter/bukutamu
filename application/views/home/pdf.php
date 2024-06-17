<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
</head>

<style>
table#table {
  width: 100%;
  /* border: 1; */
  border-collapse: collapse;
}

#table thead {
  margin-top: 50px;
}

#table th {
  text-align: center;
  border: 1px;
  padding: 5px 1px;
}

#table td {
  text-align: left;
  border: 1px;
  padding: 5px 8px;
}

#table tr#header td {
  border: 0px;
  border-bottom: 1px solid #000;
  padding: 8px 2px;
}

#table tr#header2 td {
  border: 0px;
  border-bottom: 1px solid #000;
  padding: 15px 2px;
}

tr#count th {
  font-size: 25px;
}

tr#label th {
  font-size: 14px;
}


img {
  width: auto;
  height: 30px;
  display: inline-block;
  margin-right: 20px;
  margin-bottom: 20px;
  position: absolute;
  left: 10px;
  top: 5px;
}
</style>

<body>

  <table id="table">
  </table>

  <table id="table">
    <thead>

      <tr id="header">
        <img src="<?= base_url('assets/img/page/LOGO-BIRU.png') ?>" alt="">

        <td colspan="3" style="padding-left: 250px;">
          <span style="font-size: 16px;font-weight: bold;">Data Souvenir Keluar</span><br>
          <span style="font-weight: bold;font-size: 12px;"><?= $event['wedding'] ?> <?= $event['nama'] ?></span>
        </td>
        <td>
          <span style="font-size: 11px;">Dicetak: <?= date('d/m/Y H:i:s') ?></span>
        </td>
      </tr>

      <tr id="count">
        <th colspan="4"><?= $total ?></th>
      </tr>
      <tr id="label">
        <th colspan="4">Souvenir Diambil</th>
      </tr>

      <tr id="header2">
        <td colspan="4"></td>
      </tr>


      <tr>
        <th>NO</th>
        <th>NAMA</th>
        <th>ALAMAT</th>
        <th>STATUS</th>
      </tr>
    </thead>

    <tbody>

      <?php $i = 1;
      foreach ($tamu as $km) : ?>
      <?php
        if ($km['souvenir'] == '1') {
          $konfir = '<span style="color:green">Terima Souvenir</span> ';
        } else {
          $konfir = '<span style="color:grey">Tidak Terima</span> ';
        }
        ?>
      <tr>
        <td style="width: 20px;text-align:center"><?= $i++; ?></td>
        <td style="width: 210px"><?= $km['nama'] ?></td>
        <td style="width: 230px"><?= $km['alamat'] ?></td>
        <td style="width: 110px"><?= $konfir ?></td>
      </tr>
      <?php endforeach; ?>

    </tbody>
  </table>


</body>

</html>