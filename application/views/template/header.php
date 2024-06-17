<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="author" content="mail:fiturbukutamu@gmail.com">
  <title>Dashboard - Bukutamu Digital</title>
  <link rel="shortcut icon" href="<?= base_url('assets/img/page/logo1.png') ?>">

  <meta content="" name="descriptison">
  <meta content="" name="keywords">
  <meta property="og:title" content="Fitur Bukutamu Digital">
  <meta property="og:description" content="Buku Tamu Digital dengan sistem QR Code, Layar Sapa, WhatsApp Blast, dan masih banyak lagi...">
  <meta property="og:image" content="<?= base_url('assets/img/page/logo1.png') ?>">

  <meta property="twitter:title" content="Fitur Bukutamu Digital">
  <meta property="twitter:description" content="Buku Tamu Digital dengan sistem QR Code, Layar Sapa, WhatsApp Blast, dan masih banyak lagi...">
  <meta property="twitter:image" content="<?= base_url('assets/img/page/logo1.png') ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta data-rh="true" name="description" content="Buku Tamu Digital dengan sistem QR Code, Layar Sapa, WhatsApp Blast, dan masih banyak lagi...">

  <!-- Bootstrap CSS -->

  <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/custom/toast/jquery.toast.min.css') ?>">
  <!-- <link rel="stylesheet" href="<?= base_url('assets/custom/sweetalert/sweet-alert.css') ?>"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">

  <link rel="stylesheet" href="<?= base_url('assets/custom/fontaws/css/all.min.css') ?>">
  <link rel="stylesheet"
    href="<?= base_url('assets/custom/css/style.css?v=' . filemtime('assets/custom/css/style.css')) ?>">
  <link rel="stylesheet"
    href="<?= base_url('assets/custom/css/style_navbar.css?v=' . filemtime('assets/custom/css/style_navbar.css')) ?>">
  <link rel="stylesheet"
    href="<?= base_url('assets/custom/css/sliding-menu.css')?>">
  <link rel="stylesheet"
    href="<?= base_url('assets/custom/css/select.css?v=' . filemtime('assets/custom/css/select.css')) ?>">
  <link rel="stylesheet"
    href="<?= base_url('assets/custom/css/check.css?v=' . filemtime('assets/custom/css/check.css')) ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="<?= base_url('assets/custom/js/right.js') ?>"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script>
  function logout(){
    Swal.fire({
    //   title: 'Yakin ingin keluar?',
      text: "Yakin ingin keluar?",
      icon: "question",
       showCancelButton: true,
       confirmButtonColor: '#EB6001',
       cancelButtonColor: '#8E8E8E',
       confirmButtonText: 'Yaa!',
       position: 'top-center',
       showLoaderOnConfirm: true,
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'get',
          url: '<?= base_url('auth/logout') ?>', // Ganti dengan URL tujuan server Anda
          success: function(response) {
            // Tanggapan dari server akan ditampilkan dalam div #response
            // Swal.fire({
            //     title: 'Berhasil!',
            //     text: 'Logout berhasil !',
            //     icon: 'success',
            //     showConfirmButton: false,
            //     timer: 2000,
            //   });
            window.location.reload()
          },
          error: function() {
            // Tanggapan jika terjadi kesalahan
            $('#response').html('Terjadi kesalahan saat mengirim data.');
          }
        });
        
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        // Kode yang akan dijalankan jika pengguna menekan tombol "Tidak" atau menutup kotak konfirmasi.
        // Swal.fire({
        //         title: 'Dibatalkan',
        //         text: 'Logout dibatalkan',
        //         icon: 'error',
        //         showConfirmButton: false,
        //         timer: 1000,
        //       });
      }
    });
  }
</script>



<script>
    document.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    });
</script>





<script>
    
  
    document.addEventListener('DOMContentLoaded', function () {
      var dropdownToggle = document.querySelector('.dropdown-toggle');
      var barsIcon = document.querySelector('.fa-bars');

      dropdownToggle.addEventListener('click', function () {
        // Toggle antara ikon fa-bars dan fa-times
        if (barsIcon.classList.contains('fa-bars')) {
          barsIcon.style.transition = 'transform 0.3s ease-in-out'; // Menambahkan gaya inline
          barsIcon.classList.remove('fa-bars');
          barsIcon.classList.add('fa-times', 'rotate'); // Tambahkan kelas rotate
        } else {
          barsIcon.style.transition = 'transform 0.3s ease-in-out'; // Menambahkan gaya inline
          barsIcon.classList.remove('fa-times', 'rotate'); // Hapus kelas rotate
          barsIcon.classList.add('fa-bars');
        }
      });

      // Tambahkan event listener untuk menanggapi saat dropdown ditutup
      document.addEventListener('click', function (event) {
        var isDropdownClicked = dropdownToggle.contains(event.target);
        
        if (!isDropdownClicked) {
          // Dropdown ditutup, kembalikan ikon ke fa-bars
          barsIcon.style.transition = 'transform 0.3s ease-in-out'; // Menambahkan gaya inline
          barsIcon.classList.remove('fa-times', 'rotate'); // Hapus kelas rotate
          barsIcon.classList.add('fa-bars');
        }
      });
    });



    
