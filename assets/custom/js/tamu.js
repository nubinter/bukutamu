$(document).ready(function () {
  var num = $('.pagination-custom .pagina-number').html();
  var cari = $('input#pencarian').val();
  var group = $('input#group').val();
  barisList(num, cari, group);
});

$('#roundedOne').click(function () {
  var ck = $(this);
  if (ck.prop('checked')) {
    $('.list-table ul li').addClass('active')
  } else {
    $('.list-table ul li').removeClass('active')
  }
})


$('.pagination-custom .pagina-left').on('click', function () {
  var num = $('.pagination-custom .pagina-number').html();
  var cari = $('input#pencarian').val();
  var plus = Number(num) - 1;
  if (plus <= 1) {
    plus = 1;
    $(this).addClass('disabled');
  }
  $('.pagination-custom .pagina-number').html(plus);
  var group = $('input#group').val();
  barisList(plus, cari, group);
})

$('.pagination-custom .pagina-right').on('click', function () {
  if ($(this).hasClass('disabled')) {
    return false;
  }
  var num = $('.pagination-custom .pagina-number').html();
  var cari = $('input#pencarian').val();
  var plus = Number(num) + 1;
  $('.pagination-custom .pagina-number').html(plus);
  if (plus > 1) {
    $('.pagination-custom .pagina-left').removeClass('disabled');
  }
  var group = $('input#group').val();
  barisList(plus, cari, group);
})




$('input#pencarian').keyup(function () {
  var src = $(this).val();
  var num = 1;
  $('.pagination-custom .pagina-number').html(1);

  var group = $('input#group').val();
  barisList(num, src, group);
})




$('#btnPdf').click(function () {
  var idnya = [];
  $('.list-table ul li.active input#idtamu').each(function () {
    idnya.push(this.value);
  });
  $('#roundedOne').removeAttr('checked');
  if (idnya == "" || idnya == null) {
    Swal.fire('Maaf!', 'Belum ada tamu yang kamu pilih', 'error');
    $('#roundedOne').removeAttr('checked');
    return false;
  } else {
    $('#roundedOne').attr('checked', 'checked')
    window.open(UrLBase + 'tamu/pdf?data=' + idnya, '_blank');
  }
})



$('#btnWaSelected').click(function () {
    var idnya = [];
    var id_event = $(this).data('id_event');
    $('.list-table ul li.active input#idtamu').each(function () {
        idnya.push(this.value);
    });
    $('#roundedOne').removeAttr('checked');
    if (idnya == "" || idnya == null) {
        Swal.fire('Maaf!', 'Belum ada tamu yang kamu pilih', 'error');
        $('#roundedOne').removeAttr('checked');
        return false;
    } else {
        $('.modal#modalSelectedBlast').modal('show');
    }
})

$('#saveBlast').click(function () {
    const sender = document.getElementById("sender_select").value;
    const delay = document.getElementById("delay").value;
    var idnya = [];
    $('.list-table ul li.active input#idtamu').each(function () {
        idnya.push(this.value);
    });
    $('#roundedOne').removeAttr('checked');
    $.ajax({
       url: UrLBase + 'whatsapp/savecampaign',
       type: "POST",
       data: {
         id: idnya,
         type: 'selected',
         sender: sender,
         delay: delay
       },
       cache: false,
       success: function (result) {
         $('#roundedOne').removeAttr('checked');
		 var kode = result.kode;
		 if(kode == 1) {
			 showSuccessAlert(result.pesan);
			 $('.modal#modalSelectedBlast').modal('hide');
		 }
		 if(kode == 2) {
			showErrorAlert(result.pesan);
			$('.modal#modalSelectedBlast').modal('hide');
		 }
       },
       error: function () {
		 showErrorAlert('Terjadi kesalahan saat mengirim data.');
       }
    });
})

