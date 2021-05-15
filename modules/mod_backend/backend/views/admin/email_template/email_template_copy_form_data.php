<?php
use common\template\extend\FormContainer;
use core\Lang;

$form = new FormContainer ();
$form->id = "copy_email_template_form";
$form->renderStart();
?>
<div class="tabbable-line">
    <ul class="nav nav-tabs ">
        <li class="active">
            <a href="#default" data-toggle="tab"> <?= Lang::get("Default") ?> </a>
        </li>
        <li>
            <a href="#localization" data-toggle="tab"> <?= Lang::get("Localization") ?> </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="default">
			<?php include 'copy_form/email_template_copy_general_data.php'; ?>
        </div>
        <div class="tab-pane" id="localization">
			<?php include 'copy_form/email_template_copy_localization_data.php'; ?>
        </div>
    </div>
</div>
<?php $form->renderEnd(); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$("textarea.ckeditor").ckeditor();
	});
</script>