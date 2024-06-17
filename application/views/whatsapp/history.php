<div class="content">
  <div class="d-block text-center">

  </div>
  <div class="row mt-3">

    <div class="col-6">
      <h6 class="ml-3 content-title">History Undangan</h6>
    </div>
    <div class="col-6">
    </div>
  </div>
  <div class="card mt-1 mb-3 shadow-sm">
    <div class="card-header">
      <div class="row">
        <div class="col-6">

          <div class="roundedOne d-inline-block">
            <input type="checkbox" value="" id="roundedOne" name="check" />
            <label for="roundedOne"></label>
          </div>

          <div class="dropdown d-inline-block ml-2">
            <a class="dropdown-toggle btnIconOption px-4" type="button" id="dropdownMenuButton" data-toggle="dropdown"
              aria-expanded="false">
              <i class="far fa-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" id="btnWaSelected" href="#">Kirim via WhatsApp (Auto)</a>
            </div>
          </div>
        </div>

        <div class="col-6 text-right">
        </div>

      </div>

    </div>
    <div class="card-body">
      <div class="list-table">
        <div class="search">
          <input type="text" placeholder="search..." id="pencarian">
          <i class="fa fa-search"></i>
        </div>
        <ul>
          <li><span class="sub-title">Sedang memuat...</span></li>
        </ul>
      </div>
    </div>

    <div class="card-footer">

      <div class="pagination-custom">
        <ul>
          <li class="pagina-left"><i class="far fa-chevron-left"></i></li>
          <li class="pagina-number">1</li>
          <li class="pagina-right"><i class="far fa-chevron-right"></i></li>
        </ul>
      </div>

    </div>
  </div>



</div>

<!-- Modal -->
<div class="modal fade" id="modalWa" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalWaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalWaLabel">Text Message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group mb-4">
          <label for="pesan" class="text-custom">Message</label>
          <textarea id="pesan" rows="6" class="form-control"></textarea>
        </div>

        <div class="form-group">
          <button type="button" class="btn btn-block btn-custom rounded-pill" onclick="copyTeks()">Copy</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalSelectedBlast" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalWaBlastLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalWaLabel">WhatsApp Blast</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="form-group">
              <select id="sender_select" class="form-control">
                <?php foreach($senders as $sender) : ?>
                <?php
    		        if($sender['status'] == 'authenticated') {
    		            $disabled = '';
    		            $status = 'Terhubung';
    		        } else {
    		            $disabled = 'disabled';
    		            $status = 'Tidak Terhubung';
    		        }
    		    ?>
                <option value="<?= $sender['nomor_wa'] ?>" <?=$disabled?>><?= $sender['nomor_wa'] ?> (<?=$status?>)</option>
                <?php endforeach; ?>
              </select>
          </div>
          <!--<div class="form-group">
            <label for="pesan">Schedule (Kosongkan Untuk Kirim Sekarang)</label>
            <input type="datetime-local" name="schedule" id="schedule" class="form-control">
          </div>-->
          <div class="form-group mt-4">
            <button type="submit" class="btn btn-outline-custom rounded-pill btn-block btnSubmit" id="saveBlast">Save</button>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalSendWa" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalGroupLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="modalGroupLabel">Kirim Undangan Via Whatsapp</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="hidden" id="id_tamu" value="" />
          <select id="sender_select2" class="form-control">
            <?php foreach($senders as $sender) : ?>
            <?php
		        if($sender['status'] == 'authenticated') {
		            $disabled = '';
		            $status = 'Terhubung';
		        } else {
		            $disabled = 'disabled';
		            $status = 'Tidak Terhubung';
		        }
		    ?>
            <option value="<?= $sender['nomor_wa'] ?>" <?=$disabled?>><?= $sender['nomor_wa'] ?> (<?=$status?>)</option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill px-4" id="kirimWa">Kirim</button>
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('template/footer'); ?>


<script>
var UrLBase = '<?= base_url() ?>';
var carinya = '';

$('#roundedOne').click(function () {
  var ck = $(this);
  if (ck.prop('checked')) {
    $('.list-table ul li').addClass('active')
  } else {
    $('.list-table ul li').removeClass('active')
  }
});

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

$('#btnWaSelected').click(function () {
    var idnya = [];
    $('.list-table ul li.active input#idreceiver').each(function () {
        idnya.push(this.value);
    });
    $('#roundedOne').removeAttr('checked');
    if (idnya == "" || idnya == null) {
        Swal.fire('Error', 'Select Data', 'error');
        $('#roundedOne').removeAttr('checked');
        return false;
    } else {
        $('.modal#modalSelectedBlast').modal('show');
    }
})

$('#saveBlast').click(function () {
    const sender = document.getElementById("sender_select").value;
    var idnya = [];
    $('.list-table ul li.active input#idreceiver').each(function () {
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
         event_id: <?=$campaign['event_id']?>
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


$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnWaAuto', function (e) {
  e.preventDefault();
  $('.list-table ul li').removeClass('active');
  var id = $(this).data('id');
  $('#id_tamu').val(id);
  $('.modal#modalSendWa').modal('show');
})


$('#kirimWa').click(function (e) {
  e.preventDefault();
  $('#kirimWa').html('loading...');
  const id = document.getElementById('id_tamu').value;
  const sender = document.getElementById("sender_select2").value;
  $('.modal#modalSendWa').modal('hide');
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

$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnWa', function (e) {
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

$(document).ready(function () {
  var num = $('.pagination-custom .pagina-number').html();
  var cari = $('input#pencarian').val();
  barisList(num, cari);
});

function barisList(num, cari) {
  $.ajax({
    url: UrLBase + 'whatsapp/load_history/<?=$blast_id?>',
    type: "POST",
    dataType: "JSON",
    data: {
      page: num,
      cari: cari,
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
        $('.list-table ul').html('<p class="text-center mt-4">Tidak ada data!</p>');
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

</script>