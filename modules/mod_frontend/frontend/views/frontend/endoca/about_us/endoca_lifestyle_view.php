<?php
use common\helper\LayoutHelper;
use core\utils\RequestUtil;
?>
<?php $pageId = 116?>
<div id="content-extra" data-pageid="<?=$pageId?>" style="background-color: #f5f6f9;">
    <?php
    	echo LayoutHelper::getPageContent($pageId, RequestUtil::get("languageCode"));
    ?>
</div>