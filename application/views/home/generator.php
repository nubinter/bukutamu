<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="author" content="webskita.com mail:rmarliusputra@gmail.com">
  <title><?= $title ?></title>
  <link rel="shortcut icon" href="<?= base_url('assets/img/page/' . $icon) ?>">

  <meta content="" name="descriptison">
  <meta content="" name="keywords">
  <meta property="og:title" content="<?= $title ?>">
  <meta property="og:description" content="<?= $descr ?>">
  <meta property="og:image" content="<?= base_url('assets/img/page/' . $icon) ?>">

  <meta property="twitter:title" content="<?= $title ?>">
  <meta property="twitter:description" content="<?= $descr ?>">
  <meta property="twitter:image" content="<?= base_url('assets/img/page/' . $icon) ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta data-rh="true" name="description" content="<?= $descr ?>">

  <!-- Bootstrap CSS -->

  <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
  <script src="<?= base_url('assets/custom/js/right.js') ?>"></script>
</head>

<body>

  <div class="container pt-4" style="max-width: 500px;">
    <div class="form-group">
      <label for="">Text Encode</label>
      <textarea id="text" rows="4" class="form-control" placeholder="username:password"></textarea>
    </div>

    <div class="form-group">
      <button class="btn btn-info" id="decode">Encode</button>
    </div>


    <div class="form-group">
      <div class="input-group mb-3">
        <input type="text" class="form-control" id="kode" placeholder="Result">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" onclick="copyTeks()" type="button">Copy</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Optional JavaScript -->
  <script src="<?= base_url('assets/custom/js/jquery.min.js') ?>"></script>
  <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>



  <script type="text/javascript">
  function copyTeks() {
    var text = $('input#kode').select().val();
    document.execCommand("copy");
    alert('Copy to clipboard');
  }


  $('#decode').click(function(e) {
    e.preventDefault();
    var isi = $('textarea#text').val();
    if (isi == "") {
      $('textarea#text').focus();
      return false;
    }

    $.ajax({
      url: '<?= base_url('generate/encode') ?>',
      type: "POST",
      dataType: "JSON",
      data: {
        text: isi
      },
      cache: false,
      beforeSend: function() {
        $('#decode').html('Silahkan tunggu....');
        $('#decode').attr('disabled', 'disabled');
      },
      success: function(json) {
        if (json.kode == 1) {
          $('input#kode').val(json.hasil);
          $('#decode').html('Encode');
          $('#decode').removeAttr('disabled');
          return false;
        } else {
          alert('Silahkan diulang');
        }
      }
    })
  })
  </script>


</body>

</html>