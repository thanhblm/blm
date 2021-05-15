<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Select;
use common\template\extend\Text;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\AppUtil;
use core\utils\DateTimeUtil;
use core\utils\RequestUtil;
$paging = RequestUtil::get ( "languages" );
$languages = $paging->records;
$filter = RequestUtil::get ( "filter" );
?>
<div class="table-scrollable">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="language_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Code');?></th>
				<th><?=Lang::get('Name');?></th>
				<th><?=Lang::get('Locale Name');?></th>
				<th><?=Lang::get('Status');?></th>
				<th><?=Lang::get('Flag');?></th>
				<th width="15%"><?=Lang::get('Actions');?></th>
			</tr>
		</thead>
		<tbody>
			<tr role="row" class="filter">
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[code]";
					$text->value = $filter->code;
					$text->placeholder = Lang::get ( "Code" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[name]";
					$text->value = $filter->name;
					$text->placeholder = Lang::get ( "Name" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[localeName]";
					$text->value = $filter->localeName;
					$text->placeholder = Lang::get ( "Locale Name" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$select = new Select ();
					$select->value = $filter->status;
					$select->name = "filter[status]";
					$select->headerKey = "";
					$select->headerValue = Lang::get ( "All" );
					$select->collections = ApplicationConfig::get ( "common.status.list" );
					$select->collectionType = Select::CT_MULTI_ARRAY_VALUE;
					$select->render ();
					?>
				</td>
				<td>&nbsp;</td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"searchLanguages()\"";
					$button->render ();
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"searchLanguages(true)\"";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (empty ( $languages ) || count ( $languages ) == 0) {
				?>
			<tr role="row">
				<td colspan="5"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $languages as $language ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$language->code?></td>
				<td><?=$language->name?></td>
				<td><?=$language->localeName?></td>
				<td><?=$language->status?></td>
				<td><img src="<?=AppUtil::resource_url("global/img/flags/".strtolower($language->flag).".png")?>" /></td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->checkActionPath = "admin/language/edit/view";
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "editLanguageDialog('$language->code')";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->checkActionPath = "admin/language/copy/view";
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "copyLanguageDialog('$language->code')";
					$actionBtn->title = Lang::get ( "Clone" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->checkActionPath = "admin/language/del/view";
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deleteLanguageDialog('$language->code')";
					$actionBtn->title = Lang::get ( "Delete" );
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
$pagingTemplate->changePageJs = "changePageLanguages";
$pagingTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.date-picker').datepicker({
 			format: '<?=DateTimeUtil::getDatePickerFormat()?>',
		});
	});
</script>