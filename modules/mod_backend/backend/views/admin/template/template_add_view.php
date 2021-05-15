<?php
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\Lang;
use core\utils\ActionUtil;
use common\template\extend\ModalTemplate;
use common\template\extend\Text;
use common\template\extend\TextInput;
use common\template\extend\FormContainer;
use common\template\extend\Button;
use common\template\extend\Link;

// get data
$templateVo = RequestUtil::get ( "templateVo" );
$templateId = RequestUtil::get ( "templateId" );
$viewPath = RequestUtil::get ( "viewPath" );
$layoutData = RequestUtil::get ( "layoutData" );
$gridList = $layoutData ['gridList'];
?>

<!-- custom style -->
<link href="<?=AppUtil::resource_url("global/css/layout.css") ?>" rel="stylesheet" type="text/css" />

<?php
$form = new FormContainer ();
$form->id = "template_add_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart();
?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?= Lang::get('Edit template') ?></span>
        </div>
        <div class="actions btn-set">
            <?php
            $link = new Link ();
            $link->title = Lang::get('Back');
            $link->link = ActionUtil::getFullPathAlias('admin/template/list');
            $link->class = "btn btn-sm grey margin-bottom-5";
            $link->render();

            $button = new Button ();
            $button->title = "<i class='fa fa-plus'></i> " . Lang::get("Save & close");
            $button->attributes = "type='button' onclick='addAndCloseTemplate()'";
            $button->render();

            $button = new Button();
            $button->title = "<i class='fa fa-plus'></i> " . Lang::get("Save");
            $button->attributes = "type='button' onclick='addTemplate()'";
            $button->render();
            ?>
        </div>
    </div>
    <div class="portlet-body">
        <?php
        $text = new Text ();
        $text->name = "templateVo[id]";
        $text->value = $templateVo->id;
        $text->type = "hidden";
        $text->render ();

        $text = new Text ();
        $text->name = "templateVo[headerId]";
        $text->value = $templateVo->headerId;
        $text->type = "hidden";
        $text->render ();

        $text = new Text ();
        $text->name = "templateVo[footerId]";
        $text->value = $templateVo->footerId;
        $text->type = "hidden";
        $text->render ();

        $text = new TextInput ();
        $text->name = "templateVo[name]";
        $text->value = $templateVo->name;
        $text->label = Lang::get("Name");
        $text->required = true;
        $text->render();
        ?>
        <div class="clear margin-top-10"></div>

        <div id="layout_data">
            <?php include "template_edit_form_data.php"?>
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

<!-- add action -->
<script type="text/javascript">
    function addTemplate(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/template/add?rtype=json")?>",
            $("#template_add_form").serialize(),
            function (res){
                location.href = "<?=ActionUtil::getFullPathAlias('admin/template/edit/view')?>" + "?templateId=" + res.extra.templateId;
            },
            simpleAjaxPost_fieldErrorCallBack
        );
    }

    function addAndCloseTemplate(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/template/add?rtype=json")?>",
            $("#template_add_form").serialize(),
            function (res){
                location.href = "<?=ActionUtil::getFullPathAlias('admin/template/list')?>";
            },
            simpleAjaxPost_fieldErrorCallBack
        );
    }
</script>