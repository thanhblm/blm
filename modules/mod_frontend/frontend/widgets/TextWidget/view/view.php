<?php
namespace layout\widgets;
use core\utils\RequestUtil;

// get data (exist data $widgetContentInfo and $setting)
// add data
$widgetData = RequestUtil::get ( 'widgetData' );
?>

<div class='widget-content <?= ($widgetContentInfo['class'] != '') ? $widgetContentInfo['class'] : ''?>'
    <?= ($widgetContentInfo['style'] != '') ? "style='{$widgetContentInfo['class']}'" : ''?>>
	<?php if($setting['showTitle']){?>
		<h3><?=$setting['title'] ?></h3>
	<?php } ?>
	
	<div class='widget-content-text'>
		<?=$setting['content']?>
	</div>
</div>