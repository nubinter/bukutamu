$('.content .tblKode').on('click', function () {
  $('.modal#myModal').modal('show');
  var kode = $(this).data('kode');
  $('.modal#myModal .modal-title').html('Access Code');
  $('.modal#myModal .modal-body #kodeAkses').html(kode);
})



$(document).ready(function () {
  $("#LoadingPage").fadeOut();
});



$('.list-table ul').on('click', 'li .title', function () {
  $(this).parent('li').toggleClass('active');
})

$('.list-table ul').on('click', 'li .sub-title', function () {
  $(this).parent('li').toggleClass('active');
})

