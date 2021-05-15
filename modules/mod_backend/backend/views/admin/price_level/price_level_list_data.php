<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;

$paging = RequestUtil::get ( "priceLevels" );
$priceLevels = $paging->records;
$filter = RequestUtil::get ( "filter" );
?>
<div class="table-scrollable">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="price_level_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Id');?></th>
				<th><?=Lang::get('Name');?></th>
				<th><?=Lang::get('Discount value (%)');?></th>
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
					$text->type="number";
					$text->name = "filter[value]";
					$text->value = $filter->value;
					$text->placeholder = Lang::get ( "Discount value (%)" );
					$text->attributes .= " min='1' max='99' ";
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"searchPriceLevels()\"";
					$button->render ();
					
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"searchPriceLevels(true)\"";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (empty ( $priceLevels ) || count ( $priceLevels ) == 0) {
				?>
			<tr role="row">
				<td colspan="4"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $priceLevels as $priceLevel ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$priceLevel->id?></td>
				<td><?=$priceLevel->name?></td>
				<td><?=$priceLevel->value?></td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->js = "editPriceLevelDialog('$priceLevel->id')";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->checkActionPath = "admin/price/level/edit/view";
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "copyPriceLevelDialog('$priceLevel->id')";
					$actionBtn->title = Lang::get ( "Clone" );
					$actionBtn->checkActionPath = "admin/price/level/copy/view";
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deletePriceLevelDialog('$priceLevel->id')";
					$actionBtn->title = Lang::get ( "Delete" );
					$actionBtn->checkActionPath = "admin/price/level/del/view";
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
$pagingTemplate->changePageJs = "changePagePriceLevels";
$pagingTemplate->render ();
?>
