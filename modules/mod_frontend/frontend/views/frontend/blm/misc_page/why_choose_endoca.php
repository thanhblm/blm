<?php
use common\helper\DatoImageHelper;
use common\rule\url\friendly\ProductUrlFriendly;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use frontend\controllers\ControllerHelper;
use common\helper\LayoutHelper;
$bestSellers = RequestUtil::get("bestSellers");
?>
<?php $pageId = 142?>
<div id="content-extra" data-pageid="<?=$pageId?>">
    <?php
    	echo LayoutHelper::getPageContent($pageId, RequestUtil::get("languageCode"));
    ?>
</div>

<main id="main">
    <div class="light">
        <div class="row">
            <div class="row bestsellers-block">
                <h3 class="bestsellers-title"><?=Lang::get("Bestsellers")?></h3>
                <div class="bestsellers" data-jcarousel="true">
                    <?php
                    if(count($bestSellers)== 0){

                    }else{
                        foreach ($bestSellers as $bestSeller){
                            $imageMo = DatoImageHelper::getImageInfoById(json_decode($bestSeller->images)[0]);
                    ?>
                    <a href="<?= ActionUtil::getFullPathAlias("product/detail?id=$bestSeller->id", new ProductUrlFriendly($bestSeller->languageCode, $bestSeller->id, $bestSeller->seoUrl, $bestSeller->name)) ?>">
                        <div class="slick-inside categorySlideLink">
                            <div class="title" style="height: 50px;"><?=$bestSeller->name ?></div>
                            <img src="<?= DatoImageHelper::getUrl($imageMo) ?>" alt="" width="200" height="200">
                            <div>
                                <div class="intro_category">
                                    <div class="link">
                                        <?=Lang::get("Buy from")?> <?= ControllerHelper::showProductPrice($bestSeller->price) ?>
                                        <div class="arrow-wrap">
                                            <img src="<?=ActionUtil::getFullPathAlias("") ?>uploads/images/arrow3.png" alt="" style="width:40px; height:17px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php
                        }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</main>