<div class="content">




  <div class="row mt-3">

    <div class="col-4 kehadiran">
      <div class="box-count" style="margin-right: -10px;">
        <span class="jml" id="jmlu">0</span>
        <span>UNDANGAN</span>
      </div>
    </div>

    <div class="col-4 kehadiran">
      <div class="box-count" style="margin-left: -10px;margin-right: -10px;">
        <span class="jml" id="jmlh">0</span>
        <span>HADIR</span>
      </div>
    </div>

    <div class="col-4 kehadiran">
      <div class="box-count" style="margin-left: -10px;">
        <span class="jml" id="jmluh">0</span>
        <span>JML TAMU</span>
      </div>
    </div>


    <div class="col-4 tidakKehadiran">
      <div class="box-count" style="margin-right: -10px;">
        <span class="jml" id="jmlu">0</span>
        <span>UNDANGAN</span>
      </div>
    </div>

    <div class="col tidakKehadiran">
      <div class="box-count" style="margin-left: -10px;">
        <span class="jml" id="jmlt">0</span>
        <span>TIDAK HADIR</span>
      </div>
    </div>




    <div class="col-12">
      <ul class="menu-btn-page">
        <li class="active"><a data-id="1" href="">Tamu Hadir</a></li>
        <li><a data-id="2" href="">Tidak Hadir</a></li>
        <p style="display: none;">1</p>
      </ul>
    </div>

  </div>

  <div class="card mt-1 mb-3 shadow-sm">
    <div class="card-header py-0">
      <ul style="list-style: none;display: flex;" class="pt-3 text-12">
        <li class="mr-2 p-1 px-3 bg-custom rounded-pill"><a id="btnPdf" href=""
            class="text-decoration-none text-white"><i class="far fa-file-pdf"></i>
            Pdf</a></li>
        <li class="mr-2 p-1 px-3 bg-custom rounded-pill"><a id="btnExcel" href=""
            class="text-decoration-none text-white"><i class="far fa-file-excel"></i>
            Excel</a></li>
        <li class="mr-1 p-1 px-3 bg-custom rounded-pill"><a id="btnGroup" href=""
            class="text-decoration-none text-white"><i class="far fa-list-alt"></i>
            All Group</a></li>
      </ul>
      <input type="text" id="group" hidden>

    </div>
    <div class="card-body">
      <div class="list-table">
        <div class="search">
          <input type="text" placeholder="search..." id="pencarian">
          <i class="fa fa-search"></i>
        </div>
        <ul>
          <li><span class="sub-title">Loading...</span></li>
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
<div class="modal fade" id="modalGroup" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalGroupLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="modalGroupLabel">Filter Group</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <select id="grouptamu" class="form-control">
            <option value="">All Group</option>
            <?php foreach($group as $grp) : ?>
            <option value="<?= $grp['id'] ?>"><?= $grp['nama'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<?php $this->load->view('template/footer'); ?>

<script>
var UrLBase = '<?= base_url() ?>';
var carinya = '';
</script>

<script src="<?= base_url('assets/custom/js/report.js?v=' . fileatime('assets/custom/js/report.js')) ?>"></script>