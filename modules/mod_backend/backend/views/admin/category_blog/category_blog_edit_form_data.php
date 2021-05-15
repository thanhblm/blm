<?php
use common\template\extend\Button;
use common\template\extend\FormContainer;
use common\template\extend\Link;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$categoryBlog = RequestUtil::get('categoryBlog');

$form = new FormContainer ();
$form->id = "category_edit_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart();
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?= Lang::get('Edit categoryBlog') ?></span>
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
			$button->attributes = "type='button' onclick='editAndCloseCategoryBlog()'";
			$button->render();

            $button = new Button ();
            $button->title = "<i class='fa fa-plus'></i> " . Lang::get("Save");
            $button->class = "btn btn-sm blue margin-bottom-5";
            $button->attributes = "type='button' onclick='editCategoryBlog()'";
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
					<?php include_once 'edit_form/category_blog_edit_general_data.php'; ?>
                </div>
                <div class="tab-pane" id="tab_language">
					<?php include_once 'edit_form/category_blog_edit_localization_data.php'; ?>
                </div>
                <div class="tab-pane" id="tab_seo">
					<?php include_once 'edit_form/category_blog_edit_seo_data.php'; ?>
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
 function editCategoryBlog(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/category/blog/edit?rtype=json")?>",
            $("#category_edit_form").serialize(),
            onEditCategoryBlogSuccess,
            onEditCategoryBlogFieldErrors,
            onEditCategoryBlogActionErrors
        );
    }
    function onEditCategoryBlogSuccess(res){
        $("#category_edit_form").replaceWith(res.content);
    }
    function onEditCategoryBlogFieldErrors(res){
        $("#category_edit_form").replaceWith(res.content);
    }
    function onEditCategoryBlogActionErrors(res){
        showMessage(res.errorMessage, 'error');
    }

    function editAndCloseCategoryBlog(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/category/blog/edit?rtype=json")?>",
            $("#category_edit_form").serialize(),
            onEditAndCloseCategoryBlogSuccess,
            onEditAndCloseCategoryBlogFieldErrors,
            onEditAndCloseCategoryBlogActionErrors
        );
    }
    function onEditAndCloseCategoryBlogSuccess(res){
        location.href = "<?=ActionUtil::getFullPathAlias('admin/category/blog/list')?>";
    }
    function onEditAndCloseCategoryBlogFieldErrors(res){
        $("#category_edit_form").replaceWith(res.content);
    }
    function onEditAndCloseCategoryBlogActionErrors(res){
        showMessage(res.errorMessage, 'error');
    }
</script>