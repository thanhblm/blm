<?php
use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\Button;
$pageVo = RequestUtil::get ( "pageVo" );
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <?php if($pageVo->cacheEnable == 'yes'){?>
        <h4 class="modal-title"><?=Lang::get("Disable Cache")?></h4>
    <?php } else {?>
        <h4 class="modal-title"><?=Lang::get("Enable Cache")?></h4>
    <?php }?>
</div>
<div class="modal-body">
    <form id="page_dialog_form" class="form-horizontal" novalidate="novalidate">
        <input name="pageId" type="hidden" value="<?=$pageVo->id?>" />
        <div class="form-body">
            <?php if($pageVo->cacheEnable == 'yes'){?>
                <p><?=Lang::getWithFormat("Are you sure you want to <u>disable cache</u> page <b>{0}</b>?",$pageVo->name)?></p>
            <?php } else {?>
                <p><?=Lang::getWithFormat("Are you sure you want to <b>enable cache</b> page <b>{0}</b>?",$pageVo->name)?></p>
            <?php }?>
        </div>
    </form>
</div>
<div class="modal-footer">
    <?php
    $button = new Button();
    $button->type = "button";
    $button->id = "btnAction";
    $button->title = " " . Lang::get ( "Yes" );
    $button->class = "btn btn-sm blue margin-bottom-5";
    $button->attributes = "";
    $button->render ();

    $button = new Button ();
    $button->type = "button";
    $button->id = "";
    $button->title = " " . Lang::get ( "No" );
    $button->class = "btn btn-sm btn-close margin-bottom-5";
    $button->attributes = "data-dismiss=\"modal\"";
    $button->render ();
    ?>
</div>