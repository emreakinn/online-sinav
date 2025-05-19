<?php
require_once('../assets/baglan.php');
session_start();

if (!isset($_SESSION['kadi'])) {
    die('Giriş Yetkiniz Yoktur');
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Css Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

    <!-- CK editör -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <title>Document</title>
</head>

<body>

    <section id="adminPage">
        <div class="container-fluid">
            <div class="row bg-dark text-white">
                <div class="col-md-2">Admin / Proje Adı</div>
                <div class="col-md-10 text-end">
                    <a href="logout.php" class="text-white text-decoration-none">Güvenli Çıkış</a>
                </div>
            </div>
            <div class="row" style="height: 96.5vh;">
                <div class="col-md-2 bg-dark py-3" id="adminNav">
                    <a href="dashboard.php" class="d-block text-white mb-2">Başlangıç</a>
                    <a href="sinavlar.php" class="d-block text-white mb-2">Sınavlar</a>
                    <a href="haberler.php" class="d-block text-white mb-2">Haberler</a>

                    <a href="logout.php" class="d-block text-warning mt-2">Güvenli Çıkış</a>
                </div>

                <div class="col-md-10 bg-light py-3">