$('#btnDelAll').click(function () {
  var idnya = [];
  $('.list-table ul li.active input#idtamu').each(function () {
    idnya.push(this.value);
  });
  $('#roundedOne').removeAttr('checked');
  if (idnya == "" || idnya == null) {
    Swal.fire('Maaf!', 'Belum ada tamu yang kamu pilih', 'error');
    $('#roundedOne').removeAttr('checked');
    return false;
  } else {
    $('#roundedOne').attr('checked', 'checked')
    Swal.fire({
      title: 'Yakin ingin hapus?',
       text: "Ini akan menghapus tamu terselected!!",
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yaa, Hapus!',
       position: 'top-center',
       showLoaderOnConfirm: true,
    }).then((result) => {
      if (result.isConfirmed) {
        
        $.ajax({
              url: UrLBase + 'tamu/deleteAll',
              type: "POST",
              data: {
                id: idnya
              },
              cache: false,
              beforeSend: function () {
                $("#LoadingPage").fadeIn();
              },
              success: function () {
                $('#roundedOne').removeAttr('checked');
                $("#LoadingPage").fadeOut();
                var num = $('.pagination-custom .pagina-number').html();
                var cari = $('input#pencarian').val();
                var group = $('input#group').val();
                barisList(num, cari, group);
              }
            })
        
      } else if (result.dismiss === Swal.DismissReason.cancel) {
      }
    });
  }
})


 $(document).ready(function () {
   $('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnDelete', function (e) {
     e.preventDefault();
     $('.list-table ul li').removeClass('active');
     var nama = $(this).data('nama');
     var id = $(this).data('id');

    Swal.fire({
       title: 'Yakin ingin hapus?',
       text: "Ini akan menghapus tamu tersebut!",
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yaa, Hapus!',
       position: 'top-center',
       showLoaderOnConfirm: true,
    }).then((result) => {
       if (result.isConfirmed) {
         $.ajax({
           url: UrLBase + 'tamu/delete',
           type: "POST",
           data: {
             id: id
           },
           cache: false,
           beforeSend: function () {
             $("#LoadingPage").fadeIn();
           },
           success: function () {
             $('#roundedOne').removeAttr('checked');
             $("#LoadingPage").fadeOut();
             var num = $('.pagination-custom .pagina-number').html();
             var cari = $('input#pencarian').val();
             var group = $('input#group').val();
             barisList(num, cari, group);
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
 });


function barisList(num, cari, group) {
  $.ajax({
    url: UrLBase + 'tamu/loadDataTamu',
    type: "POST",
    dataType: "JSON",
    data: {
      page: num,
      cari: cari,
      group: group
    },
    cache: false,
    beforeSend: function () {
      $("#LoadingPage").fadeIn();
    },
    success: function (respon) {
      $("#LoadingPage").fadeOut();
      $('.count-guest #jml').html(respon.totalData);
      $('.list-table ul').html(respon.listPage);
      $('.pagination-custom .pagina-right').removeClass('disabled');
      if (respon.totalRecord <= 0) {
        $('.list-table ul').html('<center><img src="https://app.buktamdigital.my.id/assets/img/page/belumadadatatamu.png" alt="Tidak ada data!" width="300px" height="209px" ></center>');
        $('.pagination-custom .pagina-number').html(1);
      }
      var pg = Number(num);
      var jd = Number(respon.totalData / pg);
      if (respon.totalRecord < 18 || jd <= 18) {
        $('.pagination-custom .pagina-right').addClass('disabled');
      }
      if ($('#roundedOne').is(':checked')) {
        $('#roundedOne').click();
      }
      console.log(respon.totalRecord)
    }
  });
}

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

$('#btnAdd').on('click', function (e) {
  e.preventDefault();
  $('.modal#modaladd').modal('show');
  $('.modal#modaladd input').val('');
})

$('.modal#modaladd').on('shown.bs.modal', function () {
  $('.modal#modaladd input#nama').trigger('focus')
})


$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnEdit', function (e) {
  e.preventDefault();
  $('.list-table ul li').removeClass('active');
  var id = $(this).data('id');
  var nama = $(this).data('nama');
  var alamat = $(this).data('alamat');
  var vip = $(this).data('vip');
  var group = $(this).data('group');
  var wa = $(this).data('wa');
  var nomor_meja = $(this).data('meja');
  $('.modal#modaledit').modal('show');
  $('.modal#modaledit input#id').val(id);
  $('.modal#modaledit input#nama').val(nama);
  $('.modal#modaledit input#alamat').val(alamat);
  $('.modal#modaledit select#vip').val(vip);
  $('.modal#modaledit select#group').val(group);
  $('.modal#modaledit input#nomor_wa').val(wa);
  $('.modal#modaledit input#nomor_meja').val(nomor_meja);
})





$('.btnSubmit').click(function () {
  if ($(this).hasClass('disable')) {
    return false;
  }
});


$(function () {
  $('.formInput').submit(function (e) {
    e.preventDefault();
    // var id = $(this).find('input#id').val();
    // var nama = $(this).find('input#nama').val();
    // var alamat = $(this).find('input#alamat').val();
    // var vip = $(this).find('input[name=vip]:checked').data('id');

    var btn = $(this).find('.btnSubmit');
    var txt = $(this).find('.btnSubmit').html();
	var nomor_wa = $(this).find('input#nomor_wa').val();
	if(nomor_wa != '') {
	const regex = /^628\d{8,}$/;
        if(regex.test(nomor_wa)) {
    	} else {
    		$('#hasil-cek-nomor').html('Isikan Nomor dengan awalan (62) Contoh: 62897xxxxxx');
            return Swal.fire(
              'Nomor Whatsapp Tidak Valid',
              'Isikan Nomor dengan (62) Contoh: 62897xxxxxx',
              'warning'
            )
    	}
	}
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

          /*$.toast({
            heading: 'Success',
            text: json.pesan,
            showHideTransition: 'slide',
            icon: 'success',
            loaderBg: '#d4c357',
            position: 'top-center'
          }); */
          
          showSuccessAlert(json.pesan)
          
         

          btn.html(txt);
          btn.attr('type', 'submit');
          btn.removeClass('disabled');

          $('.modal#modaledit').modal('hide');
          $('.modal#modaladd').modal('hide');

          var num = $('.pagination-custom .pagina-number').html();
          $('input#pencarian').val('');

          var group = $('input#group').val();
          barisList(num, '', group);
        } else {
          /*$.toast({
            heading: 'Error',
            text: json.pesan,
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#d4c357',
            position: 'top-center'
          }); */
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





$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnQr', function (e) {
  e.preventDefault();
  $('.list-table ul li').removeClass('active');
  var id = $(this).data('id');
  $.ajax({
    url: UrLBase + 'tamu/cekQr',
    dataType: 'JSON',
    type: "POST",
    data: {
      id: id
    },
    cache: false,
    beforeSend: function () {
      $("#LoadingPage").fadeIn();
    },
    success: function (json) {
      if (json.kode == 1) {
        
        $('.modal#modalQr img#imgqr').attr('src', json.qr);
        $('.modal#modalQr .qrTamu #qrTamuNama').html(json.nama);
        $('.modal#modalQr .qrTamu #qrTamuAlamat').html(json.alamat);
        if (json.vip == 1) {
          $('.badges-vip').removeAttr('hidden');
        } else {
          $('.badges-vip').attr('hidden', true);
        }

        $('.modal#modalQr').modal('show');
        $("#LoadingPage").fadeOut();
      } else {
        $("#LoadingPage").fadeOut();
        /*$.toast({
          heading: 'Error',
          text: 'Silahkan diulang!',
          showHideTransition: 'slide',
          icon: 'error',
          loaderBg: '#d4c357',
          position: 'top-center'
        });*/
        showSuccessAlert('Silahkan diulang')
      }
    }
  })
})



$('#modalQr #btnDwlQr').click(function () {
  var nama = $('#areaDownloadQr .qrTamu #qrTamuNama').text();
  html2canvas($('#modalQr #areaDownloadQr')[0], {
    scale: 4,
  }).then(function (canvas) {
    var filenm = nama + ".png";
    var a = document.createElement('a');
    a.href = canvas.toDataURL("image/png", 0.5);
    a.download = filenm;
    a.click();
  });
});




$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnCopy', function (e) {
  e.preventDefault();
  $('.list-table ul li').removeClass('active');
  var id = $(this).data('id');
  $.ajax({
    url: UrLBase + 'tamu/cekWa',
    dataType: 'JSON',
    type: "POST",
    data: {
      id: id
    },
    cache: false,
    beforeSend: function () {
      $("#LoadingPage").fadeIn();
    },
    success: function (json) {
      if (json.kode == 1) {
        $('.modal#modalWa textarea#pesan').val(json.message);
        $('.modal#modalWa').modal('show');
        $("#LoadingPage").fadeOut();
      } else {
        $("#LoadingPage").fadeOut();
        // $.toast({
        //   heading: 'Error',
        //   text: 'Silahkan diulang!',
        //   showHideTransition: 'slide',
        //   icon: 'error',
        //   loaderBg: '#d4c357',
        //   position: 'top-center'
        // });
        
        showSuccessAlert('Silahkan diulang')
        
      }
    }
  })
})


$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnWaMe', function (e) {
  e.preventDefault();
  $('.list-table ul li').removeClass('active');
  var id = $(this).data('id');
  $.ajax({
    url: UrLBase + 'tamu/shareWaMe',
    type: 'POST',
    data: { id: id },
    cache: false,
    success: function (res) {
      window.open(res, '_blank');
    }
  })
})


$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnWa', function (e) {
  e.preventDefault();
  $('.list-table ul li').removeClass('active');
  var id = $(this).data('id');
  $('#id_tamu').val(id);
  $('.modal#modalSendWa').modal('show');
})


$('#kirimWa').click(function (e) {
  e.preventDefault();
  $('#kirimWa').html('Sedang mengirim...');
  const id = document.getElementById('id_tamu').value;
  const sender = document.getElementById("sender_select2").value;
  $('.modal#modalSendWa').modal('show');
  $.ajax({
    url: UrLBase + 'whatsapp/send_wa',
    type: 'POST',
    data: { id: id, sender: sender },
    cache: false,
    success: function (res) {
		console.log(res.status);
		if(res.status == true) {
			Swal.fire('Sukses', res.msg, 'success');
			$('.modal#modalSendWa').modal('hide');
            $('#kirimWa').html('Kirim');
		} else {
			Swal.fire('Gagal', res.msg, 'error');
			$('.modal#modalSendWa').modal('hide');
            $('#kirimWa').html('Kirim');
		}
    }
  })
})

$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnUndangan', function (e) {
  e.preventDefault();
  $('.list-table ul li').removeClass('active');
  var id = $(this).data('id');
  $.ajax({
    url: UrLBase + 'tamu/shareLink',
    type: 'POST',
    data: { id: id },
    cache: false,
    success: function (res) {
      window.open(res, '_blank');
    }
  })
})

$('#btnGroup').click(function (e) {
  e.preventDefault();
  $('.modal#modalGroup').modal('show');
});

$('.modal#modalGroup .modal-body select#grouptamu').on('change', function () {
  var txt = $(this).find('option:selected').text();
  var id = $(this).val();
  $('#btnGroup').html('<i class="far fa-list-alt"></i> ' + txt);
  $('.modal#modalGroup').modal('hide');
  $('input#group').val(id);

  var num = $('.pagination-custom .pagina-number').html();
  var cari = $('input#pencarian').val();
  var group = $('input#group').val();
  barisList(num, cari, group);
})
