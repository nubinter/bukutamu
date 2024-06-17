<div class="content">

  <div class="row mt-4">
    <div class="col-sm-4">
      <h6 class="ml-3 content-title">Pengaturan User & Domain</h6>
    </div>
    <div class="col-sm-8">
      <span class="badge tbl mr-2" id="adddomain">Kelola Domain Comment</span>
    </div>
  </div>

<div class="row mt-4">    <div class="col-sm-4">      <h6 class="ml-3 content-title">User</h6>    </div>    <div class="col-sm-8">    </div>  </div>  <div class="card mt-1 mb-3 shadow-sm">    <div class="card-body">      <div class="list-table">        <div class="search">          <input type="text" placeholder="search..." id="pencarian-user">          <i class="fa fa-search"></i>        </div>        <ul class="user">          <li><span class="sub-title">Loading...</span></li>        </ul>      </div>    </div>  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalKuotaWa" data-backdrop="static" data-keyboard="false" tabindex="-1"  aria-labelledby="modalKuotaWaLabel" aria-hidden="true">  <div class="modal-dialog">    <div class="modal-content">      <div class="modal-header">        <h5 class="modal-title" id="modalKuotaWaLabel">Tambah Kuota</h5>        <button type="button" class="close" data-dismiss="modal" aria-label="Close">          <span aria-hidden="true">&times;</span>        </button>      </div>      <div class="modal-body">        <form action="<?= base_url('whatsapp/tambahkuota') ?>" method="post" class="formInput">          <input type="text" name="id" id="id" hidden>          <div class="form-group">            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama User" disabled>          </div>          <div class="form-group">            <input type="number" name="kuota_wa" id="kuota" class="form-control" placeholder="Quota Event" required>          </div>          <div class="form-group mt-4">            <button class="btn btn-outline-custom rounded-pill btn-block btnSubmit">Save</button>          </div>        </form>      </div>      <div class="modal-footer">        <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">Close</button>      </div>    </div>  </div></div>
<div class="modal fade" id="domainadd" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="domainaddLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="domainaddLabel">Domain Integrasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('user/adddomain') ?>" method="post" class="formInput mb-3">
            
            <span class="d-block text-11"><b>Keterangan:</b></span>
            <span class="d-block text-11 copy-text">Klik <b><a href="https://www.base64encode.org/">LINK DISINI</a></b> Untuk generate <b>Token Akses</b></span><br>

          <div class="form-group">
            <input type="url" name="url" id="url" class="form-control" placeholder="https://domain.com/" required>
          </div>

          <div class="form-group">
            <input type="text" name="token" id="token" class="form-control" placeholder="Token Akses" required>
          </div>

          <div class="form-group mt-4">
            <button class="btn btn-outline-custom rounded-pill btn-block btnSubmit">Tambahkan</button>
          </div>
        </form>
        <hr>
        <ul id="listdom" style="font-size:13px;list-style:none;margin:0;padding:0"></ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-dismiss="modal">Close</button>
      </div>
      
      
    </div>
  </div>
</div>


<div class="modal fade" id="detailAdmin" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="detailAdminLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailAdminLabel">Data Admin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table style="font-size:13px"></table>
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
    barisListUser(cari);
  loadUndangan();
  $('input#pencarian-user').val('');

  $('input#pencarian-user').keyup(function() {
    var isi = $(this).val();
    barisListUser(isi);
  })
})


function loadUndangan() {
  $.ajax({
    url: UrLBase + 'user/loadDomain',
    type: "post",
    cache: false,
    success: function(respon) {
      $('.modal#useradd input').val('');
      $('.modal#useradd select#undangan').html(respon);
      $('.modal#modaledit select#undangan').html(respon);
    }
  })
}



$('#adduser').on('click', function() {
  loadUndangan();
  $('.modal#useradd').modal('show');
});

$('.list-table ul').on('click', 'li .title', function() {
  $('.list-table ul li').removeClass('active');
  $(this).parent('li').addClass('active');
  var id = $(this).data('id');
  viewDetail(id);
})

$('.list-table ul').on('click', 'li .sub-title', function() {
  $('.list-table ul li').removeClass('active');
  $(this).parent('li').addClass('active');
  var id = $(this).data('id');
  viewDetail(id);
})
$('.list-table-user ul').on('click', 'li .title', function() {
  $('.list-table-user ul li').removeClass('active');
  $(this).parent('li').addClass('active');
  var id = $(this).data('id');
  viewDetail(id);
})

$('.list-table-user ul').on('click', 'li .sub-title', function() {
  $('.list-table-user ul li').removeClass('active');
  $(this).parent('li').addClass('active');
  var id = $(this).data('id');
  viewDetail(id);
})

