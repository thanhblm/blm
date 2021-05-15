<?php
namespace layout\widgets;
use core\utils\RequestUtil;

// get data (exist data $widgetContentInfo and $setting)
?>
<div class='widget-content <?= ($widgetContentInfo['class'] != '') ? $widgetContentInfo['class'] : ''?>'
    <?= ($widgetContentInfo['style'] != '') ? "style='{$widgetContentInfo['class']}'" : ''?>>
    <?php
    $customView = $setting['customView'];
    include $customView;
    ?>
</div>
