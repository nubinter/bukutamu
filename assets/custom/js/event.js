$(document).ready(function () {
  var cari = '';
  loadDataEv(cari);
  $('input#pencarian').val('');

  $('input#pencarian').keyup(function () {
    var isi = $(this).val();
    loadDataEv(isi);
  })
})



function loadDataEv(cari) {
  $.ajax({
    url: UrLBase + 'seting/load_data',
    type: 'POST',
    dataType: 'JSON',
    data: {
      cari: cari
    },
    cache: false,
    success: function (respon) {
      $('#boxListData').html(respon.list);
      $('#jmlevent').html(respon.jmlev);
    }
  })
}


function loadEv() {
  $.ajax({
    url: UrLBase + 'seting/loadEvent',
    type: 'POST',
    cache: false,
    success: function (respon) {
      $('.modal#useradd select').html(respon);
    }
  })
}


$('#addkuota').click(function () {
  $('.modal#addkuota').modal('show');
  $('.modal#addkuota input').val('');
  $('.modal#addkuota select').val('');
  $('.modal#addkuota .btnSubmit').attr('type', 'submit');
  $('.modal#addkuota .btnSubmit').html('Save');
  loadEv();
})

$('#adduser').click(function () {
  $('.modal#useradd').modal('show');
  $('.modal#useradd input').val('');
  $('.modal#useradd select').val('');
  $('.modal#useradd .btnSubmit').attr('type', 'submit');
  $('.modal#useradd .btnSubmit').html('Save');
  loadEv();
})

$('#addevent').click(function () {
  $('.modal#eventadd').modal('show');
  $('.modal#eventadd input#namae').val('');
  $('.modal#eventadd input#tgl').val('');
  $('.modal#eventadd input#link').val('');
  $('.modal#eventadd .btnSubmit').attr('type', 'submit');
  $('.modal#eventadd .btnSubmit').html('Save');
})

$('#myakun').click(function () {
  var nama = $(this).data('nama');
  var email = $(this).data('email');
  var uname = $(this).data('username');
  var nowa = $(this).data('wa');
  var id = $(this).data('id');
  $('.modal#userEdit1').modal('show');
  $('.modal#userEdit1 input#nama').val(nama);
  $('.modal#userEdit1 input#email').val(email);
  $('.modal#userEdit1 input#username').val(uname);
  $('.modal#userEdit1 input#id').val(id);
  $('.modal#userEdit1 input#password').val('');
  $('.modal#userEdit1 input#nomor_wa').val(nowa);
  $('.modal#userEdit1 .btnSubmit').attr('type', 'submit');
  $('.modal#userEdit1 .btnSubmit').html('Update');
})

$('#myWaSetting').click(function () {
  var id = $(this).data('id');
  $('.modal#waSetting').modal('show');
  	$.ajax({
		url: '/whatsapp/qr',
		type: 'POST',
		data: {id:id},
		dataType: 'JSON',
		success: function(result) {
		    console.log(result);
		if(result.status == false) {
			if(result.hasOwnProperty('qrcode')) {
				$('.modal#waSetting #qrImg').html('<center><img class="img-responsive" src="https://bukutamudigital.app/assets/img/design/HeaderWA.png" width="360px" height="60px" /><br /><img src="'+result.qrcode+'" /><br /><img class="img-responsive" src="https://dashboard.evvent.id/assets/img/design/FooterWA.png" width="360px" height="200px" /></center>');
				return false;
			}
			if(result.hasOwnProperty('errors')) {
				if(result.errors.hasOwnProperty('device')) {
					$('.modal#waSetting #qrImg').html('<center><img src="https://bukutamudigital.app/assets/img/design/belumkonekQR.png" width="360px" height="360px"  /></center>');
				}
			} else {
				$('.modal#waSetting #qrImg').html('<center><img src="https://bukutamudigital.app/assets/img/design/ConnectedQR.png" alt="Whatsapp sudah terkoneksi!" width="350px" height="350px" ><a href="https://app.buktamdigital.my.id/whatsapp/campaign">Mulai Whatsapp Blast</a></center>');
			}
		}
		if(result.status == 'processing') {
			$.ajax({
			    url: 'whatsapp/qr',
        		type: 'POST',
        		data: {id:id},
        		dataType: 'JSON',
				success: function (result) {
					console.log(result);
					if(result.status == false) {
						if(result.errors.device) {
							$('.modal#waSetting #qrImg').html('<center><img src="https://app.buktamdigital.my.id/assets/img/design/belumkonekQR.png" width="360px" height="360px" /></center>');
						}
						if(result.qrcode) {
							$('.modal#waSetting #qrImg').html('<img src="https://app.buktamdigital.my.id/assets/img/design/HeaderWA.png" width="360px" height="60px" /><br /><img src="'+result.qrcode+'" /><br /><img src="https://app.buktamdigital.my.id/assets/img/design/FooterWA.png" width="360px" height="200px" />');
						}
					}
					if(result.status == 'processing') {
						$('.modal#waSetting #qrImg').html('<center><img src="https://app.buktamdigital.my.id/assets/img/design/TryagainQR.png" class="img-responsive" width="360px" height="360px" /></center>');
					}
				}
			})
		}
		if(result.status == true) {
			$('.modal#waSetting #qrImg').html('Status device sudah terhubung, tetapi tampaknya tidak akan dapat mengirim pesan. Hubungi admin untuk logout device pada wagateway.evvent.id');
		}
		}
	});
})
$('#myWaNumber').click(function () {
  var id = $(this).data('id');
  $('.modal#waNumber').modal('show');
})

