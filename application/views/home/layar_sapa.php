<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    * {
        padding: 0;
        margin: 0;
    }

    .wrapping__welcome {
        height: 100vh;
        background-color: #FFD700;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
    }

    .wrapp__logo {
        width: 150px;
        height: 35px;
        border-radius: 0px 0px 12px 12px;
        background: #000000;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .wrapp__logo img {
        height: 60%;
    }

    .wrapp_text_content {
        display: flex;
        flex-direction: column;
        gap: 9px;
        justify-content: center;
        align-items: center;
        background: #9f9f9f00;
        margin: 0px 100px;
    }

    @media only screen and (max-width: 768px) {

        .wrapp_text_content {
            margin: 0px 10px;
        }
    }

    /* ----- custom VIP ------  */

    .wrapp_vip {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: end;
    }

    .wrapp_vip svg {
        width: max-content;
        height: max-content;

    }

    /* ----- / custom VIP / ------  */



    /* ----- custom text ------  */
    .letter__x {
        letter-spacing: 8.50px;
    }

    .letter__s {
        letter-spacing: 2.1px;
    }

    .text__x {
        text-transform: uppercase;
        font-family: sans-serif;
        color: #000;
        font-size: 35px;
        font-weight: 600;
        text-align: center;

    }

    .text__xl {
        color: #000;
        text-transform: uppercase;
        font-family: sans-serif;
        font-size: 70px;
        font-style: normal;
        font-weight: 800;
        line-height: normal;
        text-align: center;
    }

    @media only screen and (max-width: 1024px) {
        .wrapp_text_content {
            gap: 8;
        }

        .text__x {
            font-size: 16px;
        }

        .text__xl {
            font-size: 32px;

        }

    }

    /* ----- / custom text / ------  */
    </style>
    <title>WELCOME</title>
</head>

<body class="bodyKonten">
    <section class="wrapping__welcome" style="background: url('<?=base_url('assets/img/event/'.$event['poto'])?>');">
        <div class="wrapp__logo">
            <img src="<?= base_url('assets/img/page/logo.png') ?>" alt="">
        </div>
    </section>
    <script src="<?= base_url('assets/custom/js/jquery.min.js') ?>"></script>
    <script>
    $(function() {
        var auto_refresh = setInterval(
            function() {
                var url = "<?= base_url('welcome/autoLoadPage') ?>";
                $('.bodyKonten').load(url).fadeIn("slow");
            }, 1000); // refresh setiap 1 detik
    });
    </script>
</body>

</html>