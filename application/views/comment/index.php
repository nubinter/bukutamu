<div class="content">


  <!--<h4 class="mt-3">RSVP & Ucapan</h4>-->
  
  <h6 class="ml-3 content-title" style="padding-top: 12px;">
      <img src="https://app.buktamdigital.my.id/assets/img/design/wedding-card.png" alt="Data Tamu" style="width: 27px; height: 27px; margin-right: 5px;">
       RSVP/Ucapan
      </h6>
  
  <input type="text" id="undangan" hidden>

  <div class="box-count-comment">

    <div class="count-comment">
      <span class="count" id="total">0</span>
      <span class="lbl">Komentar</span>
    </div>

    <div class="count-comment">
      <span class="count" id="hadir">0</span>
      <span class="lbl">Hadir</span>
    </div>

    <div class="count-comment">
      <span class="count" id="tidak">0</span>
      <span class="lbl">Tidak Hadir</span>
    </div>

  </div>

  <div class="card mt-1 mb-3 shadow-sm">
    <div class="card-header">
      <div class="count-guest">
        <span class="float-right"><a target="_blank" href="<?= base_url('comment/export/') ?>"
            class="btn btn-custom text-12"><i class="far fa-file-pdf"></i>
            Export PDF</a></span>
        <select class="form-control d-inline" style="max-width: 200px;" id="filter">
          <option value="All">Pilih Konfirmasi</option>
          <option value="Hadir">Hadir</option>
          <option value="Tidak hadir">Tidak Hadir</option>
          <option value="Masih Ragu">Masih Ragu</option>
        </select>
      </div>
    </div>
    <div class="card-body">
      <div class="list-comment">
        <ul>


          <li>
            <span class="title">Maaf, komentar tidak dapat dimunculkan, Harap periksa kembali ID Undangan atau kamu tidak termasuk dalam paket fitur ini.</span>
          </li>

        </ul>
      </div>
    </div>

    <!-- <div class="card-footer">

      <div class="pagination-custom">
        <ul>
          <li class="pagina-left"><i class="far fa-chevron-left"></i></li>
          <li class="pagina-number">1</li>
          <li class="pagina-right"><i class="far fa-chevron-right"></i></li>
        </ul>
      </div>

    </div> -->

  </div>

</div>


<?php $this->load->view('template/footer'); ?>


<script>
var UrLBase = '<?= base_url() ?>';
</script>

<script src="<?= base_url('assets/custom/js/comment.js?v=' . fileatime('assets/custom/js/comment.js')) ?>"></script>