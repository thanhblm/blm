<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Select;
use common\template\extend\Text;
use core\Lang;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$paging = RequestUtil::get ( "customerList" );
$filter = RequestUtil::get ( "filter" );
$accountTypes = RequestUtil::get ( "accountTypes" );
$priceLevels = RequestUtil::get ( "priceLevels" );
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
				<th><?=Lang::get('First name');?></th>
				<th><?=Lang::get('Last name');?></th>
				<th><?=Lang::get('Company Name');?></th>
				<th><?=Lang::get('Company Registration Code');?></th>
				<th><?=Lang::get('Email');?></th>
				<th><?=Lang::get('Price Level');?></th>
				<th><?=Lang::get('Account Type');?></th>
				<th><?=Lang::get('Actions');?></th>
			</tr>
		</thead>
		<tbody>
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
					$text = new Text ();
					$text->type = "email";
					$text->placeholder = Lang::get ( "Company Name..." );
					$text->class = "form-control form-filter input-sm";
					$text->name = "filter[companyName]";
					$text->value = $filter->companyName;
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->type = "email";
					$text->placeholder = Lang::get ( "Company Registration Code" );
					$text->class = "form-control form-filter input-sm";
					$text->name = "filter[registrationNo]";
					$text->value = $filter->registrationNo;
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->type = "email";
					$text->placeholder = Lang::get ( "Email" );
					$text->class = "form-control form-filter input-sm";
					$text->name = "filter[email]";
					$text->value = $filter->email;
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$select = new Select ();
					$select->class = "form-control form-filter input-sm";
					$select->name = "filter[priceLevelId]";
					$select->value = $filter->priceLevelId;
					$select->headerKey = "";
					$select->headerValue = "All";
					$select->collections = $priceLevels;
					$select->value = $filter->priceLevelId;
					$select->propertyName = "id";
					$select->propertyValue = "name";
					$select->render ();
					?>
				</td>
				<td>
					<?php
					$select = new Select ();
					$select->class = "form-control form-filter input-sm";
					$select->name = "filter[accountTypeId]";
					$select->value = $filter->accountTypeId;
					$select->headerKey = "";
					$select->value = $filter->accountTypeId;
					$select->headerValue = "All";
					$select->collections = $accountTypes;
					$select->propertyName = "id";
					$select->propertyValue = "name";
					$select->render ();
					?>
				</td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"sortCustomer()\"";
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
				<td colspan="7"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $paging->records as $vo ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$vo->id?></td>
				<td><?=$vo->firstName?></td>
				<td><?=$vo->lastName?></td>
				<td><?=$vo->companyName?></td>
				<td><?=$vo->registrationNo?></td>
				<td><?=$vo->email?></td>
				<td><?=$vo->priceLevelName?></td>
				<td><?=$vo->accountTypeName?></td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->checkActionPath = "admin/customer/edit/view";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "editCustomerDialog($vo->id)";
					$actionBtn->title = Lang::get ( "Edit Info" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-address-card-o";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "viewAddressDialog($vo->id)";
					$actionBtn->title = Lang::get ( "Edit Address" );
					$actionBtn->checkActionPath = "admin/customer/address/view";
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "copyCustomerDialog($vo->id)";
					$actionBtn->checkActionPath = "admin/customer/copy/view";
					$actionBtn->title = Lang::get ( "Clone" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->checkActionPath = "admin/customer/del/view";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deleteCustomerDialog($vo->id)";
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
$pagingTemplate->changePageJs = "changePageCustomer";
$pagingTemplate->render ();
?>
