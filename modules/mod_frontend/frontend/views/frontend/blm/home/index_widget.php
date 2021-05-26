<?php
use common\helper\LayoutHelper;
use core\utils\RequestUtil;
use core\utils\RouteUtil;
use common\template\extend\ModalTemplate;
use core\utils\ActionUtil;
use core\utils\SessionUtil;
use core\config\ApplicationConfig;
?>
<?php $pageId = 1?>
<div id="content-extra" data-pageid="<?=$pageId?>">
    <?php
    echo LayoutHelper::getPageContent($pageId, RequestUtil::get("languageCode"));
    ?>
</div>
<script>
$(document ).ready(function() {
	$('div[data-content-action]').each(function() {
		var action = $(this).attr("data-content-action");
    	var currentURL = "<?php echo RouteUtil::getRoute()->getWebRoot()?>";
    	$(this).load(currentURL+"/"+action);
        $(this).removeAttr("data-content-action");
	});
});
</script>
