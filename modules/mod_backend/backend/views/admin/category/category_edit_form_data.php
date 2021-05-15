<?php
use common\template\extend\Button;
use common\template\extend\FormContainer;
use common\template\extend\Link;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$category = RequestUtil::get('category');

$form = new FormContainer ();
$form->id = "category_edit_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart();
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?= Lang::get('Edit category') ?></span>
        </div>
        <div class="actions btn-set">
			<?php
			$link = new Link ();
			$link->title = Lang::get('Back');
			$link->link = ActionUtil::getFullPathAlias('admin/category/list');
			$link->class = "btn btn-sm grey margin-bottom-5";
			$link->render();

			$button = new Button ();
			$button->title = "<i class='fa fa-plus'></i> " . Lang::get("Save & close");
			$button->class = "btn btn-sm blue margin-bottom-5";
			$button->attributes = "type='button' onclick='editAndCloseCategory()'";
			$button->render();

            $button = new Button ();
            $button->title = "<i class='fa fa-plus'></i> " . Lang::get("Save");
            $button->class = "btn btn-sm blue margin-bottom-5";
            $button->attributes = "type='button' onclick='editCategory()'";
            $button->render();
			?>
        </div>
    </div>
    <div class="portlet-body">
		<?php
		if (RequestUtil::hasActionErrors()) {
			?>
            <div class="alert alert-danger" role="alert">
				<?= RequestUtil::getErrorMessage(); ?>
            </div>
			<?php
		}
		if (RequestUtil::hasFieldErrors()) {
			?>
            <div class="alert alert-danger" role="alert"><?= Lang::get("There are some field errors, please check!") ?></div>
			<?php
		}
		if (RequestUtil::hasActionMessages()) {
			?>
            <div id="alert_info" class="alert alert-info" role="alert">
				<?= RequestUtil::getActionMessage() ?>
            </div>
			<?php
		}
		?>
        <div class="tabbable-line">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_general" data-toggle="tab"><?= Lang::get('General') ?> </a>
                </li>
                <li>
                    <a href="#tab_language" data-toggle="tab"> <?= Lang::get('Localization') ?> </a>
                </li>
                <li>
                    <a href="#tab_seo" data-toggle="tab"> <?= Lang::get('SEO') ?> </a>
                </li>
	            <li>
		            <a href="#tab_area" data-toggle="tab"> <?= Lang::get('Area') ?> </a>
	            </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_general">
					<?php include_once 'edit_form/category_edit_general_data.php'; ?>
                </div>
                <div class="tab-pane" id="tab_language">
					<?php include_once 'edit_form/category_edit_localization_data.php'; ?>
                </div>
                <div class="tab-pane" id="tab_seo">
					<?php include_once 'edit_form/category_edit_seo_data.php'; ?>
                </div>
	            <div class="tab-pane" id="tab_area">
		            <?php include_once 'edit_form/category_edit_area_data.php'; ?>
	            </div>
            </div>
        </div>
    </div>
</div>
<?php $form->renderEnd(); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$("textarea.ckeditor").ckeditor();
	});
</script>
<script type="text/javascript">
 function editCategory(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/category/edit?rtype=json")?>",
            $("#category_edit_form").serialize(),
            onEditCategorySuccess,
            onEditCategoryFieldErrors,
            onEditCategoryActionErrors
        );
    }
    function onEditCategorySuccess(res){
        $("#category_edit_form").replaceWith(res.content);
    }
    function onEditCategoryFieldErrors(res){
        $("#category_edit_form").replaceWith(res.content);
    }
    function onEditCategoryActionErrors(res){
        showMessage(res.errorMessage, 'error');
    }

    function editAndCloseCategory(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/category/edit?rtype=json")?>",
            $("#category_edit_form").serialize(),
            onEditAndCloseCategorySuccess,
            onEditAndCloseCategoryFieldErrors,
            onEditAndCloseCategoryActionErrors
        );
    }
    function onEditAndCloseCategorySuccess(res){
        location.href = "<?=ActionUtil::getFullPathAlias('admin/category/list')?>";
    }
    function onEditAndCloseCategoryFieldErrors(res){
        $("#category_edit_form").replaceWith(res.content);
    }
    function onEditAndCloseCategoryActionErrors(res){
        showMessage(res.errorMessage, 'error');
    }
</script>