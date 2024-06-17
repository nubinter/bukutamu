<div class="content">
    

  <div class="d-block text-center">
    <div class="box-manten box-dua shadow">
      <p id="wed"><?= $event['wedding'] ?></p>
      <h2><?= $event['nama'] ?></h2>
      <p id="dt"><?= $this->m_time->longDate($event['tgl']) ?></p>
    </div>
  </div>

  <div class="card mt-1 mb-3 shadow-sm">
    <div class="card-header">
      <div class="row">
        <div class="col">
            <span class="align-middle text-white">Grup Tamu</span>
        </div>
        

        <div class="col text-right">
            <a class="btn btn-warning btn-sm" id="btnAdd" href="#"><i class='fa fa-plus-circle' style="font-size: 12px;"></i> Tambah Grup</a>
        </div>

      </div>

    </div>
    <div class="card-body">
      <div class="list-table">
        <ul>
          <li><span class="sub-title">Sedang memuat...</span></li>
        </ul>
      </div>
    </div>

    <div class="card-footer">
    </div>
  </div>



</div>





<style>
  .required:after {
    content:" *";
    color: red;
  }
</style>




<!-- Modal -->
<div class="modal fade" id="modaladd" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modaladdLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaladdLabel">Buat Grup Tamu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('tamu/addGroup/'.$event['id']) ?>" method="post" class="formInput">
          <div class="form-group">
            <label for="nama" class="text-custom required">Nama Grup</label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Isikan Nama Grup Tamu" required oninvalid="this.setCustomValidity('Nama grup harus diisi!')" oninput="this.setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="kode" class="text-custom required">Kode Unik Grup</label>
            <input type="number" class="form-control" name="kode" id="kode" placeholder="Contoh : 1" required min="1" oninvalid="this.setCustomValidity('Kode unik harus diisi!')" oninput="this.setCustomValidity('')" >
			<div id="hasil-cek-kode"></div>
          </div>
          <div class="form-group">
            <label for="deskripsi" class="text-custom">Deskipsi Grup (opsional)</label>
            <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Isikan dengan deskripsi singkat grup tamu"></textarea>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-warning btn-block rounded-pill px-4 font-weight-bold btnSubmit">Tambahkan Grup</button>
            <button type="button" class="btn btn-light btn-block rounded-pill px-4" data-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modaledit" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modaleditLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaleditLabel">Perbarui Data Grup</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('tamu/editGroup') ?>" method="post" class="formInput">
          <div class="form-group">
            <label for="nama" class="text-custom required">Nama Grup</label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Isikan Nama Grup Tamu" required oninvalid="this.setCustomValidity('Nama grup harus diisi!')" oninput="this.setCustomValidity('')">
          </div>
          <div class="form-group">
            <label for="kode" class="text-custom required">Kode Unik Grup</label>
            <input type="number" class="form-control" name="kode" id="kode" placeholder="Contoh : angka 1 sampai 9" required min="1" oninvalid="this.setCustomValidity('Kode unik harus diisi!')" oninput="this.setCustomValidity('')">
			<div id="hasil-cek-kode"></div>
          </div>
          <div class="form-group">
            <label for="deskripsi" class="text-custom">Deskipsi Grup (opsional)</label>
            <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Isikan dengan deskripsi singkat grup tamu"></textarea>
          </div>
          <input type="text" id="id" name="id" style="display: none;">
          <div class="form-group">
            <button type="submit" class="btn btn-warning btn-block rounded-pill px-4 font-weight-bold btnSubmit">Perbarui Grup Tamu</button>
            <button type="button" class="btn btn-light btn-block rounded-pill px-4" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>



<?php $this->load->view('template/footer'); ?>


<script>
var UrLBase = '<?= base_url() ?>';
$(document).ready(function () {
  barisList('<?=$event['id']?>');
});

</script>

<script src="<?= base_url('assets/custom/js/grup.js?v=' . fileatime('assets/custom/js/grup.js')) ?>"></script>