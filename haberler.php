<?php require_once('header.php') ?>

<section id="haberler" class="banner">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-1">Haberler</h1>
            </div>
        </div>
    </div>
</section>
<!-- Blog Banner Section End -->

<!-- Search Section Start -->

<section id="haberler" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="" method="get">
                    <input type="search" name="ara" placeholder="Site içi blog arama" class="form-control">
                </form>
            </div>
        </div>
    </div>
</section>

<section id="blogList" class="py-5">
    <div class="container">
        <div class="row" style="row-gap:25px;">
            <?php
            $haberler_list = $db->prepare('select * from haberler where durum="Yayında" order by id desc');
            $haberler_list->execute();

            if ($haberler_list->rowCount()) {
                foreach ($haberler_list as $haberler_list_satir) {
            ?>
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body">
                                <h2><?php echo $haberler_list_satir['baslik']; ?></h2>
                                <p><?php echo $haberler_list_satir['aciklama']; ?></p>
                                <small>Yayın Tarihi : <?php echo $haberler_list_satir['tarih']; ?></small>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</section>


<?php require_once('footer.php') ?>