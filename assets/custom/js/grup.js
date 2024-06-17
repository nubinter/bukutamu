function barisList(id) {
  $.ajax({
    url: UrLBase + 'tamu/loadDataGrup/'+id,
    type: "POST",
    dataType: "JSON",
    cache: false,
    beforeSend: function () {
      $("#LoadingPage").fadeIn();
    },
    success: function (respon) {
      $("#LoadingPage").fadeOut();
      $('.list-table ul').html(respon.listPage);
      if (respon.totalRecord <= 0) {
        $('.list-table ul').html('<center><img src="https://app.buktamdigital.my.id/assets/img/design/belumadadatagrup1.png" alt="Tidak ada data!" width="300px" height="209px" ></center>');
      }
    }
  });
}


$(function () {
  $('.formInput').submit(function (e) {
    e.preventDefault();
    var btn = $(this).find('.btnSubmit');
    var txt = $(this).find('.btnSubmit').html();
    $.ajax({
      url: $(this).attr('action'),
      type: "POST",
      cache: false,
      data: $(this).serialize(),
      dataType: 'json',
      beforeSend: function () {
        btn.html(
          '<i class="far fa-spinner fa-spin"></i> Menyimpan..');
        btn.attr('type', 'button');
        btn.addClass('disabled');
      },
      success: function (json) {
        if (json.kode == 1) {
          showSuccessAlert(json.pesan)
          btn.html(txt);
          btn.attr('type', 'submit');
          btn.removeClass('disabled');
          $('.modal#modaledit').modal('hide');
          $('.modal#modaladd').modal('hide');
         barisList(json.event_id);
        } else {
          Swal.fire({
            title: 'Error',
            text: json.pesan,
            icon: 'error',
            showConfirmButton: true,
            position: 'top-center'
          });
          btn.html(txt);
          btn.attr('type', 'submit');
          btn.removeClass('disabled');
        }
      }
    });
  });
});



$('#btnAdd').on('click', function (e) {
  e.preventDefault();
  $('.modal#modaladd').modal('show');
  $('.modal#modaladd input').val('');
})

$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnDelete', function (e) {
     e.preventDefault();
     $('.list-table ul li').removeClass('active');
     var id = $(this).data('id');
     var event_id = $(this).data('event');

     Swal.fire({
       title: 'Yakin ingin hapus?',
       text: "Ini akan menghapus group tamu!",
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yaa, Hapus!',
       position: 'top-center',
       showLoaderOnConfirm: true,
     }).then((result) => {
       if (result.isConfirmed) {
         $.ajax({
           url: UrLBase + 'tamu/delete_group',
           type: "POST",
           dataType: 'json',
           data: {
             id: id,
             event_id: event_id
           },
           cache: false,
           beforeSend: function () {
             $("#LoadingPage").fadeIn();
           },
           success: function (json) {
             $("#LoadingPage").fadeOut();
             if (json.kode == 1) {
                  showSuccessAlert(json.pesan)
                 barisList(event_id);
                } else {
                  Swal.fire({
                    title: 'Error',
                    text: json.pesan,
                    icon: 'error',
                    showConfirmButton: true,
                    position: 'top-center'
                  });
                }
           },
           error: function () {
             showErrorAlert('Terjadi kesalahan saat mengirim data.');
           }
         });
       } else if (result.dismiss === Swal.DismissReason.cancel) {
         // Kode yang akan dijalankan jika pengguna menekan tombol "Tidak" atau menutup kotak konfirmasi.
        //  showErrorAlert('Delete dibatalkan');
       }
     });
   });


$('.modal#modaladd').on('shown.bs.modal', function () {
  $('.modal#modaladd input#nama').trigger('focus')
})

$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnEdit', function (e) {
  e.preventDefault();
  $('.list-table ul li').removeClass('active');
  var id = $(this).data('id');
  var nama = $(this).data('nama');
  var deskripsi = $(this).data('deskripsi');
  var kode = $(this).data('kode');
  $('.modal#modaledit').modal('show');
  $('.modal#modaledit input#id').val(id);
  $('.modal#modaledit input#nama').val(nama);
  $('.modal#modaledit textarea#deskripsi').val(deskripsi);
  $('.modal#modaledit input#kode').val(kode);
})





$('.btnSubmit').click(function () {
  if ($(this).hasClass('disable')) {
    return false;
  }
});

function showErrorAlert(pesan) {
  Swal.fire({
    title: 'Error',
    text: pesan,
    icon: 'error',
    showConfirmButton: true,
    position: 'top-center'
  });
}

// Fungsi SweetAlert2 untuk pesan sukses
function showSuccessAlert(pesan) {
  Swal.fire({
    title: 'Success',
    text: pesan,
    icon: 'success',
    showConfirmButton: true,
    position: 'top-center'
  });
}