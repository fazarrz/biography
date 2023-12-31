<?php

    if (isset($_POST['cari_bio'])) {
        $search_bio = $_POST['cari_bio'];

    }else {
        $search_bio = "";
    }

    $query_data_bio = mysqli_query($conn, "SELECT * FROM tbl_biography JOIN tbl_category ON tbl_biography.id_category = tbl_category.id_category WHERE status_bio = 1 AND title_bio LIKE '%$search_bio%' ORDER BY id_bio DESC");

    $data_page = 5;
    $data_all  = mysqli_num_rows($query_data_bio);
    $a = ceil($data_all / $data_page);
    
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }else{
        $page = 1;
    }   

    $b = ($page * $data_page) - $data_page;

    $link = 3;
    if ($page > $link) {
        $star_number = $page - $link;
    }
    else{
        $star_number = 1;
    }

    if ($page < ($a - $link)) {
        $end_number = $page - $link;
    }
    else{
        $end_number = $a;
    }

    $data_page_hal_bio = mysqli_query($conn, "SELECT * FROM tbl_biography  JOIN tbl_category ON tbl_biography.id_category = tbl_category.id_category WHERE status_bio=1 AND title_bio LIKE '%$search_bio%' LIMIT $b,$data_page");

    
    $jml_query = mysqli_num_rows($data_page_hal_bio);

?>





<div class="search-biography">
    <div class="bio-searching">
        <h3>Cari biografi favoritmu..</h3>
        <form action="?hal=biography" method="post">
            <input type="text" placeholder="Cari biografi..." name="cari_bio">
        </form>
    </div>
</div>
<div class="container">
    <div class="biography">
        <div class="card">
            <?php if ($jml_query > 0) :?>
            <?php while ($h  = mysqli_fetch_array($data_page_hal_bio)) :?>
            <div class="profile-card">
                <div class="profile-content">
                    <div class="profile-image">
                        <img src="../../assets/images/biography/<?= $h['img_bio']?>">
                    </div>
                    <div class="description">
                        <h3><?= $h['title_bio']?></h3>
                        <small><?= $h['name_category']?></small>
                    </div>
                    <div class="button-bio">
                        <a href="?hal=content_bio&id=<?= $h['id_bio']?>">Baca</a>
                    </div>
                </div>
            </div>
            <?php endwhile;?>

            <?php else:
                echo "Tidak ada biografi";
                endif;
            ?>
        </div>

        <div class="pagination-admin">
            <?php if($page > 1) :?>
                <a href="?hal=biography&page=<?php echo $page - 1?>">
                    &laquo;
                </a>
            <?php endif?>
            <?php for ($i=$star_number; $i <= $end_number; $i++) : ?>

                <?php if($page == $i) :?>
                <a href="?hal=biography&page= <?php echo $i?>" class="active">
                    <?php echo $i?>
                </a>
                <?php else:?>
                <a href="?hal=biography&page= <?php echo $i?>">
                    <?php echo $i?>
                </a>
                <?php endif;?>

            <?php endfor;?>

            <?php if($page < $a) :?>
                <a href="?hal=biography&page=<?php echo $page + 1?>">
                    &raquo;
                </a>
            <?php endif?>
            
        </div>
    </div>
</div>
