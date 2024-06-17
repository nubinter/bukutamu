
function loadKomen() {

  var filter = $('.count-guest select#filter').val();
  $.ajax({
    url: UrLBase + 'comment/loadListKomen',
    type: "post",
    data: { filter: filter },
    dataType: "JSON",
    cache: false,
    beforeSend: function () {
      $("#LoadingPage").fadeIn();
    },
    success: function (json) {
      if (json.kode == 1) {
        $("#LoadingPage").fadeOut();
        $('.list-comment ul').html(json.list)
        $('.count-comment .count#total').html(json.total)
        $('.count-comment .count#hadir').html(json.hadir)
        $('.count-comment .count#tidak').html(json.tidak)
        $('.count-comment .count#ragu').html(json.ragu)
        $('.count-guest .btn-custom').show();
        $('input#undangan').val(json.undangan);

      } else {
        $("#LoadingPage").fadeOut();
        $('.count-guest .btn-custom').hide();
        /*$.toast({
          heading: 'Error',
          text: json.pesan,
          showHideTransition: 'slide',
          icon: 'error',
          loaderBg: '#d4c357',
          position: 'top-center'
        });*/
        Swal.fire('Error', json.pesan, 'error');
      }
    }
  })

  console.log(filter)

}



$('.count-guest select#filter').change(function () {
  loadKomen();
})



$(document).ready(function () {
  loadKomen();
})

$('.list-comment ul').on('click', 'span.title', function () {
  var udg = $('input#undangan').val();
  window.open(udg, 'blank');
})

$('.list-comment ul').on('click', 'span.sub-title', function () {
  var udg = $('input#undangan').val();
  window.open(udg, 'blank');
})



$('.list-comment ul').on('click', '.btnDelete', function (e) {
  e.preventDefault();
  var id = $(this).data('id');
  $.ajax({
    url: UrLBase + 'comment/deleteKomen/' + id,
    cache: false,
    beforeSend: function () {
      $("#LoadingPage").fadeIn();
    },
    success: function (res) {
      if (res == 1) {
        // $("#LoadingPage").fadeOut();
        loadKomen();
      } else {
        loadKomen();
        $("#LoadingPage").fadeOut();
        /*$.toast({
          heading: 'Error',
          text: "silahkan DIULANG!",
          showHideTransition: 'slide',
          icon: 'error',
          loaderBg: '#d4c357',
          position: 'top-center'
        });*/
        Swal.fire('Error', 'Silahkan di ulang!', 'error');
      }
    }
  })
})