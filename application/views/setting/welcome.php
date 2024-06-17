<div class="content">

  <div class="prieview-welcome">
    <h2 class="view-welcome" style="color: #000333;">Pengaturan Layar Sapa</h2>


<label for="wel">Preview Background Layar Sapa</label>
    <img src="<?= base_url('assets/img/event/' . $wel['bg']) ?>" alt="">
  </div>


  <div class="row mt-4">

    <div class="col-sm-12">
      <div class="form-group">
        <label for="wel">Kalimat Sapaan</label>
        <input type="text" name="wel" id="wel" data-id="<?= $wel['id'] ?>" class="form-control" required
          value="<?= $wel['welcome'] ?>">
      </div>
    </div>

    <div class="col-sm-6">
      <div class="form-group">
        <label for="warna">Warna Text</label>
        <input type="color" name="warna" id="warna" data-id="<?= $wel['id'] ?>" class="form-control" required
          value="<?= $wel['color'] ?>">
      </div>
    </div>

    <div class="col-sm-6">
      <div class="form-group">
        <label for="bg">Background Layar Sapa</label>
        <button class="btn btn-outline-custom btn-block rounded-pill btnUpload">Unggah Backgound</button>
        <input style="display: none;" oninput="readURL(this)" type="file" accept="image/*" name="bg" id="bg">
      </div>
    </div>


    <div class="col-sm-12">
      <div class="form-group mt-4">
        <button data-id="<?= $wel['id'] ?>" class="btn btn-warning btn-block rounded-pill px-4 font-weight-bold btnSubmit">Simpan Pembaruan</button>
        <!--<button onclick="openWelcome()" class="btn px-4 rounded-pill float-right btn-custom btnView">Preview</button>-->
      </div>
    </div>



  </div>




</div>





<?php $this->load->view('template/footer'); ?>


<script>
var UrLBase = '<?= base_url() ?>';
</script>

<script src="<?= base_url('assets/custom/js/sapa.js?v=' . fileatime('assets/custom/js/sapa.js')) ?>"></script>

<script>
function openWelcome() {
  window.open(UrLBase + 'welcome/welcome_view', '_blank')
}
</script>