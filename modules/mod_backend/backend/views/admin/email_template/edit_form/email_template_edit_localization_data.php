<?php
use common\template\extend\Text;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$emailTemplateLangs = RequestUtil::get ( "emailTemplateLanguages" )->getArray ();
?>
<div class="row">
	<div class="col-md-3 col-sm-3 col-xs-3">
		<ul class="nav nav-tabs tabs-left">
		<?php
		$isFirst = true;
		foreach ( $emailTemplateLangs as $lang ) {
			?>
			<li <?= $isFirst ? "class=\"active\"" : "" ?>>
				<a href="#<?= $lang->code ?>" data-toggle="tab"> 
					<img src="<?= AppUtil::resource_url("global/img/flags/".strtolower($lang->flag).".png") ?>" />
					<?= Lang::get($lang->name)?>
            	</a>
            </li>
		<?php
			$isFirst = false;
		}
		?>
        </ul>
	</div>
	<div class="col-md-9 col-sm-9 col-xs-9">
		<div class="tab-content">
		<?php
		$isFirst = true;
		$index = 0;
		foreach ( $emailTemplateLangs as $lang ) {
			?>
			<div class="tab-pane fade <?= $isFirst ? "active in" : "" ?>" id="<?= $lang->code ?>">
				<div class="form-body">
				<?php
			$text = new Text ();
			$text->name = "emailTemplateLanguages[" . $index . "][code]";
			$text->value = $lang->code;
			$text->type = "hidden";
			$text->render ();
			
			$text = new Text ();
			$text->name = "emailTemplateLanguages[" . $index . "][name]";
			$text->value = $lang->name;
			$text->type = "hidden";
			$text->render ();
			
			$text = new Text ();
			$text->name = "emailTemplateLanguages[" . $index . "][flag]";
			$text->value = $lang->flag;
			$text->type = "hidden";
			$text->render ();
			
			$text = new Text ();
			$text->name = "emailTemplateLanguages[" . $index . "][emailTemplateId]";
			$text->value = $lang->emailTemplateId;
			$text->type = "hidden";
			$text->render ();
			
			$text = new Text ();
			$text->name = "emailTemplateLanguages[" . $index . "][languageCode]";
			$text->value = $lang->code;
			$text->type = "hidden";
			$text->render ();
			
			$text = new TextInput ( 'text_input_fluid' );
			$text->name = "emailTemplateLanguages[" . $index . "][title]";
			$text->errorMessage = RequestUtil::getFieldError ( "emailTemplateLanguages[" . $index . "][title]" );
			$text->hasError = RequestUtil::isFieldError ( "emailTemplateLanguages[" . $index . "][title]" );
			$text->value = $lang->title;
			$text->label = Lang::get ( "Title" );
			$text->type = "text";
			$text->render ();
			
			$text = new TextInput ( 'text_input_fluid' );
			$text->errorMessage = RequestUtil::getFieldError ( "emailTemplateLanguages[" . $index . "][subject]" );
			$text->hasError = RequestUtil::isFieldError ( "emailTemplateLanguages[" . $index . "][subject]" );
			$text->label = Lang::get ( "Subject" );
			$text->name = "emailTemplateLanguages[" . $index . "][subject]";
			$text->value = $lang->subject;
			$text->render ();
			
			$text = new TextInput ( 'text_input_fluid' );
			$text->errorMessage = RequestUtil::getFieldError ( "emailTemplateLanguages[" . $index . "][from]" );
			$text->hasError = RequestUtil::isFieldError ( "emailTemplateLanguages[" . $index . "][from]" );
			$text->label = Lang::get ( "From" );
			$text->name = "emailTemplateLanguages[" . $index . "][from]";
			$text->value = $lang->from;
			$text->render ();
			
			$text = new TextInput ( 'text_input_fluid' );
			$text->errorMessage = RequestUtil::getFieldError ( "emailTemplateLanguages[" . $index . "][reply]" );
			$text->hasError = RequestUtil::isFieldError ( "emailTemplateLanguages[" . $index . "][reply]" );
			$text->label = Lang::get ( "Reply" );
			$text->name = "emailTemplateLanguages[" . $index . "][reply]";
			$text->value = $lang->reply;
			$text->render ();
			
			$text = new TextInput ( 'text_input_fluid' );
			$text->errorMessage = RequestUtil::getFieldError ( "emailTemplateLanguages[" . $index . "][cc]" );
			$text->hasError = RequestUtil::isFieldError ( "emailTemplateLanguages[" . $index . "][cc]" );
			$text->label = Lang::get ( "CC" );
			$text->name = "emailTemplateLanguages[" . $index . "][cc]";
			$text->value = $lang->cc;
			$text->render ();
			
			$text = new TextInput ( 'text_input_fluid' );
			$text->errorMessage = RequestUtil::getFieldError ( "emailTemplateLanguages[" . $index . "][bcc]" );
			$text->hasError = RequestUtil::isFieldError ( "emailTemplateLanguages[" . $index . "][bcc]" );
			$text->label = Lang::get ( "BCC" );
			$text->name = "emailTemplateLanguages[" . $index . "][bcc]";
			$text->value = $lang->bcc;
			$text->render ();
			
			$text = new TextArea ( 'textarea_fluid' );
			$text->errorMessage = RequestUtil::getFieldError ( "emailTemplateLanguages[" . $index . "][body]" );
			$text->hasError = RequestUtil::isFieldError ( "emailTemplateLanguages[" . $index . "][body]" );
			$text->label = Lang::get ( "Body" );
			$text->value = $lang->body;
			$text->name = "emailTemplateLanguages[" . $index . "][body]";
			$text->class = "ckeditor";
			$text->render ();
			?>
				</div>
			</div>
		<?php
			$isFirst = false;
			$index ++;
		}
		?>
        </div>
	</div>
</div>