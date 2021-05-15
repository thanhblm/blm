<?php
namespace layout\widgets;
use core\utils\RequestUtil;

// get data (exist data $widgetContentInfo and $setting)
// add data
$widgetData = RequestUtil::get ( 'widgetData' );
?>

<div class='widget-content <?= ($widgetContentInfo['class'] != '') ? $widgetContentInfo['class'] : ''?>'
    <?= ($widgetContentInfo['style'] != '') ? "style='{$widgetContentInfo['class']}'" : ''?>>
    <?=$setting['content']?>
</div>