<?php
use core\utils\RequestUtil;
use core\Lang;
use core\utils\ActionUtil;
use common\template\extend\ModalTemplate;
use common\template\extend\Text;
use common\template\extend\Button;
use common\template\extend\Link;
use common\template\extend\TextInput;
use common\template\extend\FormContainer;

// get data
$templateVo = RequestUtil::get ( "templateVo" );
?>

<?php
$form = new FormContainer ();
$form->id = "template_edit_form";
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
            $button->attributes = "type='button' onclick='editAndCloseTemplate()'";
            $button->render();

            $button = new Button();
            $button->title = "<i class='fa fa-plus'></i> " . Lang::get("Save");
            $button->attributes = "type='button' onclick='editTemplate()'";
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
        <div class="clear margin-bottom-20"></div>
        
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

<!-- edit action -->
<script type="text/javascript">
    function editTemplate(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/template/edit?rtype=json")?>",
            $("#template_edit_form").serialize(),
            function (res){
                var message = '<?php echo Lang::get('The template is update successfully')?>';
                showMessage(message, 'success', true);
                resetValidate();
            },
            simpleAjaxPost_fieldErrorCallBack
        );
    }

    function editAndCloseTemplate(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/template/edit?rtype=json")?>",
            $("#template_edit_form").serialize(),
            function (res){
                location.href = "<?=ActionUtil::getFullPathAlias('admin/template/list')?>";
            },
            simpleAjaxPost_fieldErrorCallBack
        );
    }
</script>