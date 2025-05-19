<?php require_once('header.php');

// Öğrenci bilgileri
$ad_soyad = $_SESSION['ad_soyad'];
$ogr_id_sorgu = $db->prepare('SELECT id, sinif_id FROM ogrenciler WHERE ad_soyad = ?');
$ogr_id_sorgu->execute([$ad_soyad]);
$ogrenci = $ogr_id_sorgu->fetch(PDO::FETCH_ASSOC);
$ogr_id = $ogrenci['id'];
$ogrenci_sinif_id = $ogrenci['sinif_id'];

// Sınavı tamamla işlemi
if (isset($_POST['sinavi_tamamla']) && isset($_POST['sinav_id'])) {
    $sinav_id = $_POST['sinav_id'];
    $cevaplar = $_POST['cevap'];

    foreach ($cevaplar as $soru_id => $ogrenci_cevap) {
        $soru_sorgu = $db->prepare('SELECT dogru, puan FROM sorular WHERE id=?');
        $soru_sorgu->execute([$soru_id]);
        $soru = $soru_sorgu->fetch(PDO::FETCH_ASSOC);

        $dogru_mu = ($ogrenci_cevap == $soru['dogru']) ? 1 : 0;
        $alinan_puan = $dogru_mu ? $soru['puan'] : 0;

        $ekle = $db->prepare('INSERT INTO cevaplar (ogrenci_id, soru_id, cevap, dogru_mu, alinan_puan) VALUES (?, ?, ?, ?, ?)');
        $ekle->execute([$ogr_id, $soru_id, $ogrenci_cevap, $dogru_mu, $alinan_puan]);
    }

    echo '<script>alert("Cevaplarınız kaydedildi! Sonucunuzu görebilirsiniz.")</script>';
    echo '<meta http-equiv="refresh" content="0; url=sinavlarim.php">';
    exit;
}

// Modalda gösterilecek sınav ve sorular
$modal_sinav = null;
$modal_sorular = [];
if (isset($_GET['sinav'])) {
    $sinav_id = $_GET['sinav'];
    $sinav_sorgu = $db->prepare('SELECT * FROM sinavlar WHERE id = ?');
    $sinav_sorgu->execute([$sinav_id]);
    $modal_sinav = $sinav_sorgu->fetch(PDO::FETCH_ASSOC);

    $sorular_sorgu = $db->prepare('SELECT * FROM sorular WHERE sinav_id = ?');
    $sorular_sorgu->execute([$sinav_id]);
    $modal_sorular = $sorular_sorgu->fetchAll(PDO::FETCH_ASSOC);

    // Modalı açmak için JS
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

<section id="sinavlarim">
    <div class="container">
        <div class="row">
            <?php
            // Öğrencinin sınıfına ait sınavları çek
            $sinavlar = $db->prepare('SELECT * FROM sinavlar WHERE sinif_id = ?');
            $sinavlar->execute([$ogrenci_sinif_id]);
            foreach ($sinavlar as $sinavlarSatir) {
                // Bu sınavı öğrenci tamamlamış mı?
                $kontrol = $db->prepare('SELECT COUNT(*) FROM cevaplar WHERE ogrenci_id = ? AND soru_id IN (SELECT id FROM sorular WHERE sinav_id = ?)');
                $kontrol->execute([$ogr_id, $sinavlarSatir['id']]);
                $cevap_var = $kontrol->fetchColumn() > 0;
            ?>
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <h3>Sınav Adı: <?php echo htmlspecialchars($sinavlarSatir['baslik']); ?></h3>
                            <div>Soru Sayısı: <b><?php echo $sinavlarSatir['soru_sayisi']; ?></b></div>
                            <div>Son Tarih: <b><?php echo $sinavlarSatir['sinav_sonu_tarihi']; ?></b></div>
                            <?php
                            if ($cevap_var) {

                                // Toplam puan:
                                $puan_sorgu = $db->prepare('SELECT SUM(alinan_puan) FROM cevaplar WHERE ogrenci_id = ? AND soru_id IN (SELECT id FROM sorular WHERE sinav_id = ?)');
                                $puan_sorgu->execute([$ogr_id, $sinavlarSatir['id']]);
                                $toplam_puan = $puan_sorgu->fetchColumn();
                                echo '<span class="text-dark">Aldığınız Puan: <b>' . intval($toplam_puan) . '</b></span><br>';
                                echo '<span class="text-success">Sınav Tamamlandı</span>';
                            } else {
                                echo '<a class="text-success fs-3" href="sinavlarim.php?sinav=' . $sinavlarSatir['id'] . '" onclick="return confirm(\'Sınava başlamak istiyor musunuz?\');"><b>Sınava Başla</b></a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <?php if ($modal_sinav): ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo htmlspecialchars($modal_sinav['baslik']); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" name="sinav_id" value="<?php echo $modal_sinav['id']; ?>">
                        <?php foreach ($modal_sorular as $sorularSatir): ?>
                            <div class="mb-3">
                                <div><b><?php echo htmlspecialchars($sorularSatir['soru']); ?></b></div>
                                <small>
                                    <label>A</label>
                                    <input type="radio" name="cevap[<?php echo $sorularSatir['id']; ?>]" value="<?php echo $sorularSatir['a']; ?>">
                                    <label><?php echo $sorularSatir['a']; ?></label>
                                </small>
                                <small class="mx-5">
                                    <label>B</label>
                                    <input type="radio" name="cevap[<?php echo $sorularSatir['id']; ?>]" value="<?php echo $sorularSatir['b']; ?>">
                                    <label><?php echo $sorularSatir['b']; ?></label>
                                </small>
                                <small>
                                    <label>C</label>
                                    <input type="radio" name="cevap[<?php echo $sorularSatir['id']; ?>]" value="<?php echo $sorularSatir['c']; ?>">
                                    <label><?php echo $sorularSatir['c']; ?></label>
                                </small>
                                <small class="mx-5">
                                    <label>D</label>
                                    <input type="radio" name="cevap[<?php echo $sorularSatir['id']; ?>]" value="<?php echo $sorularSatir['d']; ?>">
                                    <label><?php echo $sorularSatir['d']; ?></label>
                                </small>
                                <small>
                                    <label>E</label>
                                    <input type="radio" name="cevap[<?php echo $sorularSatir['id']; ?>]" value="<?php echo $sorularSatir['e']; ?>">
                                    <label><?php echo $sorularSatir['e']; ?></label>
                                </small>
                            </div>
                        <?php endforeach; ?>
                        <input type="submit" value="Sınavı Tamamla" name="sinavi_tamamla" class="btn btn-success w-100">
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>