function viewDetail(id) {
  $.ajax({
    url: UrLBase + 'user/detailAdmin',
    type: "POST",
    data: {
      id: id
    },
    cache: false,
    beforeSend: function() {
      $("#LoadingPage").fadeIn();
    },
    success: function(respon) {
      $("#LoadingPage").fadeOut();
      $('.modal#detailAdmin').modal('show');
      $('.modal#detailAdmin .modal-body table').html(respon);
    }
  });
}



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
          /*$.toast({
            heading: 'Success',
            text: json.pesan,
            showHideTransition: 'slide',
            icon: 'success',
            loaderBg: '#d4c357',
            position: 'top-center'
          });*/
          Swal.fire({
                title: 'Success',
                text: json.pesan,
                icon: 'success',
                showConfirmButton: false,
                timer: 1000,
              });

          btn.html(txt);
          btn.attr('type', 'submit');
          btn.removeAttr('disabled');
          btn.removeClass('disabled');


          $('.modal#useradd').modal('hide');
          $('.modal#domainadd').modal('hide');
          $('.modal#modaledit').modal('hide');
          var cari = '';
          barisList(cari);
          $('input#pencarian').val('');
        } else {
          $("#LoadingPage").fadeOut();
          /*$.toast({
            heading: 'Error',
            text: json.pesan,
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#d4c357',
            position: 'top-center'
          });*/
          Swal.fire({
                title: 'Oops..',
                text: 'Username/Password Salah!',
                icon: 'error',
                showConfirmButton: false,
                timer: 1500,
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






$('#adddomain').on('click', function() {
  listDomain();
  $('.modal#domainadd .modal-body input#url').val('');
  $('.modal#domainadd .modal-body input#token').val('');
  $('.modal#domainadd').modal('show');
});

$('.modal#domainadd .modal-body ul#listdom').on('click', 'li .btnDeleteDom', function(e) {
  e.preventDefault();
  var id = $(this).data('id');
  $.ajax({
    url: UrLBase + 'user/deleteDomain/' + id,
    type: "POST",
    cache: false,
    beforeSend: function() {
      $("#LoadingPage").fadeIn();
    },
    success: function(respon) {
      $("#LoadingPage").fadeOut();
      listDomain();
    }
  });
})




$('.custom-file-input').on('change', function() {
  let fileName = $(this).val().split('\\').pop();
  $(this).next('.custom-file-label').addClass("selected").html(fileName);
});




function listDomain() {
  $.ajax({
    url: UrLBase + 'user/loadListDomain',
    type: "POST",
    cache: false,
    beforeSend: function() {
      $("#LoadingPage").fadeIn();
    },
    success: function(respon) {
      $("#LoadingPage").fadeOut();
      $('.modal#domainadd .modal-body ul#listdom').html(respon);
    }
  });
}


function barisListUser(cari) {
  $.ajax({
    url: UrLBase + 'user/loadDataUser',
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
      $('.list-table ul.user').html(respon.listPage);
    }
  });
}

$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnEdit', function(e) {
  loadUndangan();
  e.preventDefault();
  $('.list-table ul li').removeClass('active');
  var id = $(this).data('id');
  var nama = $(this).data('nama');
  var email = $(this).data('email');
  var username = $(this).data('username');
  var undangan = $(this).data('undangan');
  var jml = $(this).data('jml');
  $('.modal#modaledit').modal('show');
  $('.modal#modaledit input#id').val(id);
  $('.modal#modaledit input#nama').val(nama);
  $('.modal#modaledit input#email').val(email);
  $('.modal#modaledit input#username').val(username);
  $('.modal#modaledit input#password').val("");
  $('.modal#modaledit input#jml').val(jml);
  $('.modal#modaledit select#undangan').val(undangan);
});
$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnKuotaWa', function(e) {
  loadUndangan();
  e.preventDefault();
  $('.list-table ul li').removeClass('active');
  var id = $(this).data('id');
  var nama = $(this).data('nama');
  var kuota = $(this).data('kuota');
  $('.modal#modalKuotaWa').modal('show');
  $('.modal#modalKuotaWa input#id').val(id);
  $('.modal#modalKuotaWa input#nama').val(nama);
  $('.modal#modalKuotaWa input#kuota').val(kuota);
});
$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnDelete', function(e) {
  e.preventDefault();
  $('.list-table ul li').removeClass('active');
  var nama = $(this).data('nama');
  var id = $(this).data('id');
  Swal.fire({
      title: 'Apa kamu yakin?',
       text: "ingin menghapus admin!",
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Delete!',
       position: 'top-center',
       showLoaderOnConfirm: true,
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
        url: UrLBase + 'user/delete',
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
        
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        // Kode yang akan dijalankan jika pengguna menekan tombol "Tidak" atau menutup kotak konfirmasi.
        // Swal.fire('Dibatalkan', 'Tindakan dibatalkan', 'error');
      }
    });
  /*swal({
    title: nama,
    text: "is data Deleted?",
    type: "info",
    showCancelButton: true,

    confirmButtonText: "Yes",
    cancelButtonText: "No",
  }, function(isConfirm) {
    if (isConfirm) {

      $.ajax({
        url: UrLBase + 'user/delete',
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
  });*/
})
</script>