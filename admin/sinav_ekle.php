<?php require_once('header.php');



?>
<!-- Admin Body Section Start -->
<div class="row">
    <div class="col-12 text-center">
        <h3>Sınav Soruları</h3>
    </div>
</div>
<div class="row justify-content-center">
    <form action="" method="POST" class="row">
        <div class="col-12">
            <input type="text" name="baslik" placeholder="Sınav Başlığı" class="form-control" required>
        </div>
        <div class="col-12 my-2">
            <select name="sinif_id" class="form-control" required>
                <option value="1">1. Sınıf</option>
                <option value="2">2. Sınıf</option>
                <option value="3">3. Sınıf</option>
                <option value="4">4. Sınıf</option>
            </select>
        </div>
        <div class="col-12 my-2">
            <input type="date" name="tarih" class="form-control" required>
        </div>
        <div id="sorular">
            <div class="col-12 my-2">
                <textarea name="soru[]" placeholder="Soru Yaz..." rows="4" class="w-100" required></textarea>
            </div>
            <div class="col-12 mb-2">
                <div class="row justify-content-between">
                    <div class="col-md-2">
                        <input type="text" name="a[]" placeholder="A Şıkkı" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="b[]" placeholder="B Şıkkı" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="c[]" placeholder="C Şıkkı" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="d[]" placeholder="D Şıkkı" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="e[]" placeholder="E Şıkkı" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="dogru[]" placeholder="Doğru Cevap" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="puan[]" placeholder="Puan" class="form-control" required>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6 my-2">
            <input type="submit" name="sinav_olustur" value="Sınav Oluştur" class="btn btn-success form-control">
        </div>
        <div class="col-md-6 my-2">
            <input type="button" value="Yeni Soru Ekle" id="yeniSoruEkleBtn" class="btn btn-success form-control">
        </div>
    </form>
</div>

<?php
if (isset($_POST['sinav_olustur'])) {
    $stmt = $db->prepare("INSERT INTO sinavlar (sinif_id, baslik, tarih) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['sinif_id'], $_POST['baslik'], $_POST['tarih']]);

    $sinav_id = $db->lastInsertId();
    $_SESSION['sinav_id'] = $sinav_id;

    foreach ($_POST['soru'] as $index => $soru) {
        $a = $_POST['a'][$index];
        $b = $_POST['b'][$index];
        $c = $_POST['c'][$index];
        $d = $_POST['d'][$index];
        $e = $_POST['e'][$index];
        $dogru = $_POST['dogru'][$index];
        $puan = $_POST['puan'][$index];

        $stmt = $db->prepare("INSERT INTO sorular (sinav_id, soru, a, b, c, d, e, dogru, puan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$sinav_id, $soru, $a, $b, $c, $d, $e, $dogru, $puan]);
    }
}
?>

<!-- Admin Body Section End -->
<?php require_once('footer.php'); ?>