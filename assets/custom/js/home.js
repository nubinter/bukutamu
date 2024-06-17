$('.menu-box #calScan1').on('click', function (e) {
  e.preventDefault();
  $('.modal#modaldwlApk').modal('show');
})





var arg = {
  resultFunction: function (result) {


    $.ajax({
      url: UrLBase + 'home/chekcode',
      type: "POST",
      dataType: "JSON",
      data: {
        barcode: result.code
      },
      cache: false,
      success: function (respon) {
        if (respon.kode == 1) {
          stopKamera();
          $('.modal#scanQr').modal('hide');
          $('.modal#modalJumlah input#jumlaht').val(1);
          $('.modal#modalJumlah input#id').val(respon.idt);
          $('.modal#modalJumlah').modal('show');
          // $.toast({
          //   heading: 'SELAMAT DATANG',
          //   text: respon.pesan,
          //   showHideTransition: 'slide',
          //   icon: 'success',
          //   loaderBg: '#cccc10',
          //   position: 'top-center'
          // });
          return false;
        }
        if (respon.kode == 3) {
          $('.webcamQr span.warning').fadeIn();
          $('.webcamQr span.warning').html('QrCode Salah, Ulangi.!');
          $('.webcamQr span.warning').css('color', '#ff0000');

          setTimeout(function () {
            $('.webcamQr span.warning').fadeOut("slow");
          }, 800);
          // $.toast({
          //   heading: 'ERROR',
          //   text: respon.pesan,
          //   showHideTransition: 'slide',
          //   icon: 'error',
          //   loaderBg: '#cccc10',
          //   position: 'top-center'
          // });
          return false;
        }

        if (respon.kode == 0) {
          console.log('ok');
          return false;
        }

        if (respon.kode == 2) {
          stopKamera();
          $('.modal#scanQr').modal('hide');
          $.toast({
            heading: 'Terimakasih',
            text: respon.pesan,
            showHideTransition: 'slide',
            icon: 'success',
            loaderBg: '#cccc10',
            position: 'top-center'
          });
          return false;
        }
      }
    });

  }
};


$('#manual').on('click', function (e) {
  e.preventDefault();
  $('.modal#modalManual #formInput input').val('');
  $('.modal#modalManual #formInput input#jml').val(1);
  $('.modal#modalManual').modal('show');
})




$('.btnSubmit').click(function () {
  if ($(this).hasClass('disable')) {
    return false;
  }
});

$(function () {
  $('#formInput').submit(function (e) {
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

          /*$.toast({
            heading: 'Success',
            text: json.pesan,
            showHideTransition: 'slide',
            icon: 'success',
            loaderBg: '#d4c357',
            position: 'top-center'
          });*/
           Swal.fire('Success', respon.pesan, 'success');

          btn.html(txt);
          btn.attr('type', 'submit');
          btn.removeClass('disabled');

          $('.modal#modalManual').modal('hide');

          var num = $('.pagination-custom .pagina-number').html();
          $('input#pencarian').val('');
          barisList(num, '');
        } else {
          /*$.toast({
            heading: 'Error',
            text: json.pesan,
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#d4c357',
            position: 'top-center'
          });*/
           Swal.fire('Error', respon.pesan, 'error');

          btn.html(txt);
          btn.attr('type', 'submit');
          btn.removeClass('disabled');
        }
      }
    });
  });
});




$(document).ready(function () {
  var num = $('.pagination-custom .pagina-number').html();
  var cari = $('input#pencarian').val();
  barisList(num, cari);
});



$('input#pencarian').keyup(function () {
  var src = $(this).val();
  var num = 1;
  $('.pagination-custom .pagina-number').html(1);
  barisList(num, src);
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
  barisList(plus, cari);
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
  barisList(plus, cari);
})




function barisList(num, cari) {
  $.ajax({
    url: UrLBase + 'home/loadDataTamu',
    type: "POST",
    dataType: "JSON",
    data: {
      page: num,
      cari: cari,
      hadir: 1
    },
    cache: false,
    beforeSend: function () {
      $("#LoadingPage").fadeIn();
    },
    success: function (respon) {
      $("#LoadingPage").fadeOut();
      $('.count-guest #jmlh').html(respon.totalHadir);
      $('.count-guest #jmluh').html(respon.totalData);

      $('.count-guest #jmlu').html(respon.totalUndangan);
      $('.list-table ul').html(respon.listPage);
      $('.pagination-custom .pagina-right').removeClass('disabled');
      if (respon.totalRecord <= 0) {
        $('.list-table ul').html('<p class="text-center mt-4">Belum ada tamu check-in</p>');
        $('.pagination-custom .pagina-number').html(1);
      }
      var pg = Number(num);
      var jd = Number(respon.totalData / pg);
      if (respon.totalRecord < 10 || jd <= 10) {
        $('.pagination-custom .pagina-right').addClass('disabled');
      }
      console.log(respon.totalRecord)
    }
  });
}



$('#tombol-logout').on('click', function (e) {
  e.preventDefault();
  var lnk = $(this).attr('href');
  swal({
    title: "Apakah anda ingin keluar?",
    text: "",
    type: "question",
    showCancelButton: true,

    confirmButtonText: "Yes",
    cancelButtonText: "Cancel",
  }, function (isConfirm) {
    if (isConfirm) {

      window.location.href = lnk;
    }
  });
})


$('#dwlApkAndro').on('click', function (e) {
  $('.modal#myModal').modal('hide');
  window.location.href = UrLBase + 'home/downloadApk';
});