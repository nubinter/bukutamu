</div>
</div>
<br />
<br />
<!-- Modal -->
<div class="modal fade" id="pencarianTamu" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="pencarianTamuLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pencarianTamuLabel">Cari Tamu Terdaftar</h5>
        <button type="button" class="close closedModalCari" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control" id="cariNamaTamu" placeholder="Ketikan nama tamu">
          <span class="mencariData text-info text-9">Mencari data.....</span>
        </div>

        <hr>

        <div class="menu-pencarian"></div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill text-14 px-4 closeModal closedModalCari"
          data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalManual" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="modalManualLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalManualLabel">Check-in Tamu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="<?= base_url('home/manual') ?>" method="post" id="formTamuManual">

          <div class="form-group mb-4">
            <label for="nama" class="text-custom">Nama</label>
            <input type="text" class="form-control" name="nama" id="nama" value="" placeholder="Nama Tamu" autofocus required>
          </div>

          <div class="form-group mb-4">
            <label for="alamat" class="text-custom">Alamat</label>
            <input type="text" class="form-control" name="alamat" id="alamat" value="" placeholder="Alamat Tamu"
              required>
          </div>

          <div class="form-group mb-4">
            <label for="vip" class="text-custom">VIP</label>
            <select name="vip" id="vip" class="form-control">
              <option value="1">Ya</option>
              <option selected value="0">Tidak</option>
            </select>
          </div>
        <?php 
        if(isset($event)) {
            if($event['fitur_meja'] == 1) { ?>
          <div class="form-group">
            <label for="jml" class="text-custom">Nomor Meja</label>
            <input type="text" class="form-control" name="nomor_meja" id="nomor_meja" value="1">
          </div>
        <?php 
            } 
        }
        ?>
          <div class="form-group mb-3">
            <label for="group" class="text-custom">Pilih Grup Tamu</label>
            <select name="group" id="group" class="form-control" required>
              <?php foreach($this->m_grup->byEvent($event['id']) as $grp) : ?>
              <option value="<?= $grp['id'] ?>"><?= $grp['nama'] ?></option>
              <?php endforeach; ?>
            </select>
            <span class="d-block text-11" >Jika belum ada grup tamu, silakan <b><a href="<?=base_url('tamu/group/'.$event['id'])?>">buat grup tamu</a></b>.</span>
          </div>
            <style>
                .btnjmltmu {
                    border: 3px solid white;
                    height: 50px;
                    
                }
            </style>

          <div class="form-group">
            <button type="submit" class="btn btn-block btn-custom rounded-pill btnSubmit">Daftarkan Tamu</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
  aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <span>Kode Access</span>
          <h5 id="kodeAkses" class="font-weight-bolder"></h5>
        </div>
        <hr>
        <div class="text-center mt-4">
          <h6>DOWNLOAD APLIKASI ANDROID UNTUK SCAN QR-CODE</h6>
          <button class="btn btn-outline-custom" id="dwlApkAndro"><i class="far fa-download"></i> ANDROID APPS</button>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn rounded-pill px-3 py-1 btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="alertberhasil" data-flashdata="<?= $this->session->flashdata('berhasil'); ?>"></div>
<div class="alertgagal" data-flashdata="<?= $this->session->flashdata('gagal'); ?>"></div>


<!-- Optional JavaScript -->
<script src="<?= base_url('assets/custom/js/jquery.min.js') ?>"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/custom/toast/jquery.toast.min.js') ?>"></script>

<script src="<?= base_url('assets/custom/js/select.js?v=' . fileatime('assets/custom/js/select.js')) ?>"></script>
<script src="<?= base_url('assets/custom/js/custom.js?v=' . fileatime('assets/custom/js/custom.js')) ?>"></script>

<script>
    document.getElementById('nama').focus();
</script>

<script type="text/javascript">
$(function() {
  var flash = $('.alertgagal').data('flashdata');
  if (flash) {
     Swal.fire('Warning', flash, 'error');
  }
});

$(function() {
  var flash = $('.alertberhasil').data('flashdata');
  if (flash) {
    Swal.fire('Error', flash, 'error');
  }
});

