<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;

$paging = RequestUtil::get ( "taxShippingZones" );
$taxShippingZones = $paging->records;
$filter = RequestUtil::get ( "filter" );
?>
<div class="table-scrollable">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<table class="tbl_sort_data table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="page_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Id');?></th>
				<th><?=Lang::get('Name');?></th>
				<th><?=Lang::get('Include / Exclude');?></th>
				<th><?=Lang::get('Actions');?></th>
			</tr>
		</thead>
		<tbody>
			<tr role="row" class="filter">
				<td></td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[name]";
					$text->value = $filter->name;
					$text->placeholder = Lang::get ( "Name" );
					$text->render ();
					?>
				</td>
				<td></td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"searchTaxShippingZones()\"";
					$button->render ();
					
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"searchTaxShippingZones(true)\"";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (empty ( $taxShippingZones ) || count ( $taxShippingZones ) == 0) {
				?>
			<tr role="row">
				<td colspan="8"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $taxShippingZones as $taxShippingZone ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$taxShippingZone->id?></td>
				<td><?=$taxShippingZone->name?></td>
				<td><?=$taxShippingZone->exclusive?></td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "editTaxShippingZoneDialog('$taxShippingZone->id')";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->checkActionPath = "admin/tax/shipping/zone/edit/view";
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "copyTaxShippingZoneDialog('$taxShippingZone->id')";
					$actionBtn->title = Lang::get ( "Clone" );
					$actionBtn->checkActionPath = "admin/tax/shipping/zone/copy/view";
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deleteTaxShippingZoneDialog('$taxShippingZone->id')";
					$actionBtn->title = Lang::get ( "Delete" );
					$actionBtn->checkActionPath = "admin/tax/shipping/zone/del/view";
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
$pagingTemplate->changePageJs = "changePageTaxShippingZone";
$pagingTemplate->render ();
?>
