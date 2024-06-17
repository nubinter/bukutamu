$('input#wel').on('blur', function () {
  var txt = $(this).val();
  var id = $(this).data('id');
  updateWel(id, txt, 'welcome');
})


$('input#warna').on('change', function () {
  var cl = $(this).val();
  var id = $(this).data('id');
  updateWel(id, cl, 'color');
})


$('.btnUpload').on('click', function () {
  $('input#bg').click();
})


function updateWel(id, isi, key) {
  $.ajax({
    url: UrLBase + 'seting/updateWelcome',
    type: 'post',
    data: {
      id: id,
      isi: isi,
      key: key
    },
    cache: false,
    beforeSend: function () {
      $("#LoadingPage").fadeIn();
    },
    success: function () {
      $("#LoadingPage").fadeOut();
    }
  })
}




function readURL(input) {
  var url = input.value;
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
  if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('.prieview-welcome img').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  } else {
    $('.prieview-welcome img').attr();
  }
}



$('.btnSubmit').on('click', function () {
  var btn = $(this);
  var id = $(this).data('id');
  var pot = $('input#bg').val();
  const fileupload = $('input#bg').prop('files')[0];

  if (pot == '' || pot == null) {
    
    Swal.fire('Pembaruan berhasil!', 'Perubahan telah disimpan', 'success');
    return false;
  }

  var formData = new FormData();
  formData.append('poto', fileupload);
  formData.append('id', id);



  $.ajax({
    url: UrLBase + 'seting/editBg',
    type: "POST",
    data: formData,
    dataType: 'json',
    cache: false,
    processData: false,
    contentType: false,
    beforeSend: function () {
      $("#LoadingPage").fadeIn();
      btn.html(
        '<i class="far fa-spinner fa-spin"></i>');
      btn.attr('disabled', 'disabled');
      btn.addClass('disabled');
    },
    success: function (respon) {
      if (respon.kode == 1) {
        $("#LoadingPage").fadeOut();
        /*$.toast({
          heading: 'Success',
          text: respon.pesan,
          showHideTransition: 'slide',
          icon: 'success',
          loaderBg: '#d4c357',
          position: 'top-center'
        });*/
        Swal.fire('Pembaruan Berhasil', respon.pesan, 'success');
        btn.html('Update');
        btn.removeAttr('disabled');
        btn.removeClass('disabled');
        $('input#bg').val("");
        return false;
      } else {
        /*$.toast({
          heading: 'Error',
          text: respon.pesan,
          showHideTransition: 'slide',
          icon: 'error',
          loaderBg: '#d4c357',
          position: 'top-center'
        }); */
        Swal.fire('Opps!', respon.pesan, 'error');
        btn.html('Update');
        btn.removeAttr('disabled');
        btn.removeClass('disabled');
        $("#LoadingPage").fadeOut();
        return false;
      }
    }
  })
})