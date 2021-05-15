<?php
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use common\helper\DatoImageHelper;
use common\rule\url\friendly\CategoryUrlFriendly;

$categories = RequestUtil::get('categories');
?>
<div class="content-line dgray our_categories" id="our_intro_categories">
    <div class="container">
        <div class="row"><h2><?=Lang::get("Product Categories")?></h2>
            <div class="categorySlider">
                <div class="categorySliderInner">
                    <div class="categorySlides">
                    <?php 
                    $i=0;
                    foreach ($categories as $category){
                    	$imageMo = DatoImageHelper::getImageInfoById($category->bigIcon);
                    ?>
                        <div class="categorySlide t-alc" >
                            <a class="categorySlideLink" href="javascript:find_out_more(<?= $i;?>);"  style="background: url('<?= DatoImageHelper::getLargeImageUrl($imageMo) ?>') no-repeat;background-size: 100% 100%;">
                                <div class="cat-block intro_category" id="intro_products_<?= $i;?>">
                                    <div class="title"><?= $category->name ?></div>
                                   
                                    <div class="link"><?=Lang::get("Find out more")?>
                                        <div class="arrow-wrap">
                                            <img src="<?=AppUtil::resource_url("layouts/endoca.com/images/arrow3.png")?>" alt="<?= $category->name ?>" title="<?= $category->name ?>" width="40" height="17">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
               <?php $i++; }?>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <?php 
            	$i=0;
				foreach ($categories as $category){
				$imageMo = DatoImageHelper::getImageInfoById($category->bigIcon);
			?>
            <div class="intro_category_sng n0 col-xs-12" style="display:none;" id="intro_product_<?= $i;?>">
                <span class="sprite top close"></span>
                <div class="close" onclick="close_more(<?= $i;?>)"><?=Lang::get("GO BACK TO<br>CATEGORIES")?></div>
                <div class="col-xs-3 fotob">
                    <img src="<?= DatoImageHelper::getLargeImageUrl($imageMo) ?>" alt="<?= $category->code ?>" title=" <?= $category->code ?> " width="487" height="584" class="foto">
                </div>
                <div class="col-xs-9 info">
                    <div class="title">
                        <a href="<?= ActionUtil::getFullPathAlias("category/detail?categoryId=" . $category->id, new CategoryUrlFriendly($category->languageCode, $category->id, $category->seoUrl, $category->name)) ?>"><?= $category->name ?></a>
                    </div>
                    <div class="announce"><?= $category->description?></div>
                    <div class="text"><?= $category->introduction?></div>
                    <div class="link">
                        <a title="<?= $category->name ?>" href="<?= ActionUtil::getFullPathAlias("category/detail?categoryId=" . $category->id, new CategoryUrlFriendly($category->languageCode, $category->id, $category->seoUrl, $category->name)) ?>"><?= $category->name ?></a>
                    </div>
                </div>
            </div>
            <?php $i++; }?>
            
        </div>
    </div>
</div>