<?php require_once('header.php');



?>
<!-- Admin Body Section Start -->
<div class="row">
    <div class="col-6">
        <h3>Yeni Sınav Ekle</h3>
    </div>
    <div class="col-6 text-end">
        <a href="sinavlar.php" class="btn btn-info text-white">Tümünü Gör</a>
    </div>
</div>
<div class="row justify-content-center">
    <form action="" method="POST" class="row">
        <div class="col-6 my-2">
            <select name="soru_sayisi" class="form-control">
                <option value="2">2 Soru</option>
                <option value="5">5 Soru</option>
                <option value="10">10 Soru</option>
                <option value="15">15 Soru</option>
                <option value="20">20 Soru</option>
            </select>
        </div>
        <div class="col-6 my-2">
            <input type="submit" name="soru_olustur" value="Soru" class="form-control">
        </div>
        <div class="col-12">
            <input type="text" name="baslik" placeholder="Sınav Başlığı" class="form-control">
        </div>
        <div class="col-6 my-2">
            <select name="sinif_id" class="form-control">
                <option value="1">1. Sınıf</option>
                <option value="2">2. Sınıf</option>
                <option value="3">3. Sınıf</option>
                <option value="4">4. Sınıf</option>
            </select>
        </div>
        <div class="col-3 my-2">
            <input type="date" name="tarih" class="form-control">
        </div>
        <div class="col-3 my-2">
            <input type="date" name="sinav_sonu_tarihi" class="form-control">
        </div>
        <?php
        if (isset($_POST['soru_olustur'])) {
            $soru_sayisi = $_POST['soru_sayisi'];

            for ($i = 0; $i < $soru_sayisi; $i++) {
        ?>
                <div id="sorular">
                    <div class="col-12 my-2">
                        <textarea name="soru[<?php echo $i; ?>]" placeholder="<?php echo $i + 1; ?>. Soru" rows="4" class="w-100"></textarea>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="row justify-content-between">
                            <div class="col-md-2">
                                <input type="text" name="a[<?php echo $i + 1; ?>]" placeholder="A Şıkkı" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="b[<?php echo $i + 1; ?>]" placeholder="B Şıkkı" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="c[<?php echo $i + 1; ?>]" placeholder="C Şıkkı" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="d[<?php echo $i + 1; ?>]" placeholder="D Şıkkı" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="e[<?php echo $i + 1; ?>]" placeholder="E Şıkkı" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="dogru[<?php echo $i + 1; ?>]" placeholder="Doğru Cevap" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="puan[<?php echo $i + 1; ?>]" placeholder="Puan" class="form-control">
                            </div>

                        </div>
                    </div>
                </div>

        <?php
            }
        }
        ?>
        <div class="col-md-12 my-2">
            <input type="submit" name="sinav_olustur" value="Sınav Oluştur" class="btn btn-success form-control">
        </div>
    </form>
</div>

<?php
if (isset($_POST['sinav_olustur'])) {
    $stmt = $db->prepare("INSERT INTO sinavlar (sinif_id, baslik, tarih, sinav_sonu_tarihi, soru_sayisi) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['sinif_id'], $_POST['baslik'], $_POST['tarih'], $_POST['sinav_sonu_tarihi'], $_POST['soru_sayisi']]);

    $sinav_id = $db->lastInsertId();
    $_SESSION['sinav_id'] = $sinav_id;

    foreach ($_POST['soru'] as $i => $soru) {
        $a = $_POST['a'][$i + 1];
        $b = $_POST['b'][$i + 1];
        $c = $_POST['c'][$i + 1];
        $d = $_POST['d'][$i + 1];
        $e = $_POST['e'][$i + 1];
        $dogru = $_POST['dogru'][$i + 1];
        $puan = $_POST['puan'][$i + 1];

        $stmt = $db->prepare("INSERT INTO sorular (sinav_id, soru, a, b, c, d, e, dogru, puan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array($sinav_id, $soru, $a, $b, $c, $d, $e, $dogru, $puan));
    }
    echo '<script> alert("Sınav Başarıyla Oluşturdu")</script><meta http-equiv="refresh" content="0; url=sinav_ekle.php">';
}
?>

<!-- Admin Body Section End -->
<?php require_once('footer.php'); ?>