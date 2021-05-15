<?php
use common\utils\RenderUtil;
use core\config\ApplicationConfig;
use core\utils\RequestUtil;

//get data
$containerVo = RequestUtil::get ( "containerVo" );
$languageCode = RequestUtil::get("languageCode");
$layoutPath = RequestUtil::get("layoutPath");
$gridList = RequestUtil::get("gridList");
?>

<div class="layout-container <?=$containerVo->class?>">
    <?php
    if(!empty($gridList)){
        $layoutName = ApplicationConfig::get('layout.name');
        $template = $layoutPath ."/$layoutName/item.layout.php";
        $params = array(
            'container' => 'div',
            'class' => array("layout_grid"),
            'containerVo' => $containerVo,
            'languageCode' => $languageCode,
        );
        RenderUtil::renderLayout($gridList, 0, 0, 0, true, $template, $params);
    }
    ?>
</div>
<div class="clear"></div>