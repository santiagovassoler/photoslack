<?php

use PhotoSlack\Model\Image;
use PhotoSlack\Model\Message;

/** @var Message[] $collection */
?>

<div class="main">
    <div class="container">
        <div data-gridify="5-columns">
            <?php foreach ($collection as $slackModel):
                $image = $slackModel->getImageList()[0];
                /** @var  Image $image */
                 if ($slackModel && $slackModel->getImageList() && $image->getPublicUrlShared()) : ?>
                    <div class="item">
                        <img id=<?=$slackModel->getImageList()[0]->getTs()?> class="img-fluid" src="<?= $image->getImageUrl();?>">
                    </div>
                <?php endif;?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script type="text/javascript" src="/../../pub/static/js/gridify.js"></script>
<script type="text/javascript">
    window.onload = function() {
        gridify.init();
    };
</script>
