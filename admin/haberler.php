<?php
require_once('header.php');
if (isset($_GET['deleteID'])) {
    $id = $_GET['deleteID'];

    $haber_delete = $db->prepare('delete from haberler where id=?');
    $haber_delete->execute(array($id));

    if ($haber_delete->rowCount()) {
        echo '<script> alert("Haber Silindi") </script><meta http-equiv="refresh" content="0; url=haberler.php">';
    } else {
        echo '<script> alert("Hata Oluştu") </script><meta http-equiv="refresh" content="0; url=haberler.php">';
    }
} else if (isset($_GET['updateID'])) {
    $id = $_GET['updateID'];

    $haber_select = $db->prepare('select * from haberler where id=?');
    $haber_select->execute(array($id));
    $haber_select_satir = $haber_select->fetch();

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
    <div class="col-md-6">
        <h3>Yazılar</h3>
    </div>
    <div class="col-md-6 text-end">
        <a href="haber_ekle.php" class="btn btn-info text-white">Yeni yazı ekle</a>
    </div>
</div>
<div class="row">
    <div class="-col-12">
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Açıklama</th>
                    <th>Tarih</th>
                    <th>Düzenle</th>
                    <th>Sil</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $haberler_list = $db->prepare('select * from haberler order by id desc');
                $haberler_list->execute();

                if ($haberler_list->rowCount()) {
                    foreach ($haberler_list as $haberler_list_satir) {
                ?>
                        <tr>
                            <td> <?php echo $haberler_list_satir['baslik']; ?> </td>
                            <td> <?php echo substr($haberler_list_satir['aciklama'], 0, 200); ?> </td>
                            <td> <?php echo $haberler_list_satir['tarih']; ?> </td>
                            <td> <a href="haberler.php?updateID=<?php echo $haberler_list_satir['id']; ?>" class="btn btn-warning">Düzenle</a> </td>
                            <td> <a href="haberler.php?deleteID=<?php echo $haberler_list_satir['id']; ?>" class="btn btn-danger">Sil</a> </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Admin Body Section End -->

<!-- Update Modal Start -->

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $haberler_list_satir['baslik']; ?> - Güncelle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="" method="post" class="row">
                    <div class="col-md-9">
                        <input type="text" name="baslik" value="<?php echo $haberler_list_satir['baslik']; ?>" class="form-control mb-2">
                        <textarea name="aciklama" id="editor1"><?php echo $haberler_list_satir['aciklama']; ?></textarea>
                        <script>
                            ClassicEditor
                                .create(document.querySelector('#editor1'))
                                .then(editor => {
                                    editor.ui.view.editable.element.style.height = '200px';
                                    editor.ui.view.element.style.width = '100%';
                                })
                                .catch(error => {
                                    console.error(error);
                                });
                        </script>
                    </div>
                    <div class="col-md-3">
                        <label for="durum">Durum</label>
                        <select name="durum" id="durum" class="form-control">
                            <option value="<?php echo $haberler_list_satir['durum']; ?>"><?php echo $haberler_list_satir['durum']; ?></option>
                            <option value="Taslak">Taslak</option>
                            <option value="Yayında">Yayınla</option>
                        </select>
                        <div class="my-2">
                            <label>Tarih</label>
                            <input type="date" name="tarih" class="form-control" value="<?php echo $haberler_list_satir['tarih']; ?>">
                        </div>
                        <input type="hidden" name="haber_id" value="<?php echo $haberler_list_satir['id']; ?>">
                        <button class="submit btn btn-success w-100" name="haber_guncelle">Güncelle</button>

                        <?php
                        // Post Update Module Start    
                        if (isset($_POST['haber_guncelle'])) {
                            $baslik = $_POST['baslik'];
                            $aciklama = $_POST['aciklama'];
                            $durum = $_POST['durum'];
                            $tarih = $_POST['tarih'];
                            $haber_id = $_POST['haber_id'];

                            $haber_guncelle = $db->prepare('update haberler set baslik=?, aciklama=?, durum=?, tarih=? where id=?');
                            $haber_guncelle->execute(array($baslik, $aciklama, $durum, $tarih, $haber_id));

                            if ($haber_guncelle->rowCount()) {
                                echo '<script> alert("Güncelleme Başarılı") </script><meta http-equiv="refresh" content="0; url=haberler.php">';
                            } else {
                                echo '<script> alert("Hata Oluştu") </script><meta http-equiv="refresh" content="0; url=haberler.php">';
                            }
                        }
                        // Post Update Module End                                
                        ?>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- Update Modal End -->

<?php require_once('footer.php'); ?>