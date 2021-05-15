<?php
use common\utils\RenderUtil;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\AppUtil;

// get data
$containerVo = RequestUtil::get ( "containerVo" );
$containerId = RequestUtil::get ( "containerId" );
$viewPath = RequestUtil::get ( "viewPath" );
$layoutData = RequestUtil::get ( "layoutData" );
$gridList = $layoutData ['gridList'];

?>
<!-- custom style -->
<link href="<?=AppUtil::resource_url("global/css/layout.css") ?>" rel="stylesheet" type="text/css" />

<div id="layout-data<?=$containerVo->id?>" class="layout-data">
    <div class="layout_content">
        <div id="container_<?=$containerId?>" class="layout_container" data-containerid="<?=$containerId?>">
            <div class="grid-control-menu container-control-menu bm-control-menu">
                <div class="grid-control-menu-actions container-control-menu-actions">
                    <div class="btn-group action margin-right-10">
                        <a href="javascript:gridAddView<?=$containerId?>(<?=$containerId?>, 0)" title="<?php echo Lang::get('Add grid')?>"> <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <h4 class="grid-control-title">
                    <?php echo $containerVo->name?>
                </h4>
            </div>
            <div class="container-content">
            <?php
            if (! empty ( $gridList [$containerId] )) {
                $template = $viewPath . '/admin/container/layout/grid/grid_item.php';
                $params = array (
                    'containerId' => $containerId,
                    'class' => array (
                        "layout_grid layout_grid$containerId ul-sortable ul-sortable$containerId",
                        "ul-sortable ul-sortable$containerId",
                        "ul-sortable ul-sortable$containerId",
                        "ul-sortable ul-sortable$containerId",
                        "ul-sortable ul-sortable$containerId",
                        "ul-sortable ul-sortable$containerId",
                        "ul-sortable ul-sortable$containerId",
                    ),
                    'containerVo' => $containerVo
                );
                RenderUtil::recursive ( $gridList [$containerId], 0, 0, 0, true, $template, $params );
            }
            ?>
            </div>
        </div>
    </div>
</div>

<?php include 'script/script_layout.php' ?>
<?php include "script/script_sortable.php";?>