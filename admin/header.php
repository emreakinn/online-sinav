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
                    <a href="sinav_ekle.php" class="d-block text-white mb-2">Sınav Ekle</a>
                    <div class="dropdown position-static">
                        <button class="btn text-white text-start p-0 dropdown-toggle w-100 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#dropdownContent" aria-expanded="false">
                            Sınıflar
                        </button>
                        <div class="collapse" id="dropdownContent">
                            <ul class="list-group bg-dark">
                                <div class="dropdown position-static my-2">
                                    <button class="btn text-white text-start p-0 dropdown-toggle w-100 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#dropdownContent1" aria-expanded="false">
                                        1. Sınıf
                                    </button>
                                    <div class="collapse" id="dropdownContent1">
                                        <ul class="list-group bg-dark">
                                            <li><a class="list-group-item bg-dark border-0" href="#">Öğrenciler</a></li>
                                            <li><a class="list-group-item bg-dark border-0" href="birSinifSinav">Sınavlar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </ul>
                        </div>
                        <div class="collapse" id="dropdownContent">
                            <ul class="list-group bg-dark">
                                <div class="dropdown position-static">
                                    <button class="btn text-white text-start p-0 dropdown-toggle w-100 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#dropdownContent2" aria-expanded="false">
                                        2. Sınıf
                                    </button>
                                    <div class="collapse" id="dropdownContent2">
                                        <ul class="list-group bg-dark">
                                            <li><a class="list-group-item bg-dark border-0" href="#">Öğrenciler</a></li>
                                            <li><a class="list-group-item bg-dark border-0" href="ikiSinifSinav">Sınavlar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </ul>
                        </div>
                        <div class="collapse" id="dropdownContent">
                            <ul class="list-group bg-dark">
                                <div class="dropdown position-static my-2">
                                    <button class="btn text-white text-start p-0 dropdown-toggle w-100 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#dropdownContent3" aria-expanded="false">
                                        3. Sınıf
                                    </button>
                                    <div class="collapse" id="dropdownContent3">
                                        <ul class="list-group bg-dark">
                                            <li><a class="list-group-item bg-dark border-0" href="#">Öğrenciler</a></li>
                                            <li><a class="list-group-item bg-dark border-0" href="ucSinifSinav">Sınavlar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </ul>
                        </div>
                        <div class="collapse" id="dropdownContent">
                            <ul class="list-group bg-dark">
                                <div class="dropdown position-static">
                                    <button class="btn text-white text-start p-0 dropdown-toggle w-100 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#dropdownContent4" aria-expanded="false">
                                        4. Sınıf
                                    </button>
                                    <div class="collapse" id="dropdownContent4">
                                        <ul class="list-group bg-dark">
                                            <li><a class="list-group-item bg-dark border-0" href="#">Öğrenciler</a></li>
                                            <li><a class="list-group-item bg-dark border-0" href="dortSinifSinav">Sınavlar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>

                    <a href="logout.php" class="d-block text-warning mt-2">Güvenli Çıkış</a>
                </div>

                <div class="col-md-10 bg-light py-3">