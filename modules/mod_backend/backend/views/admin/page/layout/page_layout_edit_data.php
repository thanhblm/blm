<?php
use common\template\extend\SelectInput;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

// get data
$pageVo = RequestUtil::get ( "pageVo" );
$viewPath = RequestUtil::get ( "viewPath" );
$containerVo = RequestUtil::get ( 'containerVo' );
$templateList = RequestUtil::get ( 'templateList' );
?>
<link href="<?=\core\utils\AppUtil::resource_url("global/css/layout.css") ?>" rel="stylesheet" type="text/css" />
<link href="<?=\core\utils\AppUtil::resource_url("global/scripts/jquery.nestable/jquery.nestable.css") ?>" rel="stylesheet" type="text/css" />
<div class="layout_content">
    <?php
	$urlEditTemplate = ActionUtil::getFullPathAlias ( "admin/template/edit/view?templateId={$pageVo->templateId}" );
	$select = new SelectInput ();
	$select->value = $pageVo->templateId;
	$select->name = "pageVo[templateId]";
	$select->collections = $templateList;
	$select->collectionType = SelectInput::CT_SINGLE_ARRAY_OBJECT;
	$select->propertyName = "id";
	$select->propertyValue = "name";
	$select->label = Lang::get ( "Select a template" );
	$select->append = "<a href='$urlEditTemplate' target='_blank' class='urlEditTemplate'>" . Lang::get ( 'Edit template' ) . "</a>";
	$select->render ();

//    $text = new TextInput();
//    $text->label = Lang::get ( "Action" );
//    $text->name = "pageVo[action]";
//    $text->value = $pageVo->action;
//    $text->render ();
	?>
    <div class="clear margin-bottom-20"></div>

    <?php if($pageVo->isSystem){?>
    <div class="layout-data">
		<div class="layout_content">
			<div class="layout_container">
				<div class="grid-control-menu container-control-menu bm-control-menu">
					<h4 class="grid-control-title">
                        <?=Lang::get('Main content')?>
                    </h4>
				</div>
				<div class="container-main-content">
                    <?=Lang::get('The main content of the website.')?>
                </div>
			</div>
		</div>
	</div>
    <?php }?>

    <!-- insert container edit -->
	<div id="page-container-content"></div>
	<script type="text/javascript">
        $("#page-container-content").load("<?=ActionUtil::getFullPathAlias("admin/container/edit/view/data?containerId={$containerVo->id}")?>");
    </script>

</div>

<script type="text/javascript">
    $('#id_pageVo_templateId').change(function(){
        var templateId = $(this).val();
        var href = "<?php echo ActionUtil::getFullPathAlias("admin/template/edit/view?templateId=");?>"+templateId;
        $('.urlEditTemplate').attr('href', href);
    });
</script>