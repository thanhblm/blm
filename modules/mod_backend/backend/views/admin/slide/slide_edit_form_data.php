<?php

use common\template\extend\FormContainer;
use common\template\extend\ImageInput;
use common\template\extend\SelectInput;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\config\ApplicationConfig;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\RequestUtil;

$listSlideGroup = RequestUtil::get('listSlideGroup');
$slideMo = RequestUtil::get("slideMo");
$form = new FormContainer ();
$statusList = ApplicationConfig::get("common.status.list");
$form->id = "formId";
$form->attributes = 'class="form-horizontal"';

$form->renderStart();
?>
<div class="form-body">
	<?php

	$text = new TextInput ();
	$text->type = "hidden";
	$text->value = $slideMo->id;
	$text->name = "slideMo[id]";
	$text->render();

	$select = new SelectInput();
	$select->headerKey = "";
	$select->headerValue = Lang::get("Select One");
	$select->hasError = RequestUtil::isFieldError("slideMo[slideGroupId]");
	$select->errorMessage = RequestUtil::getFieldError("slideMo[slideGroupId]");
	$select->required = true;
	$select->collectionType = BaseSelect::CT_SINGLE_ARRAY_OBJECT;
	$select->collections = $listSlideGroup;
	$select->propertyValue = "name";
	$select->propertyName = "id";
	$select->name = "slideMo[slideGroupId]";
	$select->label = Lang::get("Slide Group");
	$select->class = "form-control";
	$select->value = $slideMo->slideGroupId;
	$select->render();

	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError("slideMo[title]");
	$text->hasError = RequestUtil::isFieldError("slideMo[title]");
	$text->label = Lang::get("Title");
	$text->required = true;
	$text->value = $slideMo->title;
	$text->name = "slideMo[title]";
	$text->render();

	$text = new TextInput ();
	$text->errorMessage = RequestUtil::getFieldError("slideMo[url]");
	$text->hasError = RequestUtil::isFieldError("slideMo[url]");
	$text->label = Lang::get("URL");
	$text->value = $slideMo->url;
	$text->name = "slideMo[url]";
	$text->render();

	$image = new ImageInput();
	$image->name = "slideMo[image]";
	$image->label = Lang::get("Image");
	$image->hasImgAction = true;
	$image->id = "slide";
	$image->required = true;
	$image->profileId = 'slide';
	$image->value = $slideMo->image;
	$image->render();

	$text = new TextArea();
	$text->errorMessage = RequestUtil::getFieldError("slideMo[description]");
	$text->hasError = RequestUtil::isFieldError("slideMo[description]");
	$text->label = Lang::get("Description");
	$text->name = "slideMo[description]";
	$text->class = "form-control";
	$text->value = $slideMo->description;
	$text->class = "ckeditor";
	$text->render();


	$select = new SelectInput();
	$select->headerKey = "";
	$select->headerValue = Lang::get("Select One");
	$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
	$select->hasError = RequestUtil::isFieldError("slideMo[status]");
	$select->required = true;
	$select->name = "slideMo[status]";
	$select->label = Lang::get("Status");
	$select->collections = $statusList;
	$select->class = "form-control";
	$select->errorMessage = RequestUtil::getFieldError("slideMo[status]");
	$select->value = $slideMo->status;
	$select->render();

	?>
	<?php $form->renderEnd(); ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("textarea.ckeditor").ckeditor();
    });
</script>

