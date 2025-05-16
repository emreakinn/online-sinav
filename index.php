<?php
require_once('./assets/baglan.php');
session_start();

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX">

    <!-- Css Files -->
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">

    <title>Document</title>
</head>

<body>

    <header id="header" class="pb-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <a class="navbar-brand" href="index.php">
                                <h1>ONLİNE SINAV SİSTEMİ</h1>
                            </a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                                <div class="navbar-nav ms-auto">
                                    <a class="nav-link" aria-current="page" href="index.php">Ana Sayfa</a>
                                    <a class="nav-link" href="blog.php">Dersler</a>
                                    <a class="nav-link" href="iletisim.php">İletişim</a>
                                    <a class="nav-link" name="giris" href="index.php?giris_yap">Giriş</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <section id="user" class="pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <h3>KAYIT OL</h3>
                            <form action="" method="post">
                                <input type="text" name="adsoyad" placeholder="Ad Soyad" class="form-control">
                                <input type="email" name="eposta" placeholder="E-Posta Adresi" class="form-control my-3">
                                <input type="password" name="sifre" placeholder="Şifreniz" class="form-control mb-3">
                                <input type="submit" name="kayit" value="Kayıt Ol" class="form-control bg-success">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">MODAL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">GİRİŞ YAP</h3>
                    <form action="" method="post">
                        <input type="email" name="eposta_giris" placeholder="E-Posta Adresi" class="form-control">
                        <input type="password" name="sifre_giris" placeholder="Şifreniz" class="form-control my-3">
                        <input type="submit" name="giris" value="Giriş Yap" class="form-control bg-success">
                    </form>
                </div>
            </div>
        </div>
    </div>



    <?php

    if (isset($_POST['kayit'])) {
        $kontrol = $db->prepare('SELECT COUNT(*) FROM ogrenciler WHERE email = ?');
        $kontrol->execute(array($_POST['eposta']));
        $mail_kontrol = $kontrol->fetchColumn();

        if ($mail_kontrol == 0) {
            $ogrenci_kayit = $db->prepare('insert into ogrenciler(email, ad_soyad, sinif_id, sifre) values(?,?,?,?)');
            $ogrenci_kayit->execute(array($_POST['eposta'], $_POST['adsoyad'], 1, $_POST['sifre']));

            if ($ogrenci_kayit->rowCount()) {
                echo '<script> alert("Kayıt Başarılı") </script>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                var myModal = new bootstrap.Modal(document.getElementById("exampleModal"));
                myModal.show();
                });
            </script>
            ';
            } else {
                echo '<script> alert("Kayıt sırasında bir hata oluştu!") </script>';
            }
        } else {
            echo '<script>alert("Bu e-posta adresi ile zaten kayıt olunmuş!")</script><meta http-equiv="refresh" content="0; url=index.php">';
        }
    }

    if (isset($_POST['giris'])) {
        $kontrol = $db->prepare('select count(*) from ogrenciler where email=? and sifre =?');
        $kontrol->execute(array($_POST['eposta_giris'], $_POST['sifre_giris']));
        $giris_kontrol = $kontrol->fetchColumn();

        if ($giris_kontrol > 0) {
            $kullanici = $db->prepare('SELECT ad_soyad FROM ogrenciler WHERE email=?');
            $kullanici->execute([$_POST['eposta_giris']]);
            $adsoyad = $kullanici->fetchColumn();
            $_SESSION['ad_soyad'] = $adsoyad;
            echo '<script> alert("Giriş Başarılı") </script><meta http-equiv="refresh" content="0; url=ogrDashboard.php">';
        } else {
            echo '<script> alert("Giriş Başarısız") </script>
           <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var myModal = new bootstrap.Modal(document.getElementById("exampleModal"));
                    myModal.show();
                });
            </script>
           ';
        }
    }
    if (isset($_GET["giris_yap"])) {
        echo '
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var myModal = new bootstrap.Modal(document.getElementById("exampleModal"));
            myModal.show();
        });
    </script>
    ';
    }

    ?>

    <script src=" ./assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>