<?php
use common\template\extend\Button;
use core\Lang;

?>

<div class="modal-dialog modal-lg">
    <div class="t-alr">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
    </div>
    <div class="modal-content">
        <div class="modal-header" style="padding:0;">
            <h4 class="modal-title"><?= Lang::get("Delete Address") ?></h4>
        </div>
        <div class="modal-body">
			<?php include_once 'address_del_form_data.php'; ?>
        </div>
        <div class="modal-footer">
            <div class="_buttons dt-buttons">
				<?php
				$button = new Button ();
				$button->type = "button";
				$button->id = "btnSubmitAddress";
				$button->title = " " . Lang::get("Yes");
				$button->attributes = "";
				$button->class = "margin-top-10";
				$button->render();

				$button = new Button ();
				$button->type = "button";
				$button->id = "";
				$button->title = " " . Lang::get("No");
				$button->class = "margin-top-10";
				$button->attributes = "data-dismiss=\"modal\"";
				$button->render();
				?>
            </div>
        </div>
    </div>
</div>