</script>



</head>

<body>
<?php
// Mendapatkan nama halaman saat ini
$current_page = basename($_SERVER['PHP_SELF']);

// Definisikan kelas "active" untuk setiap link
$home_class = ($current_page == 'home') ? 'nav__active' : '';
$setting_class = ($current_page == 'seting') ? 'nav__active' : '';
// Lanjutkan dengan mengatur class untuk link lainnya

?>
  <!--<div class="container container-page" id="container">-->
      
      
      
      
      
      
      
      
      
<!-- -------- Navbar ---------- -->
        <div class="nav__bottom" style="z-index:100;">
            <ul class="nav__bottom__col" id="myDIV">
                <li>
                    <a href="<?= base_url('home') ?>" class="nav__bottom__col__row btn3 <?php echo $home_class; ?>" >
                        <i class="fi fi-rr-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav__bottom__col__row btn3" id="cariTamu">
                        <i class="fi fi-rr-search-alt"></i>
                        <span>Cari Tamu</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav__bottom__col__row btn3" id="scan_qr">
                        <div class="rounded__custom__i" id="custom-icon-container">
                            
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav__bottom__col__row btn3" id="manual">
                        <i class="fi fi-rr-user-add"></i>
                        <span>Tamu Baru</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('seting') ?>" class="nav__bottom__col__row btn3 <?php echo $setting_class; ?>">
                        <i class="fi fi-rr-settings"></i>
                        <span>Pengaturan</span>
                    </a>
                </li>
            </ul>
        </div>
        
        
        <script> 
                var header = document.getElementById("myDIV");
                var btns = header.getElementsByClassName("btn3");

                for (var i = 0; i < btns.length; i++) {
                    btns[i].addEventListener("click", function() {
                    var current = document.getElementsByClassName("nav__active");
                    current[0].className = current[0].className.replace(" nav__active", "");
                    this.className += " nav__active";
                    });
        }</script>
    
    
    
   <style>
    .navbar-light .navbar-toggler-icon {
      transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out; /* Atur durasi dan jenis animasi */
    }

    .rotate {
      transform: rotate(90deg);
    }
    
   
  .dropdown-toggle {
    transition: transform 0.3s ease-in-out;
  }

  .dropdown-toggle.active {
    transform: scale(1.2);
  }



  </style>





 
<!-- -------- / navbar / ---------- -->


    <nav class="navbar navbar-light nav-header">
      <a class="navbar-brand" href="<?= base_url('home') ?>">
        <img src="<?= base_url('assets/img/page/LOGO_UTAMA_BUKUTAMU_DIGITAL.gif') ?>" alt="brand" >
      </a>

      <div class="dropdown d-inline-block mr6">
            <a class="dropdown-toggle px-2 toggle-animation slider" type="button" id="dropdownMenuButton" data-toggle="dropdown"
              aria-expanded="false">
              <i class="fa fa-bars" style="font-size: 20.6px; color: white;" ></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="<?= base_url('seting') ?>"><i class='fa fa-gear fa-spin mr-2' style="font-size: 15.6px; "></i>Pengaturan</a>
              <a class="dropdown-item" href="<?= base_url('whatsapp') ?>"><i class='fa fa-whatsapp mr-2' style="font-size: 15.6px; "></i>WhatsApp Blast</a>
              <a class="dropdown-item" href="https://youtube.com/playlist?list=PL7_FguXQ_CwroOXgb_o1MyFLluPVx-wJV&si=2sqz-jFJtia0KrtA"><i class='fab fa-youtube mr-1' style="font-size: 12.6px;"></i> Tutorial Penggunaan</a>
              <a class="dropdown-item" href="https://play.google.com/store/apps/details?id=id.my.buktamdigital"><i class='fab fa-google-play mr-2' style="font-size: 13.6px; "></i>Download Aplikasi</a>
              <a class="dropdown-item" id:"logoutid" onclick="logout()"><i class='fas fa-sign-out-alt mr-2' style="font-size: 14px;"></i>Keluar</a>
              
            </div>

          </div>

    </nav>




      
    
<div class="container container-page" id="container">



    

    
    


    <div class="area-content" id="area-content">
      <div id="LoadingPage">
        <div class="spinner-border text-custom" role="status"></div>
      </div>
      
      
      
      
<script>
    
  document.querySelector('.dropdown-toggle').addEventListener('click', function() {
    this.classList.toggle('active');
  });

</script>


<script>
    // Setelah halaman dimuat
    document.addEventListener('DOMContentLoaded', function () {
        // Buat elemen gambar
        var img = new Image();
        img.src = "<?= base_url('assets/img/design/QR.gif') ?>";
        img.alt = "Animated GIF";
        img.width = 52;
        img.height = 52;

        // Sisipkan gambar ke dalam kontainer
        document.getElementById('custom-icon-container').appendChild(img);
    });
</script>