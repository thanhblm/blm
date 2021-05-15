<?php use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\TextInput;
use common\template\extend\TextArea;
use core\utils\AppUtil;

$productLangs = RequestUtil::get('productLangs');
$languages = $productLangs->getArray();
?>

<div class="row">
	<div class="col-md-3 col-sm-3 col-xs-3">
		<ul class="nav nav-tabs tabs-left">
<?php
$i = 1;
if (! empty ( $languages ) && count ( $languages ) > 0) {
	foreach ( $languages as $lang ) {
		?>
		<li class="<?=$i==1?"active":"" ?>"><a href="#<?=strtolower($lang->languageCode) ?>" data-toggle="tab" aria-expanded="false"><img src="<?= AppUtil::resource_url("global/img/flags/".strtolower($lang->flag).".png") ?>" /> <?=$lang->languageName ?></a></li>
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
				<div class="tab-pane fade <?=$i==0?"active in":""?>" id="<?=$lang->languageCode ?>" data-repeater-item>
						<div class="form-body">
							<input type="hidden" name="productLangs[<?=$i?>][languageName]" value="<?=$lang->languageName?>">
							<input type="hidden" name="productLangs[<?=$i?>][flag]" value="<?=$lang->flag?>">
							<input type="hidden" name="productLangs[<?=$i?>][languageCode]" value="<?=$lang->languageCode?>">
							<input type="hidden" name="productLangs[<?=$i?>][productId]" value="<?=$lang->productId?>">
						<?php
					$text = new TextInput ("text_input_fluid");
					$text->label = Lang::get ( "Name" );
					$text->name = "productLangs[$i][name]";
					$text->value = $lang->name;
					$text->render ();
					
					$textArea = new TextArea ("textarea_fluid");
					$textArea->label = Lang::get ( 'Composition' );
					$textArea->name = "productLangs[$i][composition]";
					$textArea->value = $lang->composition;
					$textArea->class = "ckeditor";
					$textArea->render ();
					
					$textArea = new TextArea ("textarea_fluid");
					$textArea->label = Lang::get ( 'Description' );
					$textArea->name = "productLangs[$i][description]";
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