$('.menu-box #calScan1').on('click', function (e) {
  e.preventDefault();
  $('.modal#modaldwlApk').modal('show');
})

$('.menu-box #calScan').on('click', function (e) {
  e.preventDefault();
  $('.modal#moadlListCekin').modal('show');
})


$('#scanTamuHome').on('click', function (e) {
  e.preventDefault();
  $('.modal#moadlListCekin').modal('hide');
  $('.modal#scannerExt').modal('show');
  $('.modal#scannerExt .menu-pencarian2').addClass('hide');
  $(".modal#scannerExt .mencariData2").fadeOut();
})
    
$('.modal#scannerExt').on('shown.bs.modal', function () {
  $('.modal#scannerExt input#scanNamaTamu').trigger('focus')
  $('.modal#scannerExt input#scanNamaTamu').val("");
  $('.modal#scannerExt .menu-pencarian2').addClass('hide');
})

var barcodeData = "";
function onKeyPress(event) {
	// Cek apakah tombol "Enter" ditekan (kode ASCII 13)
	if (event.keyCode === 13) {
		$.ajax({
			url: UrLBase + 'home/chekcode',
			type: 'POST',
			dataType: 'JSON',
			cache: false,
			data: {
				barcode: barcodeData
			},
			success: function(response) {
				// Mengosongkan nilai variabel barcodeData setelah pengiriman berhasil
				barcodeData = "";
				// Mengosongkan nilai input setelah pengiriman berhasil
				document.getElementById("scanNamaTamu").value = "";
				console.log(response);
				if (response.kode == 1) {
					window.location.replace(UrLBase + 'home/scanQrcode/show/'+response.idt);
				}
				if (response.kode == 3) {
					Swal.fire({
                        title: "Gagal",
                        text: response.pesan,
                        icon: "error",
                        confirmButtonText: "Yes",
                    });
					return false;
				}
				if (response.kode == 2) {
					swal.fire({
                        title: "Gagal",
                        text: response.pesan,
                        icon: "info",
                        confirmButtonText: "Yes",
                    });
				    return false;
				}
			},
		});
	} else {
		// Menambahkan karakter ke variabel barcodeData ketika tombol selain "Enter" ditekan
		barcodeData += event.key;
	}
}
document.getElementById("scanNamaTamu").addEventListener("keypress", onKeyPress);


function jumlahTamuHadir() {
  var jml = $('.modal#modalJumlah input#jumlaht').val();
  var id = $('.modal#modalJumlah input#id').val();
  $.ajax({
    url: UrLBase + 'home/jumlahTamu',
    type: 'POST',
    dataType: 'JSON',
    data: { jml: jml, id: id },
    cache: false,
    success: function (json) {
      if (json.kode == 1) {
        $('.modal#modalJumlah').modal('hide');
        $.toast({
          heading: 'TERIMAKASIH',
          text: json.pesan,
          showHideTransition: 'slide',
          icon: 'success',
          loaderBg: '#cccc10',
          position: 'top-center'
        });

        var num = $('.pagination-custom .pagina-number').html();
        var cari = $('input#pencarian').val();
        barisList(num, cari);

        return false;
      } else {
        $.toast({
          heading: 'ERROR',
          text: json.pesan,
          showHideTransition: 'slide',
          icon: 'error',
          loaderBg: '#cccc10',
          position: 'top-center'
        });
        return false;
      }
    }
  })
}


$('.btnSubmit').click(function () {
  if ($(this).hasClass('disable')) {
    return false;
  }
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
        $('.list-table ul').html('<center><img src="https://app.buktamdigital.my.id/assets/img/page/belumadatamu.png" alt="Tidak ada data!" width="300px" height="300px" ></center>');
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
    title: "Akan menutup aplikasi?",
    text: "",
    type: "info",
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


$('#scanQrcode').on('click', function (e) {
  $('.modal#moadlListCekin').modal('hide');
  window.location.href = UrLBase + 'home/scanQrcode';
});


$('.modal#setHadirCari').on('shown.bs.modal', function () {
  $('.modal#setHadirCari input#hasilJmlTamu').trigger('focus');
  $('.modal#setHadirCari input#hasilJmlTamu').val(1);
})


$('.modal#setHadirCari #hasilCheckinTamu').on('click', function () {
  var idT = $('.modal#setHadirCari input#hasilIdTamu').val();
  var jml = $('.modal#setHadirCari input#hasilJmlTamu').val();
  if (jml == "" || jml == null) {
    $('.modal#setHadirCari input#hasilJmlTamu').focus();
    return false;
  }

  $.ajax({
    url: UrLBase + 'home/setHadirTamuCari',
    type: "POST",
    dataType: "JSON",
    data: {
      jml: jml,
      id: idT
    },
    cache: false,
    beforeSend: function () {
      $("#LoadingPage").fadeIn();
    },
    success: function (res) {
      if (res.kode == 1) {
        $("#LoadingPage").fadeOut();
        $('.modal#setHadirCari').modal('hide');
        $('.modal#pencarianTamu').modal('hide');
        $('.modal#moadlListCekin').modal('hide');
        $.toast({
          heading: 'Success',
          text: res.pesan,
          showHideTransition: 'slide',
          icon: 'success',
          loaderBg: '#d4c357',
          position: 'top-center'
        });

        var num = $('.pagination-custom .pagina-number').html();
        barisList(num, '');
        return false;
      } else {
        $("#LoadingPage").fadeOut();
        $.toast({
          heading: 'Error',
          text: res.pesan,
          showHideTransition: 'slide',
          icon: 'error',
          loaderBg: '#d4c357',
          position: 'top-center'
        });
        return false;
      }
    }
  });
})