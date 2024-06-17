<div class="content">



  <div class="row mt-3">

    <div class="col-12">
      <ul class="menu-btn-page">
        <?php if ($jml < 1) : ?>
        <li class="active"><a id="list" data-id="1" href="">
        <i class='fas fa-file-upload'></i> Upload</a></li>
        <?php endif; ?>
        <li><a data-id="2" href="<?= base_url('tamu/getTemplate') ?>"><i class='fas fa-file-excel'></i> Template Excel</a></li>
        <?php if ($jml >= 1) : ?>
        <li class="active"><a id="list" data-id="3" href="">Save</a></li>
        <?php endif; ?>
      </ul>
    </div>

    <!-- <div class="col-6">
      <h6 class="ml-3 content-title">Tamu Hadir</h6>
    </div> -->

  </div>

  <div class="card mt-1 mb-3 shadow-sm">
    <div class="card-header">
      <div class="count-guest">
        <span class="hadir">Jumlah Data: <span id="jml"><?= $jml ?></span></span>
      </div>
    </div>
    <div class="card-body">
      <div class="list-table">
        <ul>

          <?php $i = 1;
          foreach ($tamu as $row) : ?>
          <?php
            if ($row['vip'] == '1') {
              $vip = ' | <span class="badge badge-custom">VIP</span>';
            } else {
              $vip = '';
            }
            ?>
          <li>
            <span class="nomor"><?= $i++; ?></span>
            <span class="option"><a href="#" n data-id="<?= $row['id'] ?>" class="btnDelete"><i
                  class="far fa-trash-alt text-danger text-15"></i></a></span>
            <span class="title"><?= $row['nama'] ?></span>
            <span class="sub-title"><?= $row['alamat'] . $vip ?></span>
          </li>

          <?php endforeach; ?>


        </ul>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalUpload" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalUploadLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUploadLabel">Select File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('tamu/importExcel') ?>" enctype="multipart/form-data" method="post">
          <div class="form-group mb-4">
            <div class="custom-file">
              <input type="file" accept=".xls,.xlsx" class="custom-file-input" name="file" id="inputGroupFile03"
                aria-describedby="inputGroupFileAddon03" required>
              <label class="custom-file-label" for="inputGroupFile03">File Excel</label>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-custom rounded">Upload</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<?php $this->load->view('template/footer'); ?>


<script>
var UrLBase = '<?= base_url() ?>';
</script>

<script>
$('.menu-btn-page li a#list').click(function(e) {
  e.preventDefault();
  $('.menu-btn-page li').removeClass('active');
  $(this).parent().addClass('active');
  if ($(this).data('id') == '1') {
    $('.modal#modalUpload .custom-file-label').html('File Excel');
    $('.modal#modalUpload input').val('');
    $('.modal#modalUpload').modal('show');
  } else if ($(this).data('id') == '3') {
    $.ajax({
      url: UrLBase + 'tamu/addDataImport',
      type: 'POST',
      cache: false,
      beforeSend: function() {
        $("#LoadingPage").fadeIn();
      },
      success: function(res) {
        if (res == 1) {
          /*$.toast({
            heading: 'Success',
            text: 'Data tersimpan',
            showHideTransition: 'slide',
            icon: 'success',
            loaderBg: '#d4c357',
            position: 'top-center'
          });*/
          Swal.fire({
                title: 'Berhasil',
                text: 'Data Tamu Tersimpan!',
                icon: 'success',
                showConfirmButton: false,
                timer: 2000,
              });
          setTimeout(() => {
            window.location.href = UrLBase + 'tamu';
          }, 1000);
        } else {
          /*$.toast({
            heading: 'Error',
            text: 'Gagal Menyimpan',
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#d4c357',
            position: 'top-center'
          });*/
          Swal.fire({
                title: 'Oops..',
                text: 'Gagal Menyimpan!',
                icon: 'error',
                showConfirmButton: false,
                timer: 2000,
              });
          document.location.reload();
        }
      }
    })
  }
})



$('.custom-file-input').on('change', function() {
  let fileName = $(this).val().split('\\').pop();
  $(this).next('.custom-file-label').addClass("selected").html(fileName);
});


$('ul li .btnDelete').click(function(e) {
  e.preventDefault();
  var id = $(this).data('id');
  $.ajax({
    url: UrLBase + 'tamu/delImport',
    type: "POST",
    data: {
      id: id
    },
    cache: false,
    beforeSend: function() {
      $("#LoadingPage").fadeIn();
    },
    success: function() {
      $("#LoadingPage").fadeOut();
      document.location.reload();
    }
  })
})
</script>