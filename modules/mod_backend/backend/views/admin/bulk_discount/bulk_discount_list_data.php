<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Select;
use common\template\extend\Text;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\DateTimeUtil;
use core\utils\RequestUtil;

$paging = RequestUtil::get ( "bulkDiscounts" );
$bulkDiscounts = $paging->records;
$filter = RequestUtil::get ( "filter" );
?>
<div class="table-scrollable">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="bulk_discount_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Id');?></th>
				<th><?=Lang::get('Name');?></th>
				<th><?=Lang::get('Discount Value (%)');?></th>
				<th><?=Lang::get('Status');?></th>
				<th><?=Lang::get('Actions');?></th>
			</tr>
		</thead>
		<tbody>
			<tr role="row" class="filter">
				<td>&nbsp;</td>
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
					$text->name = "filter[discount]";
					$text->value = $filter->discount;
					$text->placeholder = Lang::get ( "Discount value" );
					$text->type = "number";
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
					$button->attributes = "onclick=\"searchBulkDiscounts()\"";
					$button->render ();
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"searchBulkDiscounts(true)\"";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (empty ( $bulkDiscounts ) || count ( $bulkDiscounts ) == 0) {
				?>
			<tr role="row">
				<td colspan="7"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $bulkDiscounts as $bulkDiscount ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$bulkDiscount->id?></td>
				<td><?=$bulkDiscount->name?></td>
				<td><?=$bulkDiscount->discount?></td>
				<td><?=$bulkDiscount->status?></td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->js = "editBulkDiscountDialog('$bulkDiscount->id')";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->checkActionPath = "admin/discount/bulk/edit/view";
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->js = "copyBulkDiscountDialog('$bulkDiscount->id')";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->title = Lang::get ( "Clone" );
					$actionBtn->checkActionPath = "admin/discount/bulk/copy/view";
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deleteBulkDiscountDialog('$bulkDiscount->id')";
					$actionBtn->title = Lang::get ( "Delete" );
					$actionBtn->checkActionPath = "admin/discount/bulk/del/view";
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
$pagingTemplate->changePageJs = "changePageBulkDiscounts";
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