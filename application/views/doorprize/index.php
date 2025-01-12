<div class="content">
	<div class="prieview-welcome">
		<h2 class="view-welcome" style="color: #000333;">Pengaturan Doorprize</h2>
		<label for="wel">Preview Background Doorprize</label>
		<img src="<?= base_url('assets/img/doorprize/frame/' . $doorprize['frame']) ?>" alt="">
	</div>
	<div class="row mt-4">
		<div class="col-sm-6">
		  <div class="form-group">
			<button class="btn btn-outline-custom btn-block rounded-pill btnUpload">Unggah Backgound</button>
			<input style="display: none;" oninput="readURL(this)" type="file" accept="image/*" name="bg" id="bg">
		  </div>
		</div>
		<div class="col-sm-6">
		  <div class="form-group">
			<button class="btn btn-outline-custom btn-block rounded-pill btnUpload">Unduh Sample Backgound</button>
		  </div>
		</div>
	</div>
	<div class="row mt-4">
		<div class="col-12">
		  <div class="form-group">
			<button class="btn btn-outline-custom btn-block rounded-pill btnUpload">Tambah Hadiah</button>
		  </div>
		</div>
	</div>
	<div class="card mt-1 mb-3">
		<div class="card-header">
			<div class="count-guest"><span>Daftar Hadiah</span></div>
		</div>
		<div class="card-body" id="respons">
		</div>
	</div>
  <div class="row mt-4">
    <div class="col-sm-12">
      <div class="form-group">
        <label for="wel">Text Judul</label>
        <input type="text" name="wel" id="wel" class="form-control" required
          value="<?= $doorprize['text_judul'] ?>">
      </div>
    </div>

    <div class="col-sm-6">
      <div class="form-group">
        <label for="warna">Warna Text</label>
        <input type="color" name="warna" id="warna" class="form-control" required
          value="<?= $doorprize['warna_text'] ?>">
      </div>
    </div>    
	
	<div class="col-sm-6">
      <div class="form-group">
        <label for="warna">Warna Dasar</label>
        <input type="color" name="warna" id="warna" class="form-control" required
          value="<?= $doorprize['warna_dasar'] ?>">
      </div>
    </div>

    <div class="col-sm-12">
      <div class="form-group mt-4">
        <button data-id="<?= $doorprize['id'] ?>" class="btn btn-warning btn-block rounded-pill px-4 font-weight-bold btnSubmit">Simpan Pembaruan</button>
        <!--<button onclick="openWelcome()" class="btn px-4 rounded-pill float-right btn-custom btnView">Preview</button>-->
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('template/footer'); ?>





<script>

var UrLBase = '<?= base_url() ?>';
barisList();
function barisList() {
  $.ajax({
    url: UrLBase + 'doorprize/load_hadiah',
    type: "POST",
    dataType: "JSON",
    data: {
      id: <?=$doorprize['id']?>
    },
    cache: false,
    success: function (respon) {
      $("#LoadingPage").fadeOut();
	  $('#respons').html(respon.hadiah);
      if (respon.totalRecord <= 0) {
        $('#respons').html('<center><img src="<?= base_url('assets/img/page/belumadadatatamu.png') ?>" alt="Tidak ada data!" width="300px" height="209px" ></center>');
      }
      console.log(respon.totalRecord)
    }
  });
}

</script>

<script src="<?= base_url('assets/custom/js/sapa.js?v=' . fileatime('assets/custom/js/sapa.js')) ?>"></script>