$('#addadmin').click(function () {
  window.location.href = UrLBase + 'user';
})

$('#addgeneratetoken').click(function () {
  window.location.href = UrLBase + 'generate';
})

$('#addgroup').click(function () {
  window.location.href = UrLBase + 'user/group';
})


$('.list-table').on('click', '#list-event .boxBtn a.btnUser', function (e) {
  e.preventDefault();
  var nama = $(this).data('nama');
  var email = $(this).data('email');
  var uname = $(this).data('uname');
  var id = $(this).data('id');
  if (id == null || id == "") {
    /*$.toast({
      heading: 'Error',
      text: 'Belum ada user di event ini!',
      showHideTransition: 'slide',
      icon: 'error',
      loaderBg: '#d4c357',
      position: 'top-center'
    });*/
     Swal.fire('Oops..', 'Belum ada user di event ini!', 'error');
  } else {
    $('.modal#userEdit').modal('show');
    $('.modal#userEdit input#nama').val(nama);
    $('.modal#userEdit input#email').val(email);
    $('.modal#userEdit input#username').val(uname);
    $('.modal#userEdit input#id').val(id);
    $('.modal#userEdit input#password').val('');
    $('.modal#userEdit .btnSubmit').attr('type', 'submit');
    $('.modal#userEdit .btnSubmit').html('Update');
  }

});




$(function () {
  $('.formInput').submit(function (e) {
    e.preventDefault();
    var txt = $('.btnSubmit').html();
    $.ajax({
      url: $(this).attr('action'),
      type: "POST",
      cache: false,
      data: $(this).serialize(),
      dataType: 'json',
      beforeSend: function () {
        $("#LoadingPage").fadeIn();
        $('.btnSubmit').html(
          '<i class="far fa-spinner fa-spin"></i> Menyimpan..');
        $('.btnSubmit').attr('type', 'button');
        $('.btnSubmit').attr('disabled', 'disabled');
        $('.btnSubmit').addClass('disabled');
      },
      success: function (json) {
        if (json.status == 1) {
          $("#LoadingPage").fadeOut();
           Swal.fire('Berhasil!', json.pesan, 'success');

          $('.btnSubmit').html(txt);
          $('.btnSubmit').attr('type', 'submit');
          $('.btnSubmit').removeAttr('disabled');
          $('.btnSubmit').removeClass('disabled');

          $('.modal#eventedit').modal('hide');
          $('.modal#eventadd').modal('hide');
          $('.modal#useradd').modal('hide');
          $('.modal#modalWa').modal('hide');
          $('.modal#userEdit').modal('hide');
          $('.modal#userEdit1').modal('hide');
          var cari = '';
          loadDataEv(cari);
          $('input#pencarian').val('');
        } else {
          $("#LoadingPage").fadeOut();
           Swal.fire('Oops..', json.pesan, 'error');

          $('.btnSubmit').html(txt);
          $('.btnSubmit').attr('type', 'submit');
          $('.btnSubmit').removeAttr('disabled');
          $('.btnSubmit').removeClass('disabled');
        }
      }
    });
  });
});



