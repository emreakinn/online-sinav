<?php require_once('header.php'); ?>
<!-- Admin Body Section Start -->
<div class="row">
    <div class="col-6">
        <h3>Yeni Yazı Ekle</h3>
    </div>
    <div class="col-6 text-end">
        <a href="haberler.php" class="btn btn-info text-white">Tümünü Gör</a>
    </div>
</div>
<div class="row">
    <form action="" method="post" class="row">
        <div class="col-md-9">
            <input type="text" name="baslik" placeholder="Başlık Girin" class="form-control mb-2">
            <textarea name="aciklama" id="editor1" placeholder="Haber Girin"></textarea>
            <script>
                ClassicEditor
                    .create(document.querySelector('#editor1'))
                    .then(editor => {
                        editor.ui.view.editable.element.style.height = '100px';
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
                <option value="">Seçiniz</option>
                <option value="Taslak">Taslak</option>
                <option value="Yayında">Yayınla</option>
            </select>
            <div class="my-2">
                <label>Tarih</label>
                <input type="date" name="tarih" class="form-control">
            </div>
            <button class="submit btn btn-success w-100" name="haber_kaydet">Kaydet</button>

            <?php

            if (isset($_POST['haber_kaydet'])) {
                $baslik = $_POST['baslik'];
                $aciklama = $_POST['aciklama'];
                $durum = $_POST['durum'];
                $tarih = $_POST['tarih'];

                $kaydet = $db->prepare('insert into haberler (baslik,aciklama,durum,tarih) values(?,?,?,?)');
                $kaydet->execute(array($baslik, $aciklama, $durum, $tarih,));

                if ($kaydet->rowCount()) {
                    echo '<div class="alert alert-success"> Haber Kayıt Edildi </div>';
                } else {
                    echo '<div class="alert alert-danger"> Hata Oluştu </div>';
                }
            }
            ?>

        </div>
    </form>
</div>
<!-- Admin Body Section End -->
<?php require_once('footer.php'); ?>