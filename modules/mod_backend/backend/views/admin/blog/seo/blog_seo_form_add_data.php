<?php use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\TextInput;
use common\template\extend\TextArea;
use core\utils\AppUtil;

$blogSeos = RequestUtil::get('blogSeos');
$languages = $blogSeos->getArray();
?>

<div class="row">
	<div class="col-md-3 col-sm-3 col-xs-3">
		<ul class="nav nav-tabs tabs-left">
<?php
$i = 1;
if (! empty ( $languages ) && count ( $languages ) > 0) {
	foreach ( $languages as $lang ) {
		?>
		<li class="<?=$i==1?"active":"" ?>"><a href="#seo_<?=$lang->languageCode ?>" data-toggle="tab" aria-expanded="false"><img src="<?= AppUtil::resource_url("global/img/flags/".strtolower($lang->flag).".png") ?>" /> <?=$lang->languageName ?></a></li>
<?php
$i ++;
	}
}
?>
	</ul>
	</div>
	<div class="col-md-9 col-sm-9 col-xs-9">
		<div class="tab-content">
			<?php
			$i = 0;
			if (! empty ( $languages ) && count ( $languages ) > 0) {
				foreach ( $languages as $lang ) {
					?>
				<div class="tab-pane fade <?=$i==0?"active in":""?>" id="seo_<?=$lang->languageCode ?>" data-repeater-item>
						<div class="form-body">
							<input type="hidden" name="blogSeos[<?=$i?>][flag]" value="<?=$lang->flag?>">
							<input type="hidden" name="blogSeos[<?=$i?>][languageName]" value="<?=$lang->languageName?>">
							<input type="hidden" name="blogSeos[<?=$i?>][languageCode]" value="<?=$lang->languageCode?>">
							<input type="hidden" name="blogSeos[<?=$i?>][itemId]" value="<?=$lang->itemId?>">
						<?php
						$text = new TextInput ("text_input_fluid");
						$text->label = Lang::get ( "Url" );
						$text->name = "blogSeos[$i][url]";
						$text->value = $lang->url;
						$text->render ();
						
						$text = new TextInput ("text_input_fluid");
						$text->label = Lang::get ( "Title" );
						$text->name = "blogSeos[$i][title]";
						$text->value = $lang->title;
						$text->render ();
						
						$text = new TextInput ("text_input_fluid");
						$text->label = Lang::get ( 'Keyword' );
						$text->name = "blogSeos[$i][keywords]";
						$text->value = $lang->keywords;
						$text->render ();
							
						$textArea = new TextArea ("textarea_fluid");
						$textArea->label = Lang::get ( 'Description' );
						$textArea->name = "blogSeos[$i][description]";
						$textArea->value = $lang->description;
						$textArea->class = "ckeditor";
						$textArea->render ();
					?>
					</div>
					</div>
				<?php
				$i ++;
				}
			}
			?>
		</div>
	</div>
</div>