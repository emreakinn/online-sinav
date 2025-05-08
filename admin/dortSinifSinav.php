<?php require_once('header.php');

if (isset($_POST['delete'])) {
    $id = $_POST['delete'];

    $soruSil = $db->prepare('DELETE FROM sorular WHERE sinav_id=?');
    $soruSil->execute([$id]);

    $sinavSil = $db->prepare('DELETE FROM sinavlar WHERE id=?');
    $sinavSil->execute([$id]);

    if ($sinavSil->rowCount()) {
        echo '<script> alert("Sınav Silindi") </script><meta http-equiv="refresh" content="1; url=dortSinifSinav.php">';
    } else {
        echo '<script> alert("Hata Oluştu") </script><meta http-equiv="refresh" content="1; url=dortSinifSinav.php">';
    }
}

?><!-- Admin Body Section Start -->
<div class="row">
    <div class="col-12 text-center">
        <h3>Sınavlarım</h3>
    </div>
</div>
<div class="row">

    <?php
    $sinavSec = $db->prepare('SELECT * FROM sinavlar WHERE sinif_id =? ORDER BY baslik ASC');
    $sinavSec->execute([4]);
    if ($sinavSec->rowCount()) {
        foreach ($sinavSec as $sinavSecSatir) {

            $soruBilgi = $db->prepare('SELECT COUNT(*) AS soru FROM sorular WHERE sinav_id = ?');
            $soruBilgi->execute([$sinavSecSatir['id']]);
            $soruBilgiSatir = $soruBilgi->fetch(PDO::FETCH_ASSOC);

            $soruSayisi = $soruBilgiSatir['soru'] ?? 0;
    ?>
            <div class="col-md-4">
                <div class="card-body border text-center">
                    <h3 class="card-title"><?php echo $sinavSecSatir['baslik']; ?></h3>
                    <p><?php echo $sinavSecSatir['tarih']; ?></p>
                    <p><?php echo $soruSayisi; ?> Soru</p>
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="delete" value="<?php echo $sinavSecSatir['id']; ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bu sınavı silmek istediğinize emin misiniz?');">Sınavı Sil</button>
                    </form>
                </div>
            </div>
    <?php
        }
    }
    ?>

</div>
<!-- Admin Body Section End -->
<?php require_once('footer.php'); ?>