$(document).ready(function () {
    $('#scan_qr').on('click', function (e) {
        window.location.href = UrLBase + 'home/scanQrcode';
    });
    $('#cariTamu').on('click', function (e) {
      e.preventDefault();
      $('.modal#moadlListCekin').modal('hide');
      $('.modal#pencarianTamu').modal('show');
      $('.modal#pencarianTamu .menu-pencarian').addClass('hide');
      $(".modal#pencarianTamu .mencariData").fadeOut();
    })
    
    $('.modal#pencarianTamu').on('shown.bs.modal', function () {
      $('.modal#pencarianTamu input#cariNamaTamu').trigger('focus')
      $('.modal#pencarianTamu input#cariNamaTamu').val("");
      $('.modal#pencarianTamu .menu-pencarian').addClass('hide');
    })
    
    $('.modal#pencarianTamu .closedModalCari').on('click', function () {
      $('.modal#pencarianTamu').modal('hide');
    })
    
    $('.modal#pencarianTamu input#cariNamaTamu').on('keyup', function () {
      var isi = $(this).val();
      if (isi == "" || isi == null) {
        $('.modal#pencarianTamu .menu-pencarian').addClass('hide');
        $(".modal#pencarianTamu .mencariData").fadeOut();
        return false;
      }
    
      $.ajax({
        url: UrLBase + 'home/cariNamaTamu',
        type: "POST",
        dataType: "JSON",
        data: {
          cari: isi
        },
        cache: false,
        beforeSend: function () {
          $(".modal#pencarianTamu .mencariData").fadeIn();
        },
        success: function (res) {
          $(".modal#pencarianTamu .mencariData").fadeOut();
          $('.modal#pencarianTamu .menu-pencarian').html(res.dataTamu);
          $('.modal#pencarianTamu .menu-pencarian').removeClass('hide');
        }
      });
    })
    
    $('.modal#pencarianTamu .menu-pencarian').on('click', '.list-menu-pencarian', function () {
      var idT = $(this).data('id');
      window.location.replace(UrLBase + 'home/scanQrcode/show/'+idT);
      var nama = $(this).data('nama');
      $('.modal#setHadirCari #hasilNamaTamu').text(nama);
      $('.modal#setHadirCari input#hasilIdTamu').val(idT);
      $('.modal#setHadirCari input#hasilJmlTamu').val(1);
      //$('.modal#setHadirCari').modal('show');
      $('.modal#pencarianTamu').modal('hide');
    });
    
    $('#manual').on('click', function (e) {
        e.preventDefault();
        $('.modal#modalManual #formTamuManual input[name="nama"]').val('');
        $('.modal#modalManual #formTamuManual input[name="alamat"]').val('');
        $('.modal#modalManual #formTamuManual input[name="nomor_meja"]').val('1');
        $('.modal#modalManual').modal('show');
    
        // Fokuskan elemen input nama secara eksplisit setelah modal ditampilkan
        setTimeout(function () {
            $('#nama').focus();
        }, 500);
    });
    
    $(function () {
      $('#formTamuManual').submit(function (e) {
        e.preventDefault();
        var btn = $(this).find('.btnSubmit');
        var txt = $(this).find('.btnSubmit').html();
        $.ajax({
          url: $(this).attr('action'),
          type: "POST",
          cache: false,
          data: $(this).serialize(),
          dataType: 'json',
          beforeSend: function () {
            btn.html(
              '<i class="far fa-spinner fa-spin"></i> Menyimpan..');
            btn.attr('type', 'button');
            btn.addClass('disabled');
          },
          success: function (json) {
            if (json.kode == 1) {
                $.toast({
                  heading: 'SUCCESS',
                  text: json.pesan,
                  showHideTransition: 'slide',
                  icon: 'success',
                  loaderBg: '#d4c357',
                  position: 'top-center'
                });
                btn.html(txt);
                btn.attr('type', 'submit');
                btn.removeClass('disabled');
                $('.modal#modalManual').modal('hide');
                var num = $('.pagination-custom .pagina-number').html();
                $('input#pencarian').val('');
                barisList(num, '');
                window.location.href = UrLBase + 'home/scanQrcode/show/'+json.idT;
            } else {
                $.toast({
                  heading: 'ERROR',
                  text: json.pesan,
                  showHideTransition: 'slide',
                  icon: 'error',
                  loaderBg: '#d4c357',
                  position: 'top-center'
                });
                btn.html(txt);
                btn.attr('type', 'submit');
                btn.removeClass('disabled');
            }
          }
        });
      });
    });
})
</script>


</body>

</html>