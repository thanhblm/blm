<?php
use core\utils\RequestUtil;
use core\Lang;
use core\utils\ActionUtil;
use common\template\extend\ModalTemplate;
use core\config\ApplicationConfig;
use common\template\extend\Text;
use common\template\extend\Button;
use common\template\extend\Link;
use common\template\extend\TextInput;
use common\template\extend\FormContainer;
use common\template\extend\SelectInput;

// get data
$containerVo = RequestUtil::get ( "containerVo" );
?>

<?php
$form = new FormContainer ();
$form->id = "container_edit_form";
$form->attributes = 'class="form-horizontal"';
$form->renderStart();
?>

<div class="portlet light">
    <div class="portlet-title">
        <div class="caption font-dark">
            <span class="caption-subject bold uppercase"><?= Lang::get('Edit container') ?></span>
        </div>
        <div class="actions btn-set">
            <?php
            $link = new Link ();
            $link->title = Lang::get('Back');
            $link->link = ActionUtil::getFullPathAlias('admin/container/list');
            $link->class = "btn btn-sm grey margin-bottom-5";
            $link->render();

            $button = new Button ();
            $button->title = "<i class='fa fa-plus'></i> " . Lang::get("Save & close");
            $button->attributes = "type='button' onclick='editAndCloseContainer()'";
            $button->render();

            $button = new Button();
            $button->title = "<i class='fa fa-plus'></i> " . Lang::get("Save");
            $button->attributes = "type='button' onclick='editContainer()'";
            $button->render();
            ?>
        </div>
    </div>
    <div class="portlet-body">
        <?php
        $text = new Text ();
        $text->name = "containerVo[id]";
        $text->value = $containerVo->id;
        $text->type = "hidden";
        $text->render ();

        $text = new TextInput ();
        $text->name = "containerVo[name]";
        $text->value = $containerVo->name;
        $text->label = Lang::get("Name");
        $text->render();

        $select = new SelectInput ();
        $select->value = $containerVo->position;
        $select->name = "containerVo[position]";
        $select->collections = ApplicationConfig::get("layout.container.position.list");
        $select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
        $select->label = Lang::get("Position");
        $select->render();

        $text = new TextInput ();
        $text->name = "containerVo[class]";
        $text->value = $containerVo->class;
        $text->label = Lang::get("Class");
        $text->render();
        ?>
        <div class="clear margin-bottom-20"></div>
        
        <div id="layout-data">
            <?php include "container_edit_form_data.php"?>
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
    function editContainer(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/container/edit?rtype=json")?>",
            $("#container_edit_form").serialize(),
            function (res){
                var message = '<?php echo Lang::get('The container is update successfully')?>';
                showMessage(message, 'success', true);
                resetValidate();
            },
            simpleAjaxPost_fieldErrorCallBack
        );
    }

    function editAndCloseContainer(){
        simpleAjaxPost(
            guid(),
            "<?=ActionUtil::getFullPathAlias("admin/container/edit?rtype=json")?>",
            $("#container_edit_form").serialize(),
            function (res){
                location.href = "<?=ActionUtil::getFullPathAlias('admin/container/list')?>";
            },
            simpleAjaxPost_fieldErrorCallBack
        );
    }
</script>