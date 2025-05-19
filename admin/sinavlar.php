<?php require_once('header.php');

if (isset($_GET['deleteID'])) {
    $id = $_GET['deleteID'];

    $soru_sil = $db->prepare('delete from sorular where sinav_id=?');
    $soru_sil->execute(array($id));

    $sinav_sil = $db->prepare('delete from sinavlar where id=?');
    $sinav_sil->execute(array($id));

    if ($soru_sil->rowCount()) {
        echo '<script> alert("Sınav Silindi") </script><meta http-equiv="refresh" content="0; url=sinavlar.php">';
    } else {
        echo '<script> alert("Hata Oluştu") </script><meta http-equiv="refresh" content="0; url=sinavlar.php">';
    }
} else if (isset($_GET['updateID'])) {
    $id = $_GET['updateID'];

    $sinav_sec = $db->prepare('select * from sinavlar where id=? ');
    $sinav_sec->execute(array($id));
    $sinav_sec_satir = $sinav_sec->fetch();

    $soru_sec = $db->prepare('select * from sorular where sinav_id=? ');
    $soru_sec->execute(array($id));
    $sorular = $soru_sec->fetchAll();

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
<!-- Admin Body Section Start -->
<div class="row">
    <div class="col-12 text-center">
        <h3>Sınavlar</h3>
    </div>
</div>
<div class="row">
    <?php
    $sinavlarList = $db->prepare('select * from siniflar');
    $sinavlarList->execute();

    if ($sinavlarList->rowCount()) {
        foreach ($sinavlarList as $sinavlarListSatir) {
    ?>
            <div class="col-md-6">

                <table class="table table-striped mt-3">
                    <h4 class="table-title"><?php echo $sinavlarListSatir['sinif_adi'] ?></h4>
                    <thead>
                        <tr>
                            <th>Sınav Adı</th>
                            <th>Soru</th>
                            <th>Tarih</th>
                            <th>Son Tarih</th>
                            <th>Düzenle</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sinavlar = $db->prepare('select * from sinavlar where sinif_id=?');
                        $sinavlar->execute([$sinavlarListSatir['id']]);

                        if ($sinavlar->rowCount()) {
                            foreach ($sinavlar as $sinavlarList) {
                        ?>
                                <tr>
                                    <td><?php echo $sinavlarList['baslik'] ?></td>
                                    <td><?php echo $sinavlarList['soru_sayisi'] ?></td>
                                    <td><?php echo $sinavlarList['tarih'] ?></td>
                                    <td><?php echo $sinavlarList['sinav_sonu_tarihi'] ?></td>
                                    <?php
                                    $cevap_var = $db->prepare('select COUNT(*) from cevaplar where soru_id in (select id from sorular where sinav_id=?)');
                                    $cevap_var->execute(array($sinavlarList['id']));
                                    $degistirilemez = $cevap_var->fetchColumn() > 0;

                                    if ($degistirilemez) {
                                    ?>
                                        <td colspan="2" class="text-danger">Değiştirilemez</td>
                                    <?php
                                    } else {
                                    ?>
                                        <td> <a href="sinavlar.php?updateID=<?php echo $sinavlarList['id']; ?>" class="btn btn-warning">Düzenle</a> </td>
                                        <td> <a href="sinavlar.php?deleteID=<?php echo $sinavlarList['id']; ?>" class="btn btn-danger">Sil</a> </td>
                                    <?php
                                    }

                                    ?>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
    <?php
        }
    }
    ?>
</div>
<!-- Admin Body Section End -->

<!-- Update Modal Start -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $sinav_sec_satir['baslik']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="" method="POST" class="row">

                    <input type="hidden" name="sinav_id" value="<?php echo $sinav_sec_satir['id']; ?>">
                    <div class="col-6 my-2">
                        <select name="soru_sayisi_up" class="form-control">
                            <?php for ($i = 1; $i <= 10; $i++) {
                            ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?> Soru</option>
                            <?php }
                            ?>
                        </select>
                    </div>
                    <div class="col-6 my-2">
                        <input type="submit" name="soru_olustur_up" value="Soru Ekle" class="form-control">
                    </div>
                    <div class="col-12">
                        <input type="text" name="baslik_up" value="<?php echo $sinav_sec_satir['baslik']; ?>" class="form-control">
                    </div>
                    <div class="col-6 my-2">
                        <select name="sinif_id_up" class="form-control">
                            <option value="<?php echo $sinav_sec_satir['sinif_id']; ?>"><?php echo $sinav_sec_satir['sinif_id']; ?>. Sınıf</option>
                            <option value="1">1. Sınıf</option>
                            <option value="2">2. Sınıf</option>
                            <option value="3">3. Sınıf</option>
                            <option value="4">4. Sınıf</option>
                        </select>
                    </div>
                    <div class="col-3 my-2">
                        <input type="date" name="tarih_up" value="<?php echo $sinav_sec_satir['tarih']; ?>" class="form-control">
                    </div>
                    <div class="col-3 my-2">
                        <input type="date" name="sinav_sonu_tarihi_up" value="<?php echo $sinav_sec_satir['sinav_sonu_tarihi']; ?>" class="form-control">
                    </div>

                    <div id="sorular">
                        <?php
                        foreach ($sorular as $index => $soru) {
                        ?>
                            <input type="hidden" name="soru_id[]" value="<?php echo $soru['id']; ?>">
                            <div class="col-12 my-2">
                                <textarea name="soruup[]" rows="4" class="w-100"><?php echo $soru['soru']; ?></textarea>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row justify-content-between">
                                    <div class="col-md-2">
                                        <input type="text" name="aup[]" value="<?php echo $soru['a']; ?>" class="form-control" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="bup[]" value="<?php echo $soru['b']; ?>" class="form-control" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="cup[]" value="<?php echo $soru['c']; ?>" class="form-control" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="dup[]" value="<?php echo $soru['d']; ?>" class="form-control" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" name="eup[]" value="<?php echo $soru['e']; ?>" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="dogruup[]" value="<?php echo $soru['dogru']; ?>" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="puanup[]" value="<?php echo $soru['puan']; ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    if (isset($_POST['soru_olustur_up'])) {
                        $mevcut_soru_sayisi = count($sorular); // Mevcut soru sayısı
                        $yeni_soru_sayisi = $_POST['soru_sayisi_up']; // Eklenmesi gereken soru sayısı
                        if ($yeni_soru_sayisi > 0) {
                            for ($i = 0; $i < $yeni_soru_sayisi; $i++) {
                    ?>
                                <div class="col-12 my-2">
                                    <textarea name="yeni_soru[]" rows="4" class="w-100" placeholder="Yeni Soru"></textarea>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="row justify-content-between">
                                        <div class="col-md-2">
                                            <input type="text" name="yeni_a[]" placeholder="A Şıkkı" class="form-control" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="yeni_b[]" placeholder="B Şıkkı" class="form-control" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="yeni_c[]" placeholder="C Şıkkı" class="form-control" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="yeni_d[]" placeholder="D Şıkkı" class="form-control" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" name="yeni_e[]" placeholder="E Şıkkı" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" name="yeni_dogru[]" placeholder="Doğru Cevap" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" name="yeni_puan[]" placeholder="Puan" class="form-control">
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>

                    <div class="col-md-12 my-2">
                        <input type="submit" name="guncelle" value="Güncelle" class="btn btn-success form-control">
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['guncelle'])) {
    foreach ($_POST['soruup'] as $index => $soru) {
        $a = $_POST['aup'][$index];
        $b = $_POST['bup'][$index];
        $c = $_POST['cup'][$index];
        $d = $_POST['dup'][$index];
        $e = $_POST['eup'][$index];
        $dogru = $_POST['dogruup'][$index];
        $puan = $_POST['puanup'][$index];
        $soru_id = $_POST['soru_id'][$index];

        $guncelle = $db->prepare('update sorular set soru = ?, a = ?, b = ?, c = ?, d = ?, e = ?, dogru = ?, puan = ? where id = ?');
        $guncelle->execute(array($soru, $a, $b, $c, $d, $e, $dogru, $puan, $soru_id));

        $soru_sayisi = count($_POST['soruup']) + (isset($_POST['yeni_soru']) ? count($_POST['yeni_soru']) : 0);
        $ekle_sinav = $db->prepare('update sinavlar set sinif_id=?, baslik=?, tarih=?, sinav_sonu_tarihi=?, soru_sayisi=? where id = ?');
        $ekle_sinav->execute(array($_POST['sinif_id_up'], $_POST['baslik_up'], $_POST['tarih_up'], $_POST['sinav_sonu_tarihi_up'], $soru_sayisi, $_POST['sinav_id']));
    }

    if (isset($_POST['yeni_soru'])) {
        foreach ($_POST['yeni_soru'] as $index => $yeni_soru) {
            $a = $_POST['yeni_a'][$index];
            $b = $_POST['yeni_b'][$index];
            $c = $_POST['yeni_c'][$index];
            $d = $_POST['yeni_d'][$index];
            $e = $_POST['yeni_e'][$index];
            $dogru = $_POST['yeni_dogru'][$index];
            $puan = $_POST['yeni_puan'][$index];

            $ekle_soru = $db->prepare('insert into sorular (sinav_id, soru, a, b, c, d, e, dogru, puan) values (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $ekle_soru->execute(array($_POST['sinav_id'], $yeni_soru, $a, $b, $c, $d, $e, $dogru, $puan));
        }
    }
    echo '<script> alert("Sınav Güncellemesi Başarılı") </script><meta http-equiv="refresh" content="0; url=sinavlar.php">';
}
?>

<?php require_once('footer.php'); ?>