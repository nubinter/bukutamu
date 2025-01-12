
$(document).ready(function () {
  var num = $('.pagination-custom .pagina-number').html();
  var cari = $('input#pencarian').val();
  var hadir = $('.menu-btn-page p').text();
  var group = $('input#group').val();
  barisList(num, cari, hadir, group);
});


$('input#pencarian').keyup(function () {
  var src = $(this).val();
  var num = 1;
  $('.pagination-custom .pagina-number').html(1);

  var hadir = $('.menu-btn-page p').text();
  var group = $('input#group').val();
  barisList(num, src, hadir, group);
})



$('.menu-btn-page li a').click(function (e) {
  e.preventDefault();
  var id = $(this).data('id');
  $('.menu-btn-page li').removeClass('active');
  $('.menu-btn-page p').text(id);
  $(this).parent().addClass('active');
  if (id == '1') {
    $('.tidakKehadiran').hide();
    $('.kehadiran').show();
    var num = $('.pagination-custom .pagina-number').html();
    var cari = $('input#pencarian').val();
    var hadir = id;
    var group = $('input#group').val();
    barisList(num, cari, hadir, group);
  } else {
    $('.kehadiran').hide();
    $('.tidakKehadiran').show();
    var num = $('.pagination-custom .pagina-number').html();
    var cari = $('input#pencarian').val();
    var hadir = id;
    var group = $('input#group').val();
    barisList(num, cari, hadir, group);
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
  var hadir = $('.menu-btn-page p').text();
  var group = $('input#group').val();
  barisList(plus, cari, hadir, group);
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
  var hadir = $('.menu-btn-page p').text();

  var group = $('input#group').val();
  barisList(plus, cari, hadir, group);
})





function barisList(num, cari, hadir, group) {
  $.ajax({
    url: UrLBase + 'tamu/loadReportTamu',
    type: "POST",
    dataType: "JSON",
    data: {
      page: num,
      cari: cari,
      hadir: hadir,
      group: group
    },
    cache: false,
    beforeSend: function () {
      $("#LoadingPage").fadeIn();
    },
    success: function (respon) {
      $("#LoadingPage").fadeOut();
      $('.box-count #jmlh').html(respon.totalHadir);
      if (hadir == '1') {
        $('.box-count #jmluh').html(respon.totalData);
        $('.box-count #jmlt').html(0);
      } else {
        $('.box-count #jmluh').html(0);
        $('.box-count #jmlt').html(respon.totalData);
      }
      $('.box-count #jmlu').html(respon.totalUndangan);
      $('.list-table ul').html(respon.listPage);
      $('.pagination-custom .pagina-right').removeClass('disabled');
      if (respon.totalRecord <= 0) {
        $('.list-table ul').html('<center><img src="' + UrLBase +'assets/img/page/belumadatamu.png" alt="Tidak ada data!" width="300px" height="300px" ></center>');
        $('.pagination-custom .pagina-number').html(1);
      }
      var pg = Number(num);
      var jd = Number(respon.totalData / pg);
      if (respon.totalRecord < 18 || jd <= 18) {
        $('.pagination-custom .pagina-right').addClass('disabled');
      }
      console.log(respon.totalRecord)
    }
  });
}

$('#btnExcel').click(function (e) {
  e.preventDefault();
  var id = $('.menu-btn-page p').text();
  group = $('#grouptamu').val();
  window.open(UrLBase + 'tamu/excel/'+id+'/'+group);
})

$('#btnPdf').click(function (e) {
  e.preventDefault();
  var id = $('.menu-btn-page p').text();
  group = $('#grouptamu').val();
  window.open(UrLBase + 'tamu/exportPdf/'+id+'/'+group, '_blank');
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
  var hadir = $('.menu-btn-page p').text();
  var group = id;
  barisList(num, cari, hadir, group);
})