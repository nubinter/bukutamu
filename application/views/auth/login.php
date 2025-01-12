<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta name="author" content="Bukutamu Digital mail:fiturbukutamu@gmail.com">
  <title>Login Guestbook - invikit.id</title>
  <link rel="shortcut icon" href="<?= base_url('assets/img/page/logosquare.png') ?>">

  <meta content="" name="Buku Tamu Digital - invikit.id">
  <meta content="" name="keywords">
  <meta property="og:title" content="BukuTamu Digital - invikit.id">
  <meta property="og:description" content="Buku Tamu Digital QR Code Check-In !">
  <meta property="og:image" content="<?= base_url('assets/img/page/logosquare.png')?>">

  <meta property="twitter:title" content="<?= $title ?>">
  <meta property="twitter:description" content="<?= $descr ?>">
  <meta property="twitter:image" content="<?= base_url('assets/img/page/' . $icon) ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta data-rh="true" name="description" content="<?= $descr ?>">
  
  

  <!-- Bootstrap CSS -->
  <!--<link rel="stylesheet"-->
  <!--  href="<?= base_url('assets/bootstrap/css/bootstrap.min.css?v=' . filemtime('assets/bootstrap/css/bootstrap.min.css')) ?>"-->
  <!--  type="text/css">-->
  <!--<link rel="stylesheet" href="<?= base_url('assets/custom/toast/jquery.toast.min.css') ?>" type="text/css">-->
  <!--<link rel="stylesheet" href="<?= base_url('assets/custom/sweetalert/sweet-alert.css') ?>">-->
  <!--<link rel="stylesheet" href="<?= base_url('assets/custom/fontaws/css/all.min.css') ?>" type="text/css">-->
  <!--<link rel="stylesheet"-->
  <!--  href="<?= base_url('assets/custom/css/style.css?v=' . filemtime('assets/custom/css/style.css')) ?>" type="text/css">-->
  <!--<link rel="stylesheet"-->
  <!--  href="<?= base_url('assets/custom/css/login.css?v=' . filemtime('assets/custom/css/login.css')) ?>" type="text/css">-->
  
  
  
  
   <!-- Bootstrap CSS -->
  <link rel="stylesheet"
    href="<?= base_url('assets/bootstrap/css/bootstrap.min.css?v=' . filemtime('assets/bootstrap/css/bootstrap.min.css')) ?>"
    type="text/css">
  <link rel="stylesheet" href="<?= base_url('assets/custom/toast/jquery.toast.min.css') ?>" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.0.19/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/custom/fontaws/css/all.min.css') ?>" type="text/css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
  <link rel="stylesheet"
    href="<?= base_url('assets/custom/css/style.css?v=' . filemtime('assets/custom/css/style.css')) ?>" type="text/css">
  <link rel="stylesheet"
    href="<?= base_url('assets/custom/css/login.css?v=' . filemtime('assets/custom/css/login.css')) ?>" type="text/css">
</head>

<body>


  <section class="container">
        <div class="login-container">
            <div class="form-container">
                
                <img class="sizelogo" src="<?= base_url('assets/img/page/landscape.png') ?>" alt="logo" style="display: block; margin: 0 auto; width: 130px; height: auto; margin-top: 1rem;">

                <form action="<?= base_url('auth/log') ?>" method="post" id="formInput">
                
                    <div class="form-group mt-4 mb-4 custom-form-group">
                        <div >
                            <input type="text" class="form-control" name="username" id="username" for="username" autocomplete="off" required placeholder="Masukan Username">
                        </div>
                    </div>
           

                    <div class="form-group mt-4 mb-4 custom-form-group">
                        <div >
                            <input type="password" class="form-control" name="password" id="password" autocomplete="off" required placeholder="Masukan Password">
                        </div>
                    </div>

                    <button id="loginButton" class="opacity" >Login</button>
                </form>
                <div class="register-forget opacity">
                    <p class="sigup">Belum punya akun? <a target="_blank" href="Https://wa.me/6283102824718"><b>Daftar Sekarang!</b></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="theme-btn-container"></div>
    </section>



  <script src="<?= base_url('assets/custom/js/animasiTyping.js') ?>"></script>
  <script src="<?= base_url('assets/custom/js/jquery.min.js') ?>"></script>
  <script src="<?= base_url('assets/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/custom/toast/jquery.toast.min.js') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

  <script src="<?= base_url('assets/custom/js/custom.js?v=' . filemtime('assets/custom/js/custom.js')) ?>"></script>



<script>
    

    $(function() {
      $('#formInput').submit(function(e) {
        e.preventDefault();
        $.ajax({
          url: $(this).attr('action'),
          type: "POST",
          cache: false,
          data: $(this).serialize(),
          dataType: 'json',
          beforeSend: function() {
            $('.btn-login').html('<i class="far fa-spinner fa-spin"></i> Mengirim..');
            $('.btn-login').attr('type', 'button');
            $('.btn-login').addClass('disabled');
          },
          success: function(json) {

            /*if (json.status == 1) {

              $.toast({
                heading: 'Success',
                text: json.pesan,
                showHideTransition: 'slide',
                icon: 'success',
                loaderBg: '#d4c357',
                position: 'top-center'
              });

              setTimeout(function() {
                window.location.href = json.page;
              }, 1500);
            } else {
              $.toast({
                heading: 'Error',
                text: json.pesan,
                showHideTransition: 'slide',
                icon: 'error',
                loaderBg: '#d4c357',
                position: 'top-center'
              });

              $('.btn-login').html('LOGIN');
              $('.btn-login').attr('type', 'submit');
              $('.btn-login').removeClass('disabled');
            } */
            
            
            if (json.status == 1) {
                const Toast = Swal.mixin({
              toast: true,
              position: 'top',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
             })

              Toast.fire({
                icon: 'success',
                title: 'Login Berhasil, Sedang diarahkan ke Dashboard.'
             }).then((result) => {
                window.location.href = json.page;
              });
            } else {
              Swal.fire({
                title: 'Oops..',
                text: 'Username/Password Salah!',
                icon: 'error',
                html:
                      'Username/Password <b>Salah!</b> ' +
                      '<br>Mohon input dengan benar,' +
                      '<br>atau' +
                      '<a href="https://wa.me/6283102824718/"> hubungi admin</a> ',
                showConfirmButton: false,
                timer: 5300,
              });
              
              
              
              
            //   const Toast = Swal.mixin({
            //   toast: true,
            //   position: 'top-end',
            //   showConfirmButton: false,
            //   timer: 3000,
            //   timerProgressBar: true,
            //   didOpen: (toast) => {
            //   toast.addEventListener('mouseenter', Swal.stopTimer)
            //   toast.addEventListener('mouseleave', Swal.resumeTimer)
            //   }
            //  })

            //   Toast.fire({
            //     icon: 'success',
            //     title: 'Signed in successfully'
            //  })
              
              
              

              $('.btn-login').html('LOGIN');
              $('.btn-login').attr('type', 'submit');
              $('.btn-login').removeClass('disabled');
            
            }
          }
        });
      });
    });
  </script>
  
  
  

</body>


</html>