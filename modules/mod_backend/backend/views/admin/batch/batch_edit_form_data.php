<?php
use common\template\extend\FormContainer;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use core\config\ApplicationConfig;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\RequestUtil;
$listBatchGroup = RequestUtil::get ( 'listBatchGroup' );
$statusList = ApplicationConfig::get ( "common.status.list" );
$batchMo = RequestUtil::get ( "batchMo" );
$form = new FormContainer ();
$form->id = "formId";
$form->attributes = 'class="form-horizontal"';

$form->renderStart ();
?>
<div class="form-body">
<?php

$text = new Text ();
$text->name = "batchMo[id]";
$text->value = $batchMo->id;
$text->type = "hidden";
$text->render ();

$select = new SelectInput ( "select_dialog" );
$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
$select->hasError = RequestUtil::isFieldError ( "batchMo[status]" );
$select->required = true;
$select->name = "batchMo[status]";
$select->label = Lang::get ( "Status" );
$select->collections = $statusList;
$select->errorMessage = RequestUtil::getFieldError("batchMo[status]");
$select->value = $batchMo->status;
$select->render();
?>
</div>
<?php $form->renderEnd ();?>