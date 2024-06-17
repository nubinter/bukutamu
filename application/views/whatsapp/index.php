<style>
/* Mengurangi padding pada card-header */
.card-header {
  padding: 0rem 0rem; /* Sesuaikan padding sesuai kebutuhan */
  background-image: none !important;
}

    /* Atur warna latar belakang tab yang aktif */
.nav-tabs .nav-link.active {
    background-image: linear-gradient(        188deg,        rgba(69, 60, 158, 1) 0%,        rgba(9, 9, 121, 1) 35%,        rgba(24, 13, 91, 1) 100%    );
    color: white; /* Ganti warna teks agar lebih terlihat */
}

/* Atur warna latar belakang tab yang tidak aktif */
.nav-tabs .nav-link {
    background-color: #d3d3d3;
    color: #9B9B9B; /* Ganti warna teks agar lebih terlihat */
    margin-bottom: 0;
}

/* Atur warna latar belakang tab saat digulir (hover) */
.nav-tabs .nav-link:hover {
    background-color: orange;
    color: white;
}
</style>
<div class="content">
    <div class="row mt-4">
		<div class="col-4 kehadiran">
		  <div class="box-count" style="margin-right: -25px; margin-left: 5px;">
		      <span style="font-size: 9px;">SISA KREDIT WA</span>
			<span class="jml" id="jmlu"><?= $user['kuota_wa'] ?></span>
			
		  </div>
		</div>
		<div class="col-4 kehadiran">
		  <div class="box-count" style="margin-right: -1px;">
		      <span style="font-size: 9px;">TOTAL BLAST</span>
			<span class="jml" id="jmlu"><?= count($campaigns) ?></span>
			
		  </div>
		</div>
		<div class="col-4 kehadiran">
		  <div class="box-count" style="margin-left: -24px; margin-right: 7px;">
		      <span style="font-size: 9px;">TOTAL WA PENGIRIM</span>
			<span class="jml" id="jmlu"><?= count($devices) ?></span>
			
		  </div>
		</div>
	</div>
    <div class="row mt-4">
        <div class="col-sm-12">
    	  <div class="wrapper">
    		  <ul class="tabs-box">
    		  <?php if ($user['role'] == '2' OR $user['role'] == '3') : ?>
    		    <li class="tab"><span class="badge tbl mr-2" id="new_blast">Mulai WhatsApp Blast</span></li>
    		    <li class="tab"><span class="badge tbl mr-2" id="new_device">Tambah WhatsApp Pengirim</span></li>
    		  <?php endif; ?>
    		  </ul>
          </div>
        </div>
    </div>

    <div class="card mt-1 mb-3">
        <div class="card-header">
            <nav>
              <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                  <button class="nav-link active" id="nav-blast-tab" data-toggle="tab" data-target="#nav-blast" role="tab" aria-controls="nav-blast" aria-selected="true">
                  <i class="fas fa-history"></i> Riwayat Blast
                  </button>
                  <button class="nav-link" id="nav-device-tab" data-toggle="tab" data-target="#nav-device" role="tab" aria-controls="nav-blast" aria-selected="true">
                  <i class="fas fa-mobile-alt"></i> WhatsApp Pengirim
                  </button>
                  <?php if($user['role'] == 1) { ?>
                  <button class="nav-link" id="nav-user-tab" data-toggle="tab" data-target="#nav-user" role="tab" aria-controls="nav-user" aria-selected="true">
                  <i class="fas fa-user-alt"></i> Daftar User
                  </button>
				  <?php } ?>
              </div>
            </nav>
        </div>
        <div class="card-body">
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-blast" role="tabpanel" aria-labelledby="nav-blast-tab">
                    <div class="list-table" id="list-blast">
                    <?php
    			    if(empty($campaigns)) {
    			        echo '<center><img src="../assets/img/design/belumadawhatsappblast1.png" style="width:300px;"/></center>';
    			    } else {
    			        echo '<ul>';
        				$i=1; 
        				foreach($campaigns as $blast) {
        					if($blast['status'] == 'finished') {
        						$status = '<span class="badge badge-success">'.$blast['status'].'</span>';
        					}
        					if($blast['status'] == 'pending') {
        						$status = '<span class="badge badge-warning">'.$blast['status'].'</span>';
        					}
        					if($blast['status'] == 'starting') {
        						$status = '<span class="badge badge-secondary">'.$blast['status'].'</span>';
        					}
        					if($blast['schedule'] == '0000-00-00 00:00:00') {
        						$schedule = 'langsung kirim';
        					} else {
        						$schedule = $blast['schedule'].' WIB';
        					}
        					if($blast['campaign_type'] == 'group') {
        					    if($blast['receivers'] == 'all') {
        						    $receiver = 'Semua tamu';
        					    } else {
        					        $grup = $this->m_grup->byId($blast['receivers']);
        					        $receiver = $grup['nama'];
        					    }
        					}
        					if($blast['campaign_type'] == 'selected') {
        					    $receiver = 'Selected';
        					}
        			?>
        			  <li>
        				<input id="idblast" value="' . $blast['id'] . '" style="display:none">
        				<span class="nomor"><?=$i++?></span>
        				<span class="option">
        					<div class="dropdown">
        						<a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"><i class="far fa-cogs"></i></a>
        						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
        							<a class="dropdown-item" href="<?=base_url('whatsapp/history/'.$blast['id'])?>"><i class='fa fa-history mr-2' style="font-size: 16px;"></i>Riwayat</a>
        							<?php if($blast['status'] != 'starting') { ?>
        							<a class="dropdown-item btnDelBlast" href="<?=base_url('whatsapp/deleteCampaign/'.$blast['id'])?>"><i class="fa fa-trash mr-2" style="font-size: 16px;"></i>Delete</a>
        							<?php } ?>
        						</div>
        					</div>
        				</span>
        				<span class="title"><?=$blast['name']?></span> <span class="sub-title"><i>(<?=$blast['sender']?>)</i></span>
        				<span class="sub-title"><span class="badge badge-success"><?=$blast['status']?></span> | Schedule : <?=$schedule?> | <?=$receiver?></span>
        			  </li>
    			    <?php 
    			        }
    			        echo '</ul>';
    			    }
    			    ?>
    			    </div>
                </div>
                <div class="tab-pane fade" id="nav-device" role="tabpanel" aria-labelledby="nav-device-tab">
                    <div class="card-body">
                      <div class="list-table" id="list_devices">
                        <ul>
                          <li><span class="sub-title">Loading...</span></li>
                        </ul>
                      </div>
                    </div>
                </div>
                <?php if($user['role'] == 1) { ?>
					<div class="tab-pane fade" id="nav-user" role="tabpanel" aria-labelledby="nav-user-tab">
						<div class="card-body">
						  <div class="list-table" id="list_users">
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
				<?php } ?>
            </div>
        </div>
        <div class="card-footer">
        </div>
    </div>
    
