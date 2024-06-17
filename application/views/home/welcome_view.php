<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?= $title ?></title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="shortcut icon" href="<?= base_url('assets/img/page/' . $icon1) ?>">

  <!-- Vendor CSS Files -->
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/custom/fontaws/css/all.min.css') ?>">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,700&display=swap"
    rel="stylesheet">
  <script src="<?= base_url('assets/custom/js/right.js') ?>"></script>
</head>

<body style="font-family: 'Poppins', sans-serif;">


  <div style="height: 100vh;width: 100vw;overflow: hidden;font-family: 'Poppins', sans-serif;" class="bodyKonten">
    <!-- LOAD -->
  </div>




  <!-- Vendor JS Files -->
  <script src="<?= base_url('assets/custom/js/jquery.min.js') ?>"></script>
  <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

  <script>
  $(function() {
    var auto_refresh = setInterval(
      function() {
        var url = "<?= base_url('welcome/autoLoadPageView') ?>";
        $('.bodyKonten').load(url).fadeIn("slow");
      }, 1000); // refresh setiap 1 detik
  });
  </script>

</body>

</html>