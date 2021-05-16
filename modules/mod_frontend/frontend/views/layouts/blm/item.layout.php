<?php
use core\Lang;
use common\utils\FileUtil;
use core\utils\AppUtil;
use common\helper\DatoImageHelper;use core\utils\RouteUtil;
$widgetContentList = $v['widgetContentList'];
$languageCode = $params['languageCode'];

//set $style
$style = $v['style'];
if(!AppUtil::isEmptyString($v['bgColor'])){
	$style .= "background-color: {$v['bgColor']}; ";
}
$imageId = $v['bgImage'];
if($imageId){
	$imageMo = DatoImageHelper::getImageInfoById($imageId);
	$imageLoad = DatoImageHelper::getUrl($imageMo);
	$style .= "background-image: url('$imageLoad'); ";

	if($v['bgSize'] != 'none' & $v['bgSize'] != 'auto'){
	    $style .= "background-size: {$v['bgSize']}; ";
    }
    if($imageId){
        $style .= "background-repeat: {$v['bgRepeat']}; ";
    }
}

$classWidth = "col-md-{$v['width']} col-xs-12";
?>

<div class="grid-content <?=$v['align']?>  <?=$classWidth?> <?=$v['class']?>" id="grid-<?=$v['id']?>"
	<?php if($style != '') echo "style=\"$style\""?>>
	<?php
		//build widgetContent list
		if(!$v['haveChild'] & !empty($widgetContentList)){
			echo "<div class='widget-list'>";
			foreach ($widgetContentList as $widgetContentInfo){
	?>
		<div class="widget-item widget-item-<?=$v['align']?> <?=$widgetContentInfo['class']?>" id="grid-widget-<?=$widgetContentInfo['gridWidgetId']?>"
			<?php if(!AppUtil::isEmptyString($widgetContentInfo['style'])) echo "style=\"{$widgetContentInfo['style']}\""?>>
			<?php
			//load controller
			if($widgetContentInfo['gridWidgetStatus'] == 'active'){
                FileUtil::loadWidgetController($widgetContentInfo);

                //run form method
                $mod = RouteUtil::getRoute()->getModule();
                $widgetController = str_replace('mod_', '', $mod) .'\widgets\\'. $widgetContentInfo['widgetController'];
                $control = new $widgetController($widgetContentInfo, array(), $languageCode);
                $control->view();
			}
			?>
		</div>
	<?php }
	echo "</div> <!-- end .connectedSortable -->";
		}
	?>