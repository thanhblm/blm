<?php
use core\Lang;
use common\template\extend\Button;

?>
<div class="modal-dialog modal-lg">
    <div class="t-alr">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
    </div>
    <div class="modal-content">
        <div class="tabs-container dialog-tabs">
            <div class="tab-content">
                <div class="tab-pane in active">
                    <?php include_once 'home_logout_form_data.php'; ?>
                    <div class="_buttons dt-buttons">
                        <?php
                        $button = new Button();
                        $button->type = "button";
                        $button->id = "btnLogoutSubmit";
                        $button->title = " " . Lang::get("Logout");
                        $button->attributes = "";
                        $button->class = " ";
                        $button->render();

                        $button = new Button ();
                        $button->type = "button";
                        $button->id = "";
                        $button->title = " " . Lang::get("Cancel");
                        $button->class = "btn-close";
                        $button->attributes = "data-dismiss=\"modal\"";
                        $button->render();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>