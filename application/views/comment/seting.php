<div class="content">

  <div class="row">
    <div class="col-12">
      <div class="mt-5">
        <a href="<?= base_url('generate') ?>" class="float-right btn-outline-custom btn mb-3" target="_blank">Generate
          Token</a>
        <h5>Setting Token</h5>
      </div>
    </div>
  </div>


  <div class="card">
    <div class="card-body">
      <div class="form-group mb-4">
        <label for=""><span class="badge badge-custom"><?= $listUndangan['url'] ?></span></label>
        <div class="input-group">
          <input type="text" name="token" id="token" data-id="<?= $listUndangan['id'] ?>" readonly class="form-control"
            value="<?= $listUndangan['token'] ?>" placeholder="Kode Url">
          <div class="input-group-append">
            <button class="btn btn-secondary" onclick="pastee()" id="Paste">Paste</button>
          </div>
        </div>
      </div>


    </div>
  </div>

</div>


<?php $this->load->view('template/footer'); ?>


<script>
var UrLBase = '<?= base_url() ?>';
</script>


<script>
async function pastee() {
  const pasteText = await navigator.clipboard.readText();
  $('#token').val(pasteText);
  $('#token').focus();
  $('#Paste').html('Save');
  $('#Paste').removeClass('btn-secondary');
  $('#Paste').addClass('btn-info');
}


$('#Paste').on('click', function(e) {
  if ($(this).html() == 'Save') {
    var id = $('#token').data('id');
    var token = $('#token').val();
    if (token == "" || token == null) {
      $.toast({
        heading: 'Error',
        text: 'Kode URL tidak boleh kosong',
        showHideTransition: 'slide',
        icon: 'error',
        loaderBg: '#d4c357',
        position: 'top-center'
      });
      $(this).focus();
      return false;
    }

    $.ajax({
      url: UrLBase + 'comment/addToken',
      type: "POST",
      data: {
        id: id,
        token: token
      },
      cache: false,
      beforeSend: function() {
        $("#LoadingPage").fadeIn();
      },
      success: function(res) {
        if (res == 1) {
          $("#LoadingPage").fadeOut();
          document.location.reload();
          return false;
        } else {
          $("#LoadingPage").fadeOut();
          $.toast({
            heading: 'Error',
            text: 'Silahkan diulang',
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#d4c357',
            position: 'top-center'
          });
          $(this).focus();
          return false;
        }

      }
    })
  }
})
</script>