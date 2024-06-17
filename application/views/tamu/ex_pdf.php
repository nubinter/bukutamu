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

img {
  width: auto;
  height: 20px;
  display: inline-block;
  margin-right: 20px;
  margin-bottom: 5px;
  position: absolute;
  left: 5px;
  top: -10px;
  padding-bottom: 25px;
}
</style>

<body>

    <table id="table">
        <tr id="header">
            <img src="<?= base_url('assets/img/page/LOGO-BIRU.png') ?>" alt="">
            <td colspan="6" style="padding-left: 280px;">
              <span style="font-size: 16px;font-weight: bold; font-style: Poppin;">Data Tamu</span><br>
              <span style="font-weight: bold;font-size: 12px;"><?= $event['wedding'] ?> <?= $event['nama'] ?></span>
            </td>
            <td>
              <span style="font-size: 14px;"><?= $title ?></span><br>
              <span style="font-size: 11px;">Dicetak: <?= date('d/m/Y') ?></span>
            </td>
        </tr>
    </table>
    <br />
  <table id="table">
    <thead>
      <tr>
        <th style="width: 7%;">No</th>
        <th style="width: 26%;">Nama</th>
        <th style="width: 26%;">Alamat</th>
      <?php if($event['fitur_ampao'] == 1) { ?>
        <th style="width: 10%;">Jml Tamu</th>
        <th style="width: 10%;">Nomor Ampao</th>
      <?php } else {
        echo '<th style="width: 15%;">Jml Tamu</th>';
      }
      ?>
        <th style="width: 22%;">Checkin</th>
      </tr>
    </thead>

    <tbody>


      <?php $i = 1;
      foreach ($tamu as $row) : ?>

      <?php
        if ($row['jam_hadir'] > 0) {
          $tanggal = date('d/m/Y H:i:s', $row['jam_hadir']);
        } else {
          $tanggal = "Tidak Hadir";
        }
        ?>

      <tr>
        <td style="text-align: center;"><?= $i++ ?></td>
        <td><?= $row['nama'] ?></td>
        <td><?= $row['alamat'] ?></td>
        <td style="text-align: center;"><?= $row['jml_tamu'] ?></td>
        <?php if($event['fitur_ampao'] == 1) { ?>
        <td style="text-align: center;"><?= $row['nomor_ampao'] ?></td>
        <?php } ?>
        <td><?= $tanggal ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>


</body>

</html>