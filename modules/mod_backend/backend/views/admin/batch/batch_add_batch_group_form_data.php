<?php
use common\template\extend\SelectInput;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
$listBatchGroup = RequestUtil::get ( 'listBatchGroup' );
$batchMo = RequestUtil::get ( "batchMo" );

$select = new SelectInput ();
$select->errorMessage = RequestUtil::getFieldError ( "batchMo[batchGroupId]" );
$select->hasError = RequestUtil::isFieldError ( "batchMo[batchGroupId]" );
$select->label = Lang::get ( "Batch Group" );
$select->required = true;
$select->collections = $listBatchGroup;
$select->propertyName = "id";
$select->propertyValue = "name";
$select->name = "batchMo[batchGroupId]";
$select->value = $batchMo->batchGroupId;
if (count ( $listBatchGroup ) < 1) {
	$select->headerKey = "";
	$select->headerValue = "Please create Batch Group First";
	$select->attributes = " disabled ";
	
	$batchGroupMo = RequestUtil::get ( 'batchGroupMo' );
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "batchGroupMo[name]" );
	$text->hasError = RequestUtil::isFieldError ( "batchGroupMo[name]" );
	$text->label = Lang::get ( "Add A Batch Group" );
	$text->name = "batchGroupMo[name]";
	$text->id = "batchGroupNameId";
	$text->required = true;
	$text->placeholder = Lang::get ( "Batch Group Name..." );
	$text->value = $batchGroupMo->name;
	$text->render ();
	?>
<button type="button" onclick="addBatchGroup();" class="btn btn-sm btn-success margin-bottom-5" style="position: absolute; margin-top: -24px;"> <?=Lang::get("Add Batch Group") ?>  </button>
<?php
}
$select->render ();

?>
