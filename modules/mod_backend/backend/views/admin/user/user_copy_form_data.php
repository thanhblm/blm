<?php
use common\template\extend\FormContainer;
use common\template\extend\SelectInput;
use common\template\extend\Text;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\RequestUtil;
use core\template\html\base\BaseSelect;
use core\config\ApplicationConfig;
$listUserGroup = RequestUtil::get('listUserGroup');
$statusList = ApplicationConfig::get("common.status.list");
$userMo = RequestUtil::get ( "userMo" );
$form = new FormContainer ();
$form->id = "formId";
$form->attributes = 'class="form-horizontal"';

$form->renderStart ();
?>
<div class="form-body">
<?php
	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError ( "userMo[userName]" );
	$text->hasError = RequestUtil::isFieldError ( "userMo[userName]" );
	$text->label = Lang::get ( "User Name" );
	$text->required = true;
	$text->name = "userMo[userName]";
	$text->value = $userMo->userName;
	$text->placeholder = Lang::get("UserName...");
	$text->render ();
	
	$text = new TextInput();
	$text->errorMessage = RequestUtil::getFieldError ( "userMo[email]" );
	$text->hasError = RequestUtil::isFieldError ( "userMo[email]" );
	$text->label = Lang::get ( "Email" );
	$text->name = "userMo[email]";
	$text->required = true;
	$text->placeholder = Lang::get("Email...");
	$text->value = $userMo->email;
	$text->class = "form-control";
	$text->render ();
	
	$text = new TextInput();
	$text->errorMessage = RequestUtil::getFieldError ( "userMo[fullName]" );
	$text->hasError = RequestUtil::isFieldError ( "userMo[fullName]" );
	$text->label = Lang::get ( "Full name" );
	$text->name = "userMo[fullName]";
	$text->placeholder = Lang::get("Full Name...");
	$text->value = $userMo->fullName;
	$text->class = "form-control";
	$text->render ();
	
	$text = new TextInput();
	$text->errorMessage = RequestUtil::getFieldError ( "userMo[phone]" );
	$text->hasError = RequestUtil::isFieldError ( "userMo[phone]" );
	$text->label = Lang::get ( "Phone" );
	$text->name = "userMo[phone]";
	$text->placeholder = Lang::get("Phone...");
	$text->value = $userMo->phone;
	$text->class = "form-control";
	$text->render ();
	
	$text = new Text();
	$text->type = "hidden";
	$text->value = $userMo->id;
	$text->name = "userMo[id]";
	$text->render ();
	
	$text = new TextInput();
	$text->type = "password";
	$text->errorMessage = RequestUtil::getFieldError ( "userMo[password]" );
	$text->hasError = RequestUtil::isFieldError ( "userMo[password]" );
	$text->label = Lang::get ( "Password" );
	$text->placeholder = Lang::get('Enter your new password...');
	$text->value = "";
	$text->name = "userMo[password]";
	$text->render ();
	
	$text = new TextInput();
	$text->type = "password";
	$text->errorMessage = RequestUtil::getFieldError ( "cPassword" );
	$text->hasError = RequestUtil::isFieldError ( "cPassword" );
	$text->label = Lang::get ( "Password Confirm" );
	$text->placeholder = Lang::get('Confirmed Password...');
	$text->value = "";
	$text->name = "cPassword";
	$text->render ();
	
	$select = new SelectInput();
	$select->errorMessage = RequestUtil::getFieldError ( "userMo[userGroupId]" );
	$select->hasError = RequestUtil::isFieldError ( "userMo[userGroupId]" );
	$select->label = Lang::get ( "Administrator Groups" );
	$select->required = true;
	$select->collections = $listUserGroup;
	$select->propertyName = "id";
	$select->propertyValue = "name";
	$select->name = "userMo[userGroupId]";
	$select->value = $userMo->userGroupId;
	$select->render ();
	
	$select = new SelectInput ();
	$select->headerKey = "";
	$select->headerValue = Lang::get ( "Select One" );
	$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
	$select->hasError = RequestUtil::isFieldError ( "userMo[status]" );
	$select->required = true;
	$select->name = "userMo[status]";
	$select->label = Lang::get ( "Status" );
	$select->collections = $statusList;
	$select->errorMessage = RequestUtil::getFieldError("userMo[status]");
	$select->value = $userMo->status;
	$select->render();
?>
</div>
<?php $form->renderEnd ();?>