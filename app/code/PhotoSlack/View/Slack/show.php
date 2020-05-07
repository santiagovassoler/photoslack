<?php

include 'app/code/PhotoSlack/View/header.php';

use PhotoSlack\Model\Reaction;
use PhotoSlack\Model\Image;
use PhotoSlack\Model\SlackModel;

/**@var SlackModel[] $images */
/**@var Reaction[] $reaction */
/**@var Image $img */

?>

<div class="main">
    <div class="parent">
        <?php foreach($images as $image): ?>
            <?php foreach($image->getImageList() as $img): ?>
                <?= '<img class="child" src=' .  $img->getImageUrl() . '>'?>
            <?php endforeach;?>
        <div>
            <div class="img-text">
                <h2><?= $image->getText()?></h2>
            </div>
        <?php endforeach;?>
            <div class="reactions">
                <?php if ($reaction) :?>
                    <?php foreach ($reaction as $reactions):?>
                        <span class="reactions-emoji"><?=$reactions->getName();?><pan class="count"><?=$reactions->getCount();?></pan></span>
                    <?php endforeach;?>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
