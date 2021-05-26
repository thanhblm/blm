<?php
use common\helper\LayoutHelper;
use core\utils\RequestUtil;
?>
<?php $pageId = 114?>
<div id="content-extra" data-pageid="<?=$pageId?>">
    <?php
    	echo LayoutHelper::getPageContent($pageId, RequestUtil::get("languageCode"));
    ?>
</div>