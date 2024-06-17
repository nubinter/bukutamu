<!DOCTYPE html>
<html>

<head>

</head>

<body>

  <?php
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=" . $namaFile . ".xls");
  header("pragma: no-cache");
  header("expires: 0");
  ?>


  <div>
    <div style="text-align: center;">
      <h3><?= $title; ?></h3>
    </div>
    <table style="margin: 20px auto;border-collapse: collapse;border: 1px;">
      <tr style="border: 1px solid #000;padding: 5px 15px;height: 30px;margin: 20px auto;">
        <th style="border: 1px solid #000;">NO</th>
        <th style="border: 1px solid #000;">NAMA</th>
        <th style="border: 1px solid #000;">ALAMAT</th>
        <th style="border: 1px solid #000;">JUMLAH TAMU</th>
      <?php if($event['fitur_ampao'] == 1) { ?>
        <th style="border: 1px solid #000;">NOMOR AMPAO</th>
      <?php } ?>
        <th style="border: 1px solid #000;">CHECK IN</th>
      </tr>
      <?php $i = 1; ?>
      <?php foreach ($tamu as $rows) : ?>

      <?php
        if ($rows['jam_hadir'] > 0) {
          $tanggal = date('d/m/Y H:i:s', $rows['jam_hadir']);
        } else {
          $tanggal = "Tidak Hadir";
        }
        ?>

      <tr style="border: 1px solid #000;padding: 5px 15px;height: 30px;margin: 20px auto;vertical-align: middle;">
        <td style="border: 1px solid #000;padding: 5px 15px;"><?= $i++; ?></td>
        <td style="border: 1px solid #000;padding: 5px 15px;"><?= $rows['nama']; ?></td>
        <td style="border: 1px solid #000;padding: 5px 15px;"><?= $rows['alamat']; ?></td>
        <td style="border: 1px solid #000;padding: 5px 15px;"><?= $rows['jml_tamu']; ?></td>
        <?php if($event['fitur_ampao'] == 1) { ?>
        <td style="border: 1px solid #000;padding: 5px 15px;"><?= $rows['nomor_ampao']; ?></td>
        <?php } ?>
        <td style="border: 1px solid #000;padding: 5px 15px;"><?= $tanggal; ?></td>
      </tr>
      <?php endforeach; ?>
    </table>
  </div>
</body>

</html>