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
  font-size: 12px;
}


img {
  width: auto;
  height: 40px;
  display: inline-block;
  margin-right: 20px;
  margin-bottom: 10px;
  position: absolute;
  left: 10px;
  top: 0px;
}
</style>

<body>

  <table id="table">
  </table>

  <table id="table">
    <thead>

      <tr id="header">
        <img src="<?= base_url('assets/img/page/logo1.png') ?>" alt="">

        <td colspan="4" style="padding-left: 150px;">
          <span style="font-size: 16px;font-weight: bold;">RSVP & Ucapan</span><br>
          <span style="font-weight: bold;font-size: 12px;"><?= $event['wedding'] ?> <?= $event['nama'] ?></span>
        </td>
        <td>
          <span style="font-size: 11px;">Dicetak: <?= date('d/m/Y H:i:s') ?></span>
        </td>
      </tr>

      <tr id="count">
        <th colspan="2"><?= $total ?></th>
        <th><?= $hadir ?></th>
        <th><?= $tidak ?></th>
        <th><?= $ragu ?></th>
      </tr>
      <tr id="label">
        <th colspan="2">Semua Komentar</th>
        <th>Akan Hadir</th>
        <th>Berhalangan Hadir</th>
        <th>Masih Ragu</th>
      </tr>

      <tr id="header2">
        <td colspan="5"></td>
      </tr>


      <tr>
        <th>NO</th>
        <th>NAMA</th>
        <th>UCAPAN</th>
        <th>KONFIRMASI</th>
        <th>TGL</th>
      </tr>
    </thead>

    <tbody>

      <?php $i = 1;
      foreach ($komen as $km) : ?>
      <?php
        if ($km['meta']['konfirmasi'] == $kodeHadir) {
          $konfir = '<span style="color:green">' . $kodeHadir . '</span> ';
        } elseif ($km['meta']['konfirmasi'] == $kodeTidak) {
          $konfir = '<span style="color:red">' . $kodeTidak . '</span> ';
        } else {
          $konfir = '<span style="color:grey">' . $kodeRagu . '</span> ';
        }

        $tgl = strtotime($km['date']);
        $tgl = date('d/m/Y H:i:s', $tgl);
        ?>
      <tr>
        <td style="width: 20px;"><?= $i++; ?></td>
        <td style="width: 130px"><?= $km['author_name'] ?></td>
        <td style="width: 190px"><?= $km['content']['rendered'] ?></td>
        <td style="width: 100px"><?= $konfir ?></td>
        <td style="width: 110px"><?= $tgl ?></td>
      </tr>
      <?php endforeach; ?>

    </tbody>
  </table>


</body>

</html>