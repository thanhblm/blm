<?php
use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\Button;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title"><?=Lang::get("Recache all page")?></h4>
</div>
<div class="modal-body">
    <form id="page_dialog_form" class="form-horizontal" novalidate="novalidate">
        <div class="form-body">
            <p><?=Lang::getWithFormat("Are you sure you want to recache all page?")?></p>
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