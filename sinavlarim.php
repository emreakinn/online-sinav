<?php require_once('header.php');

if (isset($_GET['sinav'])) {
    $sinav = $_GET['sinav'];
    $sinavlar = $db->prepare('SELECT * FROM sinavlar WHERE id = ?');
    $sinavlar->execute(array($sinav));
    $sinavBilgi = $sinavlar->fetch();

    $sorular = $db->prepare('SELECT * FROM sorular WHERE sinav_id = ?');
    $sorular->execute(array($sinav));
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
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        $ad_soyad = $_SESSION['ad_soyad'];

                        $ogrenci_sorgu = $db->prepare('select sinif_id from ogrenciler where ad_soyad = ?');
                        $ogrenci_sorgu->execute(array($ad_soyad));
                        $ogrenci_sinif_id = $ogrenci_sorgu->fetchColumn();

                        $sinavlar = $db->prepare('select * from sinavlar where sinif_id = ?');
                        $sinavlar->execute(array($ogrenci_sinif_id));

                        foreach ($sinavlar as $sinavlarSatir) {
                        ?>
                            <div class="card shadow">
                                <div class="card-body">
                                    <h3>Sınav Adı: <?php echo $sinavlarSatir['baslik'] ?></h3>
                                    <div>Soru Sayısı: <b><?php echo $sinavlarSatir['soru_sayisi'] ?></b></div>
                                    <div>Son Tarih: <b><?php echo $sinavlarSatir['sinav_sonu_tarihi'] ?></b></div>
                                    <a class="text-success fs-3" href="sinavlarim.php?sinav=<?php echo $sinavlarSatir['id'] ?>"><b>Sınava Başla</b></a>
                                </div>
                            </div>
                        <?php
                        }

                        ?>
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
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $sinavlarSatir['baslik'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <?php
                    if (isset($sorular)) {
                        foreach ($sorular as $sorularSatir) {
                    ?>
                            <div class="mb-3">
                                <div><?php echo $sorularSatir['soru'] ?></div>
                                <small>
                                    <label for="html">A</label>
                                    <input type="radio" name="<?php echo $sorularSatir['a'] ?>" value="<?php echo $sorularSatir['a'] ?>">
                                    <label for="html"><?php echo $sorularSatir['a'] ?></label>
                                </small>
                                <small class="mx-5">
                                    <label for="html">B</label>
                                    <input type="radio" name="<?php echo $sorularSatir['b'] ?>" value="<?php echo $sorularSatir['b'] ?>">
                                    <label for="html"><?php echo $sorularSatir['b'] ?></label>
                                </small>
                                <small>
                                    <label for="html">C</label>
                                    <input type="radio" name="<?php echo $sorularSatir['c'] ?>" value="<?php echo $sorularSatir['c'] ?>">
                                    <label for="html"><?php echo $sorularSatir['c'] ?></label>
                                </small>
                                <small class="mx-5">
                                    <label for="html">D</label>
                                    <input type="radio" name="<?php echo $sorularSatir['d'] ?>" value="<?php echo $sorularSatir['d'] ?>">
                                    <label for="html"><?php echo $sorularSatir['d'] ?></label>
                                </small>
                                <small>
                                    <label for="html">E</label>
                                    <input type="radio" name="<?php echo $sorularSatir['e'] ?>" value="<?php echo $sorularSatir['e'] ?>">
                                    <label for="html"><?php echo $sorularSatir['e'] ?></label>
                                </small>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    <input type="submit" value="Sınavı Tamamla" name="sinavi_tamamla" class="btn btn-success w-100">
                </form>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php') ?>