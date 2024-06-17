$('#qrSouvenir').on('click', function (e) {
  e.preventDefault();
  window.location.href = UrLBase + 'souvenir/scanQrcode';
})


$('#qrExt').on('click', function (e) {
  e.preventDefault();
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
			url: UrLBase + 'souvenir/checkin',
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
					  var num = $('.pagination-custom .pagina-number').html();
					  loadKomen(num);
					  Swal.fire('Success', response.pesan, 'success');
					  $('.modal#scannerExt').modal('show');
					  return false;
				}
				if (response.kode == 3) {
					Swal.fire('Maaf!', response.pesan, 'error');
					return false;
				}
				if (response.kode == 2) {
					Swal.fire('Info', response.pesan, 'info');
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

$(document).ready(function () {
  var num = $('.pagination-custom .pagina-number').html();
  loadKomen(num);
})

function loadKomen(num) {

  var filter = $('.count-guest select#filter').val();
  $.ajax({
    url: UrLBase + 'souvenir/loadListKomen',
    data: {
      page: num
    },
    type: "post",
    dataType: "JSON",
    cache: false,
    beforeSend: function () {
      $("#LoadingPage").fadeIn();
    },
    success: function (json) {
      $("#LoadingPage").fadeOut();
      $('.load-comment').html(json.list)
      $('.count-comment .count-2').html(json.total)
      var pg = Number(num);
      var jd = Number(json.total / pg);
      if (json.totalRecord <= 0) {
        $('.pagination-custom .pagina-number').html(1);
      }
      if (json.totalRecord < 10 || jd <= 10) {
        $('.pagination-custom .pagina-right').addClass('disabled');
      } else {
        $('.pagination-custom .pagina-right').removeClass('disabled');
      }
      if (pg <= 1) {
        $('.pagination-custom .pagina-left').addClass('disabled');
      }
    }
  })
}



$('.pagination-custom .pagina-left').on('click', function () {
  if ($(this).hasClass('disabled')) {
    return false;
  }
  var num = $('.pagination-custom .pagina-number').html();
  var plus = Number(num) - 1;
  if (plus <= 1) {
    plus = 1;
    $(this).addClass('disabled');
  }
  $('.pagination-custom .pagina-number').html(plus);
  loadKomen(plus);
})

$('.pagination-custom .pagina-right').on('click', function () {
  if ($(this).hasClass('disabled')) {
    return false;
  }
  var num = $('.pagination-custom .pagina-number').html();
  var plus = Number(num) + 1;
  $('.pagination-custom .pagina-number').html(plus);
  if (plus > 1) {
    $('.pagination-custom .pagina-left').removeClass('disabled');
  }
  loadKomen(plus);
})


$('#export').click(function () {
  window.open(UrLBase + 'souvenir/pdf', 'blank');
})