</div>
<!-- Modal -->
<div class="modal fade" id="modalNewDevice" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalWaNumber" aria-hidden="true" style="z-index:99999;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalWaNumber">Add WhatsApp Device</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>      
            </div>
            <div class="modal-body">
                <div id="form_device">	
                    <div class="form-group">
                        <label for="wa_number">Nomor WhatsApp Pengirim</label>
                        <input type="number" class="form-control" name="wa_number" id="wa_number" placeholder="Contoh: 628971xxxx"/>
                    </div>
                </div>
                <div id="qr_result"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary rounded-pill" id="save">Save</button>
                <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal" id="close_add">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalQr" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalWaNumber" aria-hidden="true" style="z-index:99999;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalWaNumber">Scan QRCode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>      
            </div>
            <div class="modal-body">
                <div id="qr_result"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal" id="close_scan">Close</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('template/footer'); ?>

<script>
var UrLBase = '<?= base_url() ?>';



$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnQr', function (event) {
    event.preventDefault();
    $('.modal#modalQr').modal('show');
    $('.modal#modalQr #qr_result').html('');
    var nomor_wa = $(this).data('nomor_wa');
    $.ajax({
        url: UrLBase + 'whatsapp/get_qr/'+nomor_wa,
        type: 'GET',
        cache: false,
        dataType: 'JSON',
        success: function (json) {
          if(json.qr.success) {
                $('.modal#modalQr #qr_result').html('<center><img class="img-responsive" src="https://app.buktamdigital.my.id/assets/img/design/HeaderWA.png" style="width:310px;" /><br /><img src='+json.qr.code+' /><br /><img class="img-responsive" src="https://app.buktamdigital.my.id/assets/img/design/FooterWA.png" style="width:350px;" /></center>');
            } else {
                  if(json.qr.status == 0) {
                    $('.modal#modalQr #qr_result').html(json.qr.message);
                  }
                  if(json.qr.status == 1) {
                    $('.modal#modalQr #qr_result').html('<center><img src="https://app.buktamdigital.my.id/assets/img/design/ConnectedQR.png" alt="WhatsApp sudah terkoneksi!" width="350px" height="350px" ></center>');
                  }
            }
        }
    })
});


