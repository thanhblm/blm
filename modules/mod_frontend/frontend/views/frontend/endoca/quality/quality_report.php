<?php
use common\helper\LayoutHelper;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
$batchDatas = RequestUtil::get ( "batchDatas" );
$batchRelative = ApplicationConfig::get ( "batch.relative" );
?>
<main id="main">
    <article class="box _1of1 wide  text  photo" style="background-image: url(<?=ActionUtil::getFullPathAlias("") ?>uploads/images/-buy-cbd-rich-hemp-oil-from-endoca-com.png)">
        </br>
        
        <?php
        if (! is_null ( $batchDatas ) && count ( $batchDatas ) > 0) {
            foreach ( $batchDatas as $key => $value ) {
                ?>

        <div>
        <h1>
            <span class="wrap"><?=Lang::get("QUALITY REPORT") ?></span>
        </h1>
            <h4>
                <span class="wrap" style="font-style: italic;"><?=Lang::getWithFormat("{0}. Batch numbers:", $key) ?></span>
            </h4>
            <div class="batch-container">
                <div class="menu">
                    <?php
                $i = 0;
                foreach ( $value as $batchGroupName => $batchVos ) {
                    ?>
                    <a href="#batch<?=$i ?>" class="<?php if($i == 0) echo 'sel'; ?>"><?=$batchGroupName?></a>
                    <?php
                    $i += 1;
                }
                ?>
                </div>
                <div class="files">
                    <?php
                $j = 0;
                foreach ( $value as $batchs ) {
                    ?>
                    <div class="group <?php if($j == 0) echo 'sel'; ?>">
                        <?php
                    foreach ( $batchs as $batch ) {
                        ?>
                        <a href="<?=ActionUtil::getFullPathAlias ( $batchRelative . $batch->batchGroupId . DS . $batch->fileName )?>"><?=$batch->title ?></a>
                        <?php
                    }
                    ?>
                    </div>
                    <?php
                    $j += 1;
                }
                ?>
                </div>
            </div>
        </div>
        <?php
            }
        }
        ?>
    </article>

    <?php $pageId = 129?>
    <div id="content-extra" data-pageid="<?=$pageId?>">
        <?php
        echo LayoutHelper::getPageContent($pageId, RequestUtil::get("languageCode"));
        ?>
    </div>
</main>