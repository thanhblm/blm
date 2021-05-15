<?php
use common\template\extend\SelectInput;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
$listSlideGroup = RequestUtil::get ( 'listSlideGroup' );
$slideMo = RequestUtil::get ( "slideMo" );

$select = new SelectInput ();
$select->errorMessage = RequestUtil::getFieldError ( "slideMo[slideGroupId]" );
$select->hasError = RequestUtil::isFieldError ( "slideMo[slideGroupId]" );
$select->label = Lang::get ( "Slide Group" );
$select->required = true;
$select->collections = $listSlideGroup;
$select->propertyName = "id";
$select->propertyValue = "name";
$select->name = "slideMo[slideGroupId]";
$select->value = $slideMo->slideGroupId;
if (count ( $listSlideGroup ) < 1) {
	$select->headerKey = "";
	$select->headerValue = "Please create Slide Group First";
	$select->attributes = " disabled ";
	
	$slideGroupMo = RequestUtil::get ( 'slideGroupMo' );
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "slideGroupMo[name]" );
	$text->hasError = RequestUtil::isFieldError ( "slideGroupMo[name]" );
	$text->label = Lang::get ( "Add A Slide Group" );
	$text->name = "slideGroupMo[name]";
	$text->id = "slideGroupNameId";
	$text->required = true;
	$text->placeholder = Lang::get ( "Slide Group Name..." );
	$text->value = $slideGroupMo->name;
	$text->render ();
	?>
<button type="button" onclick="addSlideGroup();" class="btn btn-sm btn-success margin-bottom-5" style="position: absolute; margin-top: -24px;"> <?=Lang::get("Add Slide Group") ?>  </button>
<?php
}
$select->render ();

?>
