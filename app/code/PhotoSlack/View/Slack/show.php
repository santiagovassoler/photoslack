<?php include 'app/code/PhotoSlack/View/header.php' ?>
<?php
/**@var $image */
/**@var $reaction */
?>
<div class="main">
    <div class="container">
        <div class="gallery">
                <div class="<?= count($image) > 1 ? 'main-carousel' : 'no-carousel'?>">
                    <?php foreach($image as $key => $img): ?>
                        <div class="carousel-cell">
                            <?= '<img class="gallery-item" src=' . $img->getImageUrl() . '>'?>
                        </div>
                    <?php endforeach;?>
                </div>
        </div>
        <?php foreach ($reaction as $reactions):?>
        <span class="reactions"><?=$reactions->getName();?><pan class="count"><?=$reactions->getCount();    ?></pan></span>
        <?php endforeach;?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
<script>
    $('.main-carousel').flickity({
        // options
        cellAlign: 'left',
        contain: true
    });
</script>
