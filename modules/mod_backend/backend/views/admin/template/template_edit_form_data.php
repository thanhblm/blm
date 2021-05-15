<?php
use core\utils\RequestUtil;
use core\utils\ActionUtil;
use core\Lang;

// get data
$templateVo = RequestUtil::get ( "templateVo" );

?>
<!-- template-header -->
<div id="template-header"></div>
<script type="text/javascript">
    $("#template-header").load("<?=ActionUtil::getFullPathAlias("admin/container/edit/view/data?containerId={$templateVo->headerId}")?>");
</script>

<div class="layout-data">
    <div class="layout_content">
        <div class="layout_container">
            <div class="grid-control-menu container-control-menu bm-control-menu">
                <h4 class="grid-control-title">
                    <?=Lang::get('Main content')?>
                </h4>
            </div>
            <div class="container-main-content">
                <?=Lang::get('The main content of the website.')?>
            </div>
        </div>
    </div>
</div>

<!-- template-footer -->
<div id="template-footer"></div>
<script type="text/javascript">
    $("#template-footer").load("<?=ActionUtil::getFullPathAlias("admin/container/edit/view/data?containerId={$templateVo->footerId}")?>");
</script>