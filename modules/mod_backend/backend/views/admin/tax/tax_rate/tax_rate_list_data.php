<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Text;
use core\Lang;
use core\utils\AppUtil;
use core\utils\DateTimeUtil;
use core\utils\RequestUtil;

$paging = RequestUtil::get ( "taxRateList" );
$filter = RequestUtil::get ( "filter" );
?>
<div class="table-scrollable">
	<?php
	$text = new Text ();
	$text->type = 'hidden';
	$text->value = AppUtil::defaultIfEmpty ( RequestUtil::get ( "page" ), 1 );
	$text->name = "page";
	$text->id = "page";
	$text->render ();
	?>
	<table class="tbl_sort_data table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="page_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Id');?></th>
				<th><?=Lang::get("Name");?></th>
				<th><?=Lang::get('Actions');?></th>
			</tr>
		</thead>
		<tbody>
			<tr role="row" class="filter">
				<td>
					<?php
					$text = new Text ();
					$text->placeholder = Lang::get ( "Id" );
					$text->class = "form-control form-filter input-sm";
					$text->name = "filter[id]";
					$text->type = "number";
					$text->value = $filter->id;
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->placeholder = Lang::get ( "Name" );
					$text->class = "form-control form-filter input-sm";
					$text->name = "filter[name]";
					$text->value = $filter->name;
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"sortTaxRate()\"";
					$button->render ();
					
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"resetForm()\"";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (empty ( $paging->records ) || count ( $paging->records ) == 0) {
				?>
			<tr role="row">
				<td colspan="3"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $paging->records as $vo ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$vo->id?></td>
				<td><?=Lang::get($vo->name)?></td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->checkActionPath = "admin/tax/rate/edit/view";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "editTaxRateDialog($vo->id)";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->render ();
					
					/* $actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "copyTaxRateDialog($vo->id)";
					$actionBtn->title = Lang::get ( "Clone" );
					$actionBtn->render (); */
					
					/* $actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deleteTaxRateDialog($vo->id)";
					$actionBtn->title = Lang::get ( "Delete" );
					$actionBtn->render (); */
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
$pagingTemplate->changePageJs = "onPageChange";
$pagingTemplate->render ();
?>
<script type="text/javascript">
	$(document).ready(function(){
	    $('.date-picker').datepicker({
			format: '<?=DateTimeUtil::getDatePickerFormat()?>',
	});
	});
</script>