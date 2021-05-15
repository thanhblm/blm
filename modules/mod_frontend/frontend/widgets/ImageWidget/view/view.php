<?php
namespace layout\widgets;
use core\utils\RequestUtil;
use common\utils\ImageUtil;
use common\helper\DatoImageHelper;

// get data (exist data $widgetContentInfo and $setting)
// add data
$widgetData = RequestUtil::get ( 'widgetData' );
//get iamge
$imageId = $setting['imageId'];
$imageMo = DatoImageHelper::getImageInfoById($imageId);
$imageLoad = DatoImageHelper::getUrl($imageMo);
?>
<div class='widget-content <?= ($widgetContentInfo['class'] != '') ? $widgetContentInfo['class'] : ''?>'
    <?= ($widgetContentInfo['style'] != '') ? "style='{$widgetContentInfo['class']}'" : ''?>>
	<?php if($setting['showTitle']){?>
		<h3><?=$setting['title'] ?></h3>
	<?php } ?>
	<div class='widget-content-image'>
		<?php if($setting['url'] != ''){?>
			<a href='<?=$setting['url']?>' target='<?=$setting['target']?>'> <img src='<?=$imageLoad?>' title='<?=$setting['title']?>' alt='<?=$setting['title']?>' />
		</a>
		<?php } else{ ?>
			<img src='<?=$imageLoad?>' title='<?=$setting['title']?>' alt='<?=$setting['title']?>' />
		<?php } ?>
	</div>
</div>