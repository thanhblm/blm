<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Text;
use core\Lang;
use core\utils\DateTimeUtil;
use core\utils\RequestUtil;
use common\template\extend\Select;
$paging = RequestUtil::get ( "languageValues" );
$languageValues = $paging->records;
$filter = RequestUtil::get ( "filter" );
?>
<div class="table-scrollable">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="language_value_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Language code');?></th>
				<th><?=Lang::get('Original');?></th>
				<th><?=Lang::get('Translation');?></th>
				<th><?=Lang::get('Actions');?></th>
			</tr>
		</thead>
		<tbody>
			<tr role="row" class="filter">
				<td>
					<?php
					$select = new Select ();
					$select->value = $filter->languageCode;
					$select->name = "filter[languageCode]";
					$select->headerKey = "";
					$select->headerValue = Lang::get ( "All" );
					$select->collections = RequestUtil::get ( "languages" );
					$select->collectionType = Select::CT_SINGLE_ARRAY_OBJECT;
					$select->propertyName = "code";
					$select->propertyValue = "code";
					$select->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[original]";
					$text->value = $filter->original;
					$text->placeholder = Lang::get ( "Original" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[destination]";
					$text->value = $filter->destination;
					$text->placeholder = Lang::get ( "Translation" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"searchLanguageValues()\"";
					$button->render ();
					
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"searchLanguageValues(true)\"";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (empty ( $languageValues ) || count ( $languageValues ) == 0) {
				?>
			<tr role="row">
				<td colspan="4"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $languageValues as $languageValue ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$languageValue->languageCode?></td>
				<td><?=$languageValue->original?></td>
				<td><?=$languageValue->destination?></td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->checkActionPath = 'admin/language/value/edit/view';
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "editLanguageValueDialog($languageValue->id)";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->render ();
					?>
				</td>
			</tr>
			<?php
				}
			}
			?>
		</tbody>
	</table>
</div>
<?php
$pagingTemplate = new PagingTemplate ();
$pagingTemplate->paging = $paging;
$pagingTemplate->changePageJs = "changePageLanguageValues";
$pagingTemplate->render ();
?>
<script type="text/javascript">
	$('.date-picker').datepicker({
			format: '<?=DateTimeUtil::getDatePickerFormat()?>',
	});
</script>