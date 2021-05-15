<?php
use common\template\extend\Text;
use common\template\extend\TextArea;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$categoryLangs = RequestUtil::get ( "categoryBlogLanguages" )->getArray ();
?>
<div class="row">
	<div class="col-md-3 col-sm-3 col-xs-3">
		<ul class="nav nav-tabs tabs-left">
		<?php
		$isFirst = true;
		foreach ( $categoryLangs as $lang ) {
			?>
			<li <?= $isFirst ? "class=\"active\"" : "" ?>><a href="#localization_<?= $lang->code ?>" data-toggle="tab"> <img src="<?= AppUtil::resource_url("global/img/flags/".strtolower($lang->flag).".png") ?>" /> <?= Lang::get($lang->languageName)?>
                    </a></li>
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
		foreach ( $categoryLangs as $lang ) {
			?>
			<div class="tab-pane fade <?= $isFirst ? "active in" : "" ?>" id="localization_<?= $lang->code ?>">
				<div class="form-body">
				<?php
			$text = new Text ();
			$text->name = "categoryBlogLanguages[" . $index . "][code]";
			$text->value = $lang->code;
			$text->type = "hidden";
			$text->render ();
			
			$text = new Text ();
			$text->name = "categoryBlogLanguages[" . $index . "][languageName]";
			$text->value = $lang->languageName;
			$text->type = "hidden";
			$text->render ();
			
			$text = new Text ();
			$text->name = "categoryBlogLanguages[" . $index . "][flag]";
			$text->value = $lang->flag;
			$text->type = "hidden";
			$text->render ();
			
			$text = new Text ();
			$text->name = "categoryBlogLanguages[" . $index . "][categoryId]";
			$text->value = $lang->categoryId;
			$text->type = "hidden";
			$text->render ();
				
			$text = new Text ();
			$text->name = "categoryBlogLanguages[" . $index . "][languageCode]";
			$text->value = $lang->languageCode;
			$text->type = "hidden";
			$text->render ();
			
			$text = new TextInput ( 'text_input_fluid' );
			$text->name = "categoryBlogLanguages[" . $index . "][name]";
			$text->errorMessage = RequestUtil::getFieldError ( "categoryBlogLanguages[" . $index . "][name]" );
			$text->hasError = RequestUtil::isFieldError ( "categoryBlogLanguages[" . $index . "][name]" );
			$text->value = $lang->name;
			$text->label = Lang::get ( "Name" );
			$text->type = "text";
			$text->render ();
			
			$text = new TextArea ( 'textarea_fluid' );
			$text->errorMessage = RequestUtil::getFieldError ( "categoryBlogLanguages[" . $index . "][description]" );
			$text->hasError = RequestUtil::isFieldError ( "categoryBlogLanguages[" . $index . "][description]" );
			$text->label = Lang::get ( "Description" );
			$text->name = "categoryBlogLanguages[" . $index . "][description]";
			$text->value = $lang->description;
			$text->class = "";
			$text->render ();
			
			$text = new TextArea ( 'textarea_fluid' );
			$text->errorMessage = RequestUtil::getFieldError ( "categoryBlogLanguages[" . $index . "][introduction]" );
			$text->hasError = RequestUtil::isFieldError ( "categoryBlogLanguages[" . $index . "][introduction]" );
			$text->label = Lang::get ( "Introduction" );
			$text->name = "categoryBlogLanguages[" . $index . "][introduction]";
			$text->value = $lang->introduction;
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
