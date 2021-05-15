<?php
use common\template\extend\Text;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;

$pageVo = RequestUtil::get ( "pageVo" );
?>
<div class="form-body">
	<?php
	$text = new Text ();
	$text->name = "pageVo[id]";
	$text->value = $pageVo->id;
	$text->type = "hidden";
	$text->render ();
	
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "pageVo[name]" );
	$text->hasError = RequestUtil::isFieldError ( "pageVo[name]" );
	$text->required = true;
	$text->label = Lang::get ( "Name" );
	$text->name = "pageVo[name]";
	$text->value = $pageVo->name;
	$text->render ();
	
	$text = new TextArea ();
	$text->errorMessage = RequestUtil::getFieldError ( "pageVo[description]" );
	$text->hasError = RequestUtil::isFieldError ( "pageVo[description]" );
	$text->label = Lang::get ( "Description" );
	$text->name = "pageVo[description]";
	$text->value = $pageVo->description;
	$text->class = "ckeditor";
	$text->render ();
	?>
</div>