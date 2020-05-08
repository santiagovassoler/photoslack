<?php

include 'app/code/PhotoSlack/View/header.php';

use PhotoSlack\Model\Reaction;
use PhotoSlack\Model\Image;
use PhotoSlack\Model\Message;

/**@var Message[] $messages */
/**@var Reaction[] $reaction */
/**@var Image $img */

?>

<div class="main">
    <div class="parent">
        <?php foreach($messages as $message): ?>
            <?php foreach($message->getImageList() as $img): ?>
                <?= '<img class="child" src=' .  $img->getImageUrl() . '>'?>
            <?php endforeach;?>
        <div>
            <div class="img-text">
                <h2><?= $message->getText()?></h2>
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
