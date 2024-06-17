<div class="content">

  <div class="row mt-4">
    <div class="col-sm-4">
      <h6 class="ml-3 content-title">Group Tamu</h6>
    </div>
    <div class="col-sm-8">
      <span class="badge tbl mr-2" id="addgroup">Add Group</span>
    </div>
  </div>


  <div class="card mt-1 mb-3 shadow-sm">

    <div class="card-body">
      <div class="list-table">
        <div class="search">
          <input type="text" placeholder="search..." id="pencarian">
          <i class="fa fa-search"></i>
        </div>

        <ul>
          <li><span class="sub-title">Loading...</span></li>
        </ul>

      </div>



    </div>
  </div>
</div>

</div>


<div class="modal fade" id="addGp" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="addGpLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addGpLabel">Group Tamu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('user/addGroup') ?>" method="post" class="formInput">

          <div class="form-group">
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Ex: Keluarga Mempelai" required>
          </div>

          <div class="form-group mt-4">
            <button class="btn btn-outline-custom rounded-pill btn-block btnSubmit">Tambahkan</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editGr" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="editGrLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editGrLabel">Group Tamu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('user/editGroup') ?>" method="post" class="formInput">

          <input type="text" name="id" id="id" hidden>

          <div class="form-group">
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Ex: Keluarga Mempelai" required>
          </div>

          <div class="form-group mt-4">
            <button class="btn btn-outline-custom rounded-pill btn-block btnSubmit">Update</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>





<?php $this->load->view('template/footer'); ?>


<script>
var UrLBase = '<?= base_url() ?>';
</script>



<script>
$(document).ready(function() {
  var cari = '';
  barisList(cari);
  $('input#pencarian').val('');

  $('input#pencarian').keyup(function() {
    var isi = $(this).val();
    barisList(isi);
  })
})

$('#addgroup').on('click', function() {
  $('.modal#addGp').modal('show');
});




$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnEdit', function(e) {
  e.preventDefault();
  $('.list-table ul li').removeClass('active');
  var id = $(this).data('id');
  var nama = $(this).data('nama');
  $('.modal#editGr').modal('show');
  $('.modal#editGr input#id').val(id);
  $('.modal#editGr input#nama').val(nama);
});




$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnDelete', function(e) {
  e.preventDefault();
  $('.list-table ul li').removeClass('active');
  var nama = $(this).data('nama');
  var id = $(this).data('id');
  if (id == '1') {
    $.toast({
      heading: 'Error',
      text: 'Group dengan ID 1 jangan dihapus!',
      showHideTransition: 'slide',
      icon: 'error',
      loaderBg: '#d4c357',
      position: 'top-center'
    });
    return false;
  }
  swal({
    title: nama,
    text: "jika sudah ada list tamu rekomendasi cukup edit saja, Yakin mau dihapus!",
    type: "info",
    showCancelButton: true,

    confirmButtonText: "Yes",
    cancelButtonText: "No",
  }, function(isConfirm) {
    if (isConfirm) {

      $.ajax({
        url: UrLBase + 'user/deleteGroup',
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
          var cari = $('input#pencarian').val();
          barisList(cari);
        }
      })
    }
  });
})



$(function() {
  $('.formInput').submit(function(e) {
    e.preventDefault();
    var btn = $(this).find('.btnSubmit');
    var txt = $(this).find('.btnSubmit').html();
    $.ajax({
      url: $(this).attr('action'),
      type: "POST",
      cache: false,
      data: $(this).serialize(),
      dataType: 'json',
      beforeSend: function() {
        $("#LoadingPage").fadeIn();
        btn.html(
          '<i class="far fa-spinner fa-spin"></i> Wait...');
        btn.attr('type', 'button');
        btn.attr('disabled', 'disabled');
        btn.addClass('disabled');
      },
      success: function(json) {

        if (json.status == 1) {
          $("#LoadingPage").fadeOut();
          $.toast({
            heading: 'Success',
            text: json.pesan,
            showHideTransition: 'slide',
            icon: 'success',
            loaderBg: '#d4c357',
            position: 'top-center'
          });

          btn.html(txt);
          btn.attr('type', 'submit');
          btn.removeAttr('disabled');
          btn.removeClass('disabled');


          $('.modal#addGp').modal('hide');
          $('.modal#editGr').modal('hide');
          var cari = '';
          barisList(cari);
          $('input#pencarian').val('');
        } else {
          $("#LoadingPage").fadeOut();
          $.toast({
            heading: 'Error',
            text: json.pesan,
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#d4c357',
            position: 'top-center'
          });

          btn.html(txt);
          btn.attr('type', 'submit');
          btn.removeAttr('disabled');
          btn.removeClass('disabled');
        }
      }
    });
  });
});



function barisList(cari) {
  $.ajax({
    url: UrLBase + 'user/loadListGroup',
    type: "POST",
    dataType: "JSON",
    data: {
      cari: cari
    },
    cache: false,
    beforeSend: function() {
      $("#LoadingPage").fadeIn();
    },
    success: function(respon) {
      $("#LoadingPage").fadeOut();
      $('.list-table ul').html(respon.listPage);
    }
  });
}
</script>