<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\AppUtil;
$filter = RequestUtil::get ( "filter" );
$paging = RequestUtil::get ( "addressList" );
?>

<div class="table-scrollable" style="margin:0 0 !important;">
<?php
$text = new Text ();
$text->type = 'hidden';
$text->value = AppUtil::defaultIfEmpty ( RequestUtil::get ( "page" ), 1 );
$text->name = "page";
$text->id = "page";
$text->render ();
?>
	<table class="table table-bordered table-striped table-condensed flip-content tbl_sort_data dataTable " id="page_table_address">
		<thead class="flip-content">
			<tr role="row">
				<th><?=Lang::get('ID');?></th>
				<th><?=Lang::get('First Name');?></th>
				<th><?=Lang::get('Last Name');?></th>
				<th><?=Lang::get('Actions');?></th>
			</tr>
		</thead>
		<tbody id="tbody_list_address">
			<tr role="row" class="filter">
				<td>
					<?php
					$text = new Text ();
					$text->placeholder = Lang::get ( "ID" );
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
					$text->placeholder = Lang::get ( "First name" );
					$text->class = "form-control form-filter input-sm";
					$text->name = "filter[firstName]";
					$text->value = $filter->firstName;
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->placeholder = Lang::get ( "Last name" );
					$text->class = "form-control form-filter input-sm";
					$text->name = "filter[lastName]";
					$text->value = $filter->lastName;
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"sortAddress()\"";
					$button->render ();
					
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"resetAddressForm()\"";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (count ( $paging->records ) == 0) {
				?>
			<tr role="row" id="tr_no_data">
				<td colspan="4"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $paging->records as $address ) {
					?>
			<tr class="gradeX odd addressIndex" role="row">
				<td>
					<?=$address->id?>
				</td>
				<td>
					<?=$address->firstName?>
				</td>
				<td>
					<?=$address->lastName?>
				</td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->checkActionPath = "admin/address/edit/view";
					$actionBtn->attributes = "onclick='editAddressDialog($address->id)'";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->checkActionPath = "admin/address/del/view";
					$actionBtn->attributes = "onclick='deleteAddressDialog($address->id)'";
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
$pagingTemplate->changePageJs = "changePageAddress";
$pagingTemplate->render ();
?>