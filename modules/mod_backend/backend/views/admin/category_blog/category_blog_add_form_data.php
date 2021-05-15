<?php
use common\template\extend\Button;
use common\template\extend\FormContainer;
use common\template\extend\Link;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$categoryBlog = RequestUtil::get('categoryBlog');

$form = new FormContainer ();
$form->id = "category_blog_add_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart();
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?= Lang::get('Add categoryBlog') ?></span>
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
			$button->attributes = "type='button' onclick='addAndCloseCategoryBlog()'";
			$button->class = "btn btn-sm blue margin-bottom-5";
			$button->render();

			$button = new Button ();
			$button->title = "<i class='fa fa-plus'></i> " . Lang::get("Save");
			$button->class = "btn btn-sm blue margin-bottom-5";
			$button->attributes = "type='button' onclick='addCategoryBlog()'";
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
					<?php include_once 'add_form/category_blog_add_general_data.php'; ?>
                </div>
                <div class="tab-pane" id="tab_language">
					<?php include_once 'add_form/category_blog_add_localization_data.php'; ?>
                </div>
                <div class="tab-pane" id="tab_seo">
					<?php include_once 'add_form/category_blog_add_seo_data.php'; ?>
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
	function addCategoryBlog(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/category/blog/add?rtype=json")?>",
			$("#category_blog_add_form").serialize(),
			onAddCategoryBlogSuccess,
			onAddCategoryBlogFieldErrors,
			onAddCategoryBlogActionErrors
		);
	}
	function onAddCategoryBlogSuccess(res){
        showMessage(res.errorMessage);
		location.href = "<?=ActionUtil::getFullPathAlias('admin/category/blog/edit/view')?>" + "?id=" + res.extra.categoryBlogId;
	}
	function onAddCategoryBlogFieldErrors(res){
		$("#category_blog_add_form").replaceWith(res.content);
	}
	function onAddCategoryBlogActionErrors(res){
		showMessage(res.errorMessage, 'error');
	}

	function addAndCloseCategoryBlog(){
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("admin/category/blog/add?rtype=json")?>",
			$("#category_blog_add_form").serialize(),
			onAddAndCloseCategoryBlogSuccess,
			onAddAndCloseCategoryBlogFieldErrors,
			onAddAndCloseCategoryBlogActionErrors
		);
	}
	function onAddAndCloseCategoryBlogSuccess(res){
        showMessage(res.errorMessage);
		location.href = "<?=ActionUtil::getFullPathAlias('admin/category/blog/list')?>";
	}
	function onAddAndCloseCategoryBlogFieldErrors(res){
		$("#category_blog_add_form").replaceWith(res.content);
	}
	function onAddAndCloseCategoryBlogActionErrors(res){
		showMessage(res.errorMessage, 'error');
	}
</script>