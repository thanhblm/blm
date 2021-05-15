<?php
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\Text;
use common\template\extend\Button;
use common\template\extend\PagingTemplate;
use common\template\extend\ButtonAction;
use core\utils\DateTimeUtil;
use common\template\extend\Select;
use core\config\ApplicationConfig;
$paging = RequestUtil::get ( "currencies" );
$currencies = $paging->records;
$filter = RequestUtil::get ( "filter" );
?>
<div class="table-scrollable">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="currency_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Code');?></th>
				<th><?=Lang::get('Name');?></th>
				<th><?=Lang::get('Symbol');?></th>
				<th><?=Lang::get('Placement');?></th>
				<th><?=Lang::get('Decimal');?></th>
				<th><?=Lang::get('Status');?></th>
				<th><?=Lang::get('Actions');?></th>
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
				<td>&nbsp;</td>
				<td>
					<?php
					$select = new Select ();
					$select->value = $filter->placement;
					$select->name = "filter[placement]";
					$select->headerKey = "";
					$select->headerValue = Lang::get ( "All" );
					$select->collections = ApplicationConfig::get ( "currency.placement.list" );
					$select->collectionType = Select::CT_MULTI_ARRAY_VALUE;
					$select->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->type = "number";
					$text->name = "filter[decimal]";
					$text->value = $filter->decimal;
					$text->placeholder = Lang::get ( "Decimal" );
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
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"searchCurrencies()\"";
					$button->render ();
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"searchCurrencies(true)\"";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (empty ( $currencies ) || count ( $currencies ) == 0) {
				?>
			<tr role="row">
				<td colspan="7"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $currencies as $currency ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$currency->code?></td>
				<td><?=$currency->name?></td>
				<td><?=$currency->symbol?></td>
				<td><?=$currency->placement?></td>
				<td><?=$currency->decimal?></td>
				<td><?=$currency->status?></td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "editCurrencyDialog('$currency->code')";
					$actionBtn->checkActionPath = "admin/currency/edit/view";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "copyCurrencyDialog('$currency->code')";
					$actionBtn->checkActionPath = "admin/currency/copy/view";
					$actionBtn->title = Lang::get ( "Clone" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deleteCurrencyDialog('$currency->code')";
					$actionBtn->checkActionPath = "admin/currency/del/view";
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
$pagingTemplate->changePageJs = "changePageCurrencies";
$pagingTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.date-picker').datepicker({
 			format: '<?=DateTimeUtil::getDatePickerFormat()?>',
		});
		$("input.numberic-float").autoNumeric('init');
	});
</script>