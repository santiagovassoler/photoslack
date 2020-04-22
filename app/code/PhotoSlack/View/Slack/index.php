<?php include 'app/code/PhotoSlack/View/header.php' ?>
<div class="main">
<div class="container">
    <div data-gridify="5-columns">
        <?php  foreach ($collection as $slackModel): ?>
            <?php if ($slackModel->getImageList()): ?>
            <?php if ($slackModel->getImageList()[0]->getPublicUrlShared()):?>
                <div class="item">
                    <img id=<?=$slackModel->getImageList()[0]->getTs()?> onclick="showImage(this)" class="img-fluid" src="<?= $slackModel->getImageList()[0]->getImageUrl()?>">
                </div>
                <?php else:?>
                <div class="item">
                    <img id=<?=$slackModel->getImageList()[0]->getTs()?> onclick="showImage(this)" class="img-fluid" src="https://cdn130.picsart.com/267418255002211.png?type=webp&to=min&r=1024">
                </div>
                <?php endif;?>
            <?php endif;?>
        <?php endforeach; ?>
    </div>
</div>
<div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img">
    <div id="caption"></div>
</div>
</div>
<script type="text/javascript" src="/../../pub/static/js/gridify.js"></script>
<script type="text/javascript">
    window.onload = function() {
        gridify.init();
    };
</script>
<script>
    const modal = document.getElementById('myModal');
    const modalImg = document.getElementById('img');

    function showImage(imgElement) {
        const src = imgElement.getAttribute("src");
        modal.style.display = "block";
        modalImg.src = src;
    }
    const span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        modal.style.display = "none";
    }
</script>