$('.list-table ul').on('click', 'li .dropdown .dropdown-item.btnDelete', function (event) {
    $('.list-table ul li').removeClass('active');
    var id = $(this).data('id');
    Swal.fire({
       title: 'Yakin ingin hapus?',
       text: "Tindakan ini akan menghapus dan mengeluarkan device whatsapp anda!",
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yaa, Hapus!',
       position: 'top-center',
       showLoaderOnConfirm: true,
    }).then((result) => {
       if (result.isConfirmed) {
            $.ajax({
                url: UrLBase + 'whatsapp/remove_device',
                type: "POST",
                data: {id: id},
                cache: false,
                dataType: 'JSON',
                beforeSend: function () {
                    $("#LoadingPage").fadeIn();
                },
                success: function (json) {
                    $('#roundedOne').removeAttr('checked');
                    $("#LoadingPage").fadeOut();
                    if(json.status == 1) {
                        showSuccessAlert(json.pesan);
                        baris_device();
                    } else {
                        showErrorAlert(json.pesan);
                    }
                },
                error: function () {
                    showErrorAlert('Terjadi kesalahan saat mengirim data.');
                }
            });
       } else if (result.dismiss === Swal.DismissReason.cancel) {
       }
     });
});

$(document).ready(function () {
    $('#new_device').click(function () {
        $('.modal#modalNewDevice').modal('show');
    })
    
    $('#new_blast').click(function () {
        window.location = UrLBase+"whatsapp/campaign";
    })
    
    $('#nav-device-tab').on('click', function (event) {
        event.preventDefault();
        $.ajax({
            url: UrLBase + 'whatsapp/load_device',
            type: 'GET',
            cache: false,
            dataType: 'JSON',
            success: function (respon) {
              $('#list_devices ul').html(respon.listPage);
            }
        })
    })
    $('.modal#modalNewDevice').on('click', '#save', function (e) {
        e.preventDefault();
        var nomor_wa = $('#wa_number').val();
        if(nomor_wa == '') {
            return Swal.fire(
                  'Nomor Tidak boleh Kosong!',
                  'Isikan Nomor dengan (62) Contoh: 62897xxxxxx',
                  'warning'
                )
        }
    	if(nomor_wa != '') {
    	const regex = /^628\d{8,}$/;
            if(regex.test(nomor_wa)) {
        	} else {
        		$('#hasil-cek-nomor').html('Isikan Nomor dengan awalan (62) Contoh: 62897xxxxxx');
                return Swal.fire(
                  'Format Nomor Tidak Sesuai',
                  'Isikan Nomor dengan (62) Contoh: 62897xxxxxx',
                  'warning'
                )
        	}
    	}
        $.ajax({
            url: '/whatsapp/add_device',
            type: 'POST',
            dataType: 'JSON',
            data: {
                nomor_wa: nomor_wa
            },
            cache: false,
            success: function (json) {
              if (json.status == 1) {
                  if(json.qr.success) {
                    $('#save').attr('disabled', 'disabled');
                    $('#save').addClass('disabled');
                    $('.modal#modalNewDevice #qr_result').html('<center><img class="img-responsive" src="https://app.buktamdigital.my.id/assets/img/design/HeaderWA.png" style="width:310px;" /><br /><img src='+json.qr.code+' /><br /><img class="img-responsive" src="https://app.buktamdigital.my.id/assets/img/design/FooterWA.png" style="width:350px;" /></center>');
                  } else {
                      if(json.qr.status == 0) {
                        $('.modal#modalNewDevice #qr_result').html(json.qr.message);
                      }
                      if(json.qr.status == 1) {
                        $('.modal#modalNewDevice #qr_result').html('<center><img src="https://app.buktamdigital.my.id/assets/img/design/ConnectedQR.png" alt="Whatsapp sudah terkoneksi!" width="350px" height="350px" ></center>');
                      }
                  }
              }
              if (json.status == 2) {
                $('.modal#modalNewDevice #qr_result').html(json.pesan);
              }
              
              if (json.status == 3) {
                $('.modal#modalNewDevice #qr_result').html(json.pesan);
              }
            }
        })
    });
});

function bindDeleteButtonClick() {
  $('.btnDelBlast').click(function (e) {
    e.preventDefault();
    url = $(this).attr('href');
    Swal.fire({
       title: 'Yakin ingin hapus?',
       text: "Ini akan menghapus data whatsapp blast!",
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yaa, Hapus!',
       position: 'top-center',
       showLoaderOnConfirm: true,
    }).then((result) => {
       if (result.isConfirmed) {
         $.ajax({
           url: url,
           type: "GET",
           cache: false,
           beforeSend: function () {
             $("#LoadingPage").fadeIn();
           },
           success: function () {
                $("#LoadingPage").fadeOut();
                $('#list-table').load(window.location + ' #list-table', function() {
                    bindDeleteButtonClick();
                });
           },
           error: function () {
             showErrorAlert('Terjadi kesalahan saat mengirim data.');
           }
         });
       } else if (result.dismiss === Swal.DismissReason.cancel) {
       }
    });
  });
}

