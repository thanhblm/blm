<?php
use common\template\extend\Button;
use common\template\extend\FormContainer;
use common\template\extend\Link;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$categoryBlog = RequestUtil::get('categoryBlog');

$form = new FormContainer ();
$form->id = "category_blog_copy_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart();
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?= Lang::get('Copy category blog') ?></span>
        </div>
        <div class="actions btn-set">
			<?php
			$link = new Link ();
			$link->title = Lang::get('Back');
			$link->link = ActionUtil::getFullPathAlias('admin/category/blog/list');
			$link->class = "btn btn-sm grey margin-bottom-5";
			$link->render();

			$button = new Button ();
			$button->title = "<i class='fa fa-plus'></i> " . Lang::get("Save & close");
			$button->class = "btn btn-sm blue margin-bottom-5";
			$button->attributes = "type='button' onclick='copyAndCloseCategoryBlog()'";
			$button->render();

            $button = new Button ();
            $button->title = "<i class='fa fa-plus'></i> " . Lang::get("Save");
            $button->class = "btn btn-sm blue margin-bottom-5";
            $button->attributes = "type='button' onclick='copyCategoryBlog()'";
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
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_general">
					<?php include_once 'copy_form/category_copy_general_data.php'; ?>
                </div>
                <div class="tab-pane" id="tab_language">
					<?php include_once 'copy_form/category_copy_localization_data.php'; ?>
                </div>
                <div class="tab-pane" id="tab_seo">
					<?php include_once 'copy_form/category_copy_seo_data.php'; ?>
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
    function copyCategoryBlog(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/category/blog/copy?rtype=json")?>",
            $("#category_blog_copy_form").serialize(),
            onCopyCategorySuccess,
            onCopyCategoryFieldErrors,
            onCopyCategoryActionErrors
        );
    }
    function onCopyCategorySuccess(res){
        showMessage(res.errorMessage);
        location.href = "<?=ActionUtil::getFullPathAlias('admin/category/blog/edit/view')?>" + "?id=" + res.extra.categoryId;
    }
    function onCopyCategoryFieldErrors(res){
        $("#category_blog_copy_form").replaceWith(res.content);
    }
    function onCopyCategoryActionErrors(res){
        showMessage(res.errorMessage, 'error');
    }

    function copyAndCloseCategoryBlog(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/category/blog/copy?rtype=json")?>",
            $("#category_blog_copy_form").serialize(),
            onCopyAndCloseCategorySuccess,
            onCopyAndCloseCategoryFieldErrors,
            onCopyAndCloseCategoryActionErrors
        );
    }
    function onCopyAndCloseCategorySuccess(res){
        location.href = "<?=ActionUtil::getFullPathAlias('admin/category/blog/list')?>";
    }
    function onCopyAndCloseCategoryFieldErrors(res){
        $("#category_blog_copy_form").replaceWith(res.content);
    }
    function onCopyAndCloseCategoryActionErrors(res){
        showMessage(res.errorMessage, 'error');
    }
</script>
<!-- tinymce end -->