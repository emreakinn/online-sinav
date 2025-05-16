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

    <!-- Header Section Start -->
    <header id="header" class="pb-5">
        <section1topHeader>
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
                                        <a class="nav-link" href="sinavlarim.php">Sınavlarım</a>
                                        <a class="nav-link" href="haberler.php">Haberler</a>
                                        <a class="nav-link" href="iletisim.php">İletişim</a>
                                        <a href="logout.php" class="d-block text-dark mt-2">Güvenli Çıkış</a>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </section1topHeader>

        <section id="bottomHeader">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php
                        if (isset($_SESSION['ad_soyad'])) {
                            echo '<h3>Merhaba, ' . htmlspecialchars($_SESSION['ad_soyad']) . '</h3>';
                        } else {
                            die('Giriş Yetkiniz Yoktur');
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
    </header>

    <!-- Header Section End -->