$('.list-table').on('click', '#list-event .boxBtn a.btnDel', function (e) {
  e.preventDefault();
  var url = $(this).attr('href');  console.log(url);
  Swal.fire({
    title: "Yakin Ingin Dihapus?",
    text: "Tindakan ini akan menghapus semua data tamu, Pada event INI! Lanjut?",
    type: "warning",
    showCancelButton: true,

    confirmButtonText: "Hapus!",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
	  
      $.ajax({
        url: url,
        type: "POST",
        dataType: 'JSON',
        cache: false,
        beforeSend: function () {
          $("#LoadingPage").fadeIn();
        },
        success: function () {
          $("#LoadingPage").fadeOut();
          var cari = '';
          loadDataEv(cari);
          $('input#pencarian').val('');
        }
      })
    }
  });
});


function bindDeleteButtonClick() {
  $('.btnDelBlast').click(function (e) {
    e.preventDefault();
    url = $(this).attr('href');
    Swal.fire({
       title: 'Yakin ingin hapus?',
       text: "Ini akan menghapus data whatsapp blast!",
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yaa, Hapus!',
       position: 'top-center',
       showLoaderOnConfirm: true,
    }).then((result) => {
       if (result.isConfirmed) {
         $.ajax({
           url: url,
           type: "GET",
           cache: false,
           beforeSend: function () {
             $("#LoadingPage").fadeIn();
           },
           success: function () {
                $("#LoadingPage").fadeOut();
                $('#list-table').load(window.location + ' #list-table', function() {
                    bindDeleteButtonClick();
                });
           },
           error: function () {
             showErrorAlert('Terjadi kesalahan saat mengirim data.');
           }
         });
       } else if (result.dismiss === Swal.DismissReason.cancel) {
       }
    });
  });
}

$('.btnDelBlast').click(function (e) {
    e.preventDefault();
    url = $(this).attr('href');
    Swal.fire({
       title: 'Yakin ingin hapus?',
       text: "Ini akan menghapus data whatsapp blast!",
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yaa, Hapus!',
       position: 'top-center',
       showLoaderOnConfirm: true,
    }).then((result) => {
       if (result.isConfirmed) {
         $.ajax({
           url: url,
           type: "GET",
           cache: false,
           beforeSend: function () {
             $("#LoadingPage").fadeIn();
           },
           success: function () {
                $("#LoadingPage").fadeOut();
                $('#list-table').load(window.location + ' #list-table', function() {
                    bindDeleteButtonClick();
                });
           },
           error: function () {
             showErrorAlert('Terjadi kesalahan saat mengirim data.');
           }
         });
       } else if (result.dismiss === Swal.DismissReason.cancel) {
       }
    });
});



$('.list-table').on('click', '#list-event .boxBtn a.btnEdit', function (e) {
  e.preventDefault();
  var wed = $(this).data('wed');
  var nama = $(this).data('nama');
  var tgl = $(this).data('tgl');
  var link = $(this).data('link');
  var id = $(this).data('id');
  var post = $(this).data('post');
  var url = $(this).data('url');
  var undangan_id = $(this).data('undangan_id');
  var souvenir = $(this).data('souvenir');
  var qr = $(this).data('qr');
  var fitur_meja = $(this).data('meja');
  var fitur_ampao = $(this).data('ampao');
  var fitur_sesi = $(this).data('sesi');
  console.log(souvenir)
  $('.modal#eventedit').modal('show');
  $('.modal#eventedit input#wedding').val(wed);
  $('.modal#eventedit input#namae').val(nama);
  $('.modal#eventedit input#tgl').val(tgl);
  $('.modal#eventedit input#link').val(link);
  $('.modal#eventedit #domain_id').val(undangan_id);
  $("#undangan option[value='" + undangan_id + "']").prop('selected', true);
  $('.modal#eventedit input#post').val(post);
  if(qr) {
    $('#is_qr_edit').prop('checked', true);
  } else {
	  $('#is_qr_edit').prop('checked', false);
  }
  if(fitur_meja) {
    $('#fitur_meja_edit').prop('checked', true);
  } else {
	  $('#fitur_meja_edit').prop('checked', false);
  }
  if(fitur_ampao) {
    $('#fitur_ampao_edit').prop('checked', true);
  } else {
	  $('#fitur_ampao_edit').prop('checked', false);
  }
  if(fitur_sesi) {
    $('#fitur_sesi_edit').prop('checked', true);
  } else {
	  $('#fitur_sesi_edit').prop('checked', false);
  }
  $('.modal#eventedit #url').val(url);
  $('.modal#eventedit input#id').val(id);
  $('.modal#eventedit .btnSubmit').attr('type', 'submit');
  $('.modal#eventedit .btnSubmit').html('Update');
});


