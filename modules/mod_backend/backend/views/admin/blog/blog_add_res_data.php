<?php
use common\template\extend\Button;
use common\template\extend\Link;
use common\template\extend\SelectInput;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$pages = RequestUtil::get('pages');
$categories = RequestUtil::get('categories');
$blog = RequestUtil::get('blog');
?>
<form class="form-horizontal form-row-seperated" id="add_blog_form" method="post">
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption font-dark">
                <span class="caption-subject bold uppercase"><?= Lang::get('Add Blog') ?></span>
            </div>
            <div class="actions btn-set">
				<?php
				$link = new Link ();
				$link->title = Lang::get('Back');
				$link->link = ActionUtil::getFullPathAlias('admin/blog/list');
				$link->class = "btn btn-sm grey margin-bottom-5";
				$link->render();

				$button = new Button ();
				$button->id = "btnAddBlog";
				$button->icon = "<i class='fa fa-plus'></i>";
				$button->title = Lang::get("Save & Close");
				$button->class = "btn btn-sm blue margin-bottom-5";
				$button->attributes = "type='button' onclick='addBlog()'";
				$button->render();

				$button = new Button ();
				$button->id = "btnAddBlog";
				$button->icon = "<i class='fa fa-plus'></i>";
				$button->title = Lang::get("Save");
				$button->class = "btn btn-sm blue margin-bottom-5";
				$button->attributes = "type='button' onclick='addToEditBlog()'";
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
			?>
			<?php
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
                        <a href="#tab_region" data-toggle="tab"> <?= Lang::get('Region') ?> </a>
                    </li>
                    <li>
                        <a href="#tab_relate" data-toggle="tab"> <?= Lang::get('Related Blogs') ?> </a>
                    </li>
                    <li>
                        <a href="#tab_image" data-toggle="tab"> <?= Lang::get('Images') ?> </a>
                    </li>
                    <li>
                        <a href="#tab_seo" data-toggle="tab"> <?= Lang::get('Seo') ?> </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_general">
                        <!-- Begin Tab General -->
                        <input type="hidden" id="id" name="blog[id]" value="<?= $blog->id ?>"/>
                        <div class="form-body">
							<?php
							$text = new TextInput ();
							$text->errorMessage = RequestUtil::getFieldError("blog[name]");
							$text->hasError = RequestUtil::isFieldError("blog[name]");
							$text->label = Lang::get("Name");
							$text->required = true;
							$text->name = "blog[name]";
							$text->value = $blog->name;
							$text->render();

							$select = new SelectInput ();
							$select->id = "blog_category";
							$select->name = "blog[categoryBlogId]";
							$select->headerKey = "";
							$select->headerValue = Lang::get ( "Select One" );
							$select->collections = $categories;
							$select->collectionType = SelectInput::CT_SINGLE_ARRAY_OBJECT;
							$select->propertyName = "id";
							$select->propertyValue = "name";
							$select->value = $blog->categoryBlogId;
							$select->label = Lang::get("Category");
							$select->errorMessage = RequestUtil::getFieldError("blog[categoryBlogId]");
							$select->hasError = RequestUtil::isFieldError("blog[categoryBlogId]");
							$select->required = true;
							$select->class = "form-control input-sm";
							$select->render();

							$select = new SelectInput ();
							$select->name = "blog[status]";
							$select->headerKey = "";
							$select->headerValue = Lang::get ( "Select One" );
							$select->collections = ApplicationConfig::get("common.status.list");
							$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
							$select->label = Lang::get("Status");
							$select->errorMessage = RequestUtil::getFieldError("blog[status]");
							$select->hasError = RequestUtil::isFieldError("blog[status]");
							$select->required = true;
							$select->class = "form-control input-sm";
							$select->render();
							?>
                            <div class="form-group ">
                                <label class="control-label col-md-4"><?= Lang::get("Featured") ?> </label>
                                <div class="col-md-8">
                                		<input type="radio" name="blog[featured]" value="yes"><?=Lang::get('Yes')?>&nbsp;
                                		<input type="radio" name="blog[featured]" value="no" checked="checked"><?=Lang::get('No')?>
                                </div>
                            </div>
                            
                            <div class="form-group ">
                                <label class="control-label col-md-4"><?= Lang::get("Is Seo") ?> </label>
                                <div class="col-md-8">
                                		<input type="radio" name="blog[isSeo]" value="yes"><?=Lang::get('Yes')?>&nbsp;
                                		<input type="radio" name="blog[isSeo]" value="no" checked="checked"><?=Lang::get('No')?>
                                </div>
                            </div>
                            
							<?php
							$text = new TextInput ();
							$text->errorMessage = RequestUtil::getFieldError ( "blog[tag]" );
							$text->hasError = RequestUtil::isFieldError ( "blog[tag]" );
							$text->label = Lang::get ( "Tag" );
							$text->name = "blog[tag]";
							$text->value = $blog->tag;
							$text->render ();
							
							$text = new TextArea ();
							$text->label = Lang::get("Composition");
							$text->required = false;
							$text->name = "blog[composition]";
							$text->value = $blog->composition;
							$text->class = "ckeditor";
							$text->render();

							$text = new TextArea ();
							$text->label = Lang::get("Description");
							$text->required = false;
							$text->value = $blog->description;
							$text->name = "blog[description]";
							$text->class = "ckeditor";
							$text->render();
							?>
                        </div>
                        <!-- End Tab General -->
                    </div>
                    <div class="tab-pane" id="tab_language">
						<?php include_once 'lang/blog_lang_form_add_data.php'; ?>
                    </div>
                    <div class="tab-pane" id="tab_region">
						<?php include_once 'region/blog_region_add_view_data.php'; ?>
                    </div>
                    <div class="tab-pane" id="tab_relate">
						<?php include_once 'relation/blog_relation_add_view_data.php'; ?>
                    </div>
                    <div class="tab-pane" id="tab_image">
						<?php include_once 'image/blog_image_add_view_data.php'; ?>
                    </div>
                    <div class="tab-pane" id="tab_seo">
						<?php include_once 'seo/blog_seo_form_add_data.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $(".check-featured").click(function () {
            if ($(this).is(":checked")) {
                $(this).val("yes");
            } else {
                $(this).val("no");
            }
        });
        //tinyMCEInit();
        $("textarea.ckeditor").ckeditor();
    });
</script>
<!-- tinymce end -->