$('.btnDelBlast').click(function (e) {
    e.preventDefault();
    url = $(this).attr('href');
    Swal.fire({
       title: 'Yakin ingin hapus?',
       text: "Ini akan menghapus data whatsapp blast!",
       showCancelButton: true,
       confirmButtonColor: '#3085d6',
       cancelButtonColor: '#d33',
       confirmButtonText: 'Yaa, Hapus!',
       position: 'top-center',
       showLoaderOnConfirm: true,
    }).then((result) => {
       if (result.isConfirmed) {
         $.ajax({
           url: url,
           type: "GET",
           cache: false,
           beforeSend: function () {
             $("#LoadingPage").fadeIn();
           },
           success: function () {
                $("#LoadingPage").fadeOut();
                $('#list-blast').load(window.location + ' #list-blast', function() {
                    bindDeleteButtonClick();
                });
           },
           error: function () {
             showErrorAlert('Terjadi kesalahan saat mengirim data.');
           }
         });
       } else if (result.dismiss === Swal.DismissReason.cancel) {
       }
    });
});

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

function baris_device() {
    $.ajax({
        url: UrLBase + 'whatsapp/load_device',
        type: 'GET',
        cache: false,
        dataType: 'JSON',
        success: function (respon) {
          $('.list-table ul').html(respon.listPage);
        }
    })
}
	<?php if($user['role'] == 1) { ?>
    $('#nav-user-tab').on('click', function (event) {
        event.preventDefault();
		var num = $('.pagination-custom .pagina-number').html();
		var cari = $('input#pencarian').val();
		barisList(num, cari);
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

	$('input#pencarian').keyup(function () {
	  var src = $(this).val();
	  var num = 1;
	  $('.pagination-custom .pagina-number').html(1);

	  barisList(num, src);
	})
	
	$('.list-table').on('click', 'a.btnKuota', function (e) {
		e.preventDefault();
		var url = $(this).attr('href');
		var kuota = $(this).data('kuota');
		var id = $(this).data('id');
		$('.modal#modalKuota input#kuota_wa').val(kuota);
		$('.modal#modalKuota input#id_user').val(id);
		$('.modal#modalKuota').modal('show');
	});
	
	$(function () {
	  $('.formInput').submit(function (e) {
		e.preventDefault();
		var txt = $('.btnSubmit').html();
		$.ajax({
		  url: $(this).attr('action'),
		  type: "POST",
		  cache: false,
		  data: $(this).serialize(),
		  dataType: 'json',
		  beforeSend: function () {
			$("#LoadingPage").fadeIn();
			$('.btnSubmit').html(
			  '<i class="far fa-spinner fa-spin"></i> Menyimpan..');
			$('.btnSubmit').attr('type', 'button');
			$('.btnSubmit').attr('disabled', 'disabled');
			$('.btnSubmit').addClass('disabled');
		  },
		  success: function (json) {

			if (json.status == 1) {
			  $("#LoadingPage").fadeOut();
			  $.toast({
				heading: 'Sukses',
				text: json.pesan,
				showHideTransition: 'slide',
				icon: 'success',
				loaderBg: '#d4c357',
				position: 'top-center'
			  });

			  $('.btnSubmit').html(txt);
			  $('.btnSubmit').attr('type', 'submit');
			  $('.btnSubmit').removeAttr('disabled');
			  $('.btnSubmit').removeClass('disabled');

			  $('.modal#modalKuota').modal('hide');
			  var num = $('.pagination-custom .pagina-number').html();
			  var cari = $('input#pencarian').val();
			  barisList(num, cari);
			} else {
			  $("#LoadingPage").fadeOut();
			  $.toast({
				heading: 'Error',
				text: json.pesan,
				showHideTransition: 'slide',
				icon: 'error',
				loaderBg: '#d4c357',
				position: 'top-center'
			  });

			  $('.btnSubmit').html(txt);
			  $('.btnSubmit').attr('type', 'submit');
			  $('.btnSubmit').removeAttr('disabled');
			  $('.btnSubmit').removeClass('disabled');
			}
		  }
		});
	  });
	});
    function barisList(num, cari) {
      $.ajax({
    	url: UrLBase + 'whatsapp/load_user',
    	type: "POST",
    	dataType: "JSON",
    	data: {
    	  page: num,
    	  cari: cari
    	},
    	cache: false,
    	beforeSend: function () {
    	  $("#LoadingPage").fadeIn();
    	},
    	success: function (respon) {
    	  $("#LoadingPage").fadeOut();
    	  $('.count-guest #jml').html(respon.totalData);
    	  $('#list_users ul').html(respon.listPage);
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
    	  if ($('#roundedOne').is(':checked')) {
    		$('#roundedOne').click();
    	  }
    	  console.log(respon.totalRecord)
    	}
      });
    }
<?php } ?>
</script>