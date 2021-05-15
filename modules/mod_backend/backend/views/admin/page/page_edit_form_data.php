<?php
use common\template\extend\Button;
use common\template\extend\Link;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use common\template\extend\FormContainer;
use common\template\extend\Text;
use common\template\extend\ModalTemplate;

$pageVo = RequestUtil::get('pageVo');

$form = new FormContainer();
$form->id = "page_edit_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart();
?>
<div class="portlet light">
	<div class="portlet-title">
		<div class="caption font-dark">
			<span class="caption-subject bold uppercase"><?=Lang::get('Edit Page')?></span>
		</div>
		<div class="actions btn-set">
			<?php
			$link = new Link ();
			$link->title = Lang::get ( 'Back' );
			$link->link = ActionUtil::getFullPathAlias ( 'admin/page/list' );
			$link->class = "btn btn-sm grey margin-bottom-5";
			$link->render ();
			
			$button = new Button ();
			$button->title = "<i class='fa fa-plus'></i> " . Lang::get("Save & close");
			$button->class = "btn btn-sm blue margin-bottom-5";
			$button->attributes = "type='button' onclick='editAndClosePage()'";
			$button->render();
			
			$button = new Button ();
			$button->icon = "<i class='fa fa-plus'></i>";
			$button->type = 'button';
			$button->title = Lang::get ( "Save" );
			$button->class = "btn btn-sm blue margin-bottom-5";
			$button->attributes = " onclick='editPage()'";
			$button->render ();
			?>
		</div>
	</div>
	<div class="portlet-body">
		<?php
		if (RequestUtil::hasActionErrors ()) {
			?>
		<div class="alert alert-danger" role="alert">
			<?=RequestUtil::getErrorMessage ();?>
		</div>
		<?php
		}
		?>
		<?php
		if (RequestUtil::hasActionMessages ()) {
			?>
		<div id="alert_info" class="alert alert-info" role="alert">
			<?=RequestUtil::getActionMessage()?>
		</div>
		<?php
		}
		?>
		<div class="tabbable-line">
			<?php 
			$text = new Text();
			$text->name = "pageId";
			$text->value = $pageVo->id;
			$text->type = "hidden";
			$text->render ();
			?>
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#tab_general" data-toggle="tab">
						<?=Lang::get('General')?> 
					</a>
				</li>
				<li class="_active">
					<a href="#tab_localization" data-toggle="tab"> 
						<?=Lang::get('Localization')?> 
					</a>
				</li>
				<li class="_active">
					<a href="#tab_seo" data-toggle="tab"> 
						<?=Lang::get('Seo')?> 
					</a>
				</li>
				<li class="_active">
					<a href="#tab_layout" data-toggle="tab">
						<?=Lang::get('Layout')?> 
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="tab_general">
					<?php include_once 'edit_form/page_edit_general_data.php';?>
				</div>
				<div class="tab-pane _active" id="tab_localization">
					<?php include_once 'edit_form/page_edit_localization_data.php';?>
				</div>
				<div class="tab-pane _active" id="tab_seo">
					<?php include_once 'edit_form/page_edit_seo_data.php';?>
				</div>
				<div class="tab-pane _active" id="tab_layout">
					<?php include_once 'layout/page_layout_edit.php';?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $form->renderEnd(); ?>

<?php
$modalTemplate = new ModalTemplate();
$modalTemplate->id = "layout_dialog";
$modalTemplate->size = 800;
$modalTemplate->render ();

$modalTemplate = new ModalTemplate();
$modalTemplate->id = "layout_dialog_large";
$modalTemplate->size = 1100;
$modalTemplate->render ();
?>

<script type="text/javascript">
	$(document).ready(function(){
		$("textarea.ckeditor").ckeditor();
	});
</script>
<script type="text/javascript">
    function editPage(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/page/edit?rtype=json")?>",
            $("#page_edit_form").serialize(),
            function (res){
                var message = '<?php echo Lang::get('The page is update successfully')?>';
                showMessage(message, 'success', true);
                resetValidate();
            },
            simpleAjaxPost_fieldErrorCallBack
        );
    }

    function editAndClosePage(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/page/edit?rtype=json")?>",
            $("#page_edit_form").serialize(),
            function (res){
                location.href = "<?=ActionUtil::getFullPathAlias('admin/page/list')?>";
            },
            simpleAjaxPost_fieldErrorCallBack
        );
    }
</script>