$('.list-table').on('click', '#list-event .boxBtn a.btnWa', function (e) {
  e.preventDefault();
  var id = $(this).data('id');
  $.ajax({
    url: $(this).attr('href'),
    type: 'POST',
    dataType: 'JSON',
    data: {
      id: id
    },
    cache: false,
    beforeSend: function () {
      $("#LoadingPage").fadeIn();
    },
    success: function (json) {
      if (json.kode == 1) {
        $("#LoadingPage").fadeOut();
        $('.modal#modalWa').modal('show');
        $('.modal#modalWa input#id').val(id);
        $('.modal#modalWa textarea#pesan').val(json.pesan);
        $('.modal#modalWa .btnSubmit').attr('type', 'submit');
      } else {
        $("#LoadingPage").fadeOut();
      }
    }
  })
});




$('.list-table').on('click', '#list-event .figura span', function (e) {
  e.preventDefault();
  var img = $(this).data('img');
  var id = $(this).data('id');
  $('.modal#modalImage').modal('show');
  $('.modal#modalImage input#poto').val('');
  $('.modal#modalImage img#preview').attr('src', img);
  $('.modal#modalImage input#id').val(id);
  $('.modal#modalImage .btnSubmit').attr('type', 'submit');
});


$('.formInput2').submit(function (e) {
  e.preventDefault();
  var btn = $('.modal#modalImage .btnSubmit');
  var id = $('.formInput2 input#id').val();
  var pot = $('.formInput2 input#poto').val();
  const fileupload = $('.formInput2 input#poto').prop('files')[0];

  if (pot == '' || pot == null) {
    /*$.toast({
      heading: 'Error',
      text: 'Pilih Poto yang mau di upload',
      showHideTransition: 'slide',
      icon: 'error',
      loaderBg: '#d4c357',
      position: 'top-center'
    });*/
    Swal.fire('Oops..', 'Pilih foto yang mau di upload', 'error');
    return false;
  }

  var formData = new FormData();
  formData.append('poto', fileupload);
  formData.append('id', id);



  $.ajax({
    url: UrLBase + 'seting/editPoto',
    type: "POST",
    data: formData,
    dataType: 'json',
    cache: false,
    processData: false,
    contentType: false,
    beforeSend: function () {
      $("#LoadingPage").fadeIn();
      btn.html(
        '<i class="far fa-spinner fa-spin"></i> Menyimpan..');
      btn.attr('type', 'button');
      btn.attr('disabled', 'disabled');
      btn.addClass('disabled');
    },
    success: function (respon) {
      if (respon.kode == 1) {
        $("#LoadingPage").fadeOut();
        $('.modal#modalImage').modal('hide');
         Swal.fire('Berhasil!', respon.pesan, 'success');
        btn.html('Update');
        btn.attr('type', 'submit');
        btn.removeAttr('disabled');
        btn.removeClass('disabled');
        var cari = '';
        loadDataEv(cari);
        $('input#pencarian').val('');
        return false;
      } else {
        Swal.fire('Oops..', respon.pesan, 'error');
        btn.html('Update');
        btn.attr('type', 'submit');
        btn.removeAttr('disabled');
        btn.removeClass('disabled');
        $("#LoadingPage").fadeOut();
        return false;
      }
    }
  })
})


$('.formInput2 .btnUpload').on('click', function () {
  $('.formInput2 input#poto').click();
})


function readURL(input) {
  var url = input.value;
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
  if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('.modal#modalImage img#preview').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  } else {
    $('.modal#modalImage img#preview').attr();
  }
}


let isDown = false;
let startX;
let scrollLeft;
const slider = document.querySelector('.tabs-box');

const end = () => {
	isDown = false;
  slider.classList.remove('active');
}

const start = (e) => {
  isDown = true;
  slider.classList.add('active');
  startX = e.pageX || e.touches[0].pageX - slider.offsetLeft;
  scrollLeft = slider.scrollLeft;	
}

const move = (e) => {
	if(!isDown) return;

  e.preventDefault();
  const x = e.pageX || e.touches[0].pageX - slider.offsetLeft;
  const dist = (x - startX);
  slider.scrollLeft = scrollLeft - dist;
}

(() => {
	slider.addEventListener('mousedown', start);
	slider.addEventListener('touchstart', start);

	slider.addEventListener('mousemove', move);
	slider.addEventListener('touchmove', move);

	slider.addEventListener('mouseleave', end);
	slider.addEventListener('mouseup', end);
	slider.addEventListener('touchend', end);
})();



