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

$countries = RequestUtil::get ( "countries" );
$paging = RequestUtil::get ( "contacts" );
$contacts = $paging->records;
$filter = RequestUtil::get ( "filter" );
?>
<div class="table-scrollable">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="contact_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Id');?></th>
				<th><?=Lang::get('Full Name');?></th>
				<th><?=Lang::get('Email');?></th>
				<th><?=Lang::get('Phone');?></th>
				<th><?=Lang::get('Country');?></th>
				<th><?=Lang::get('Date');?></th>
				<th><?=Lang::get('Status');?></th>
				<th><?=Lang::get('Actions');?></th>
			</tr>
		</thead>
		<tbody>
			<tr role="row" class="filter">
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[id]";
					$text->value = $filter->id;
					$text->placeholder = Lang::get ( "Id" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[fullName]";
					$text->value = $filter->fullName;
					$text->placeholder = Lang::get ( "Full Name" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[email]";
					$text->value = $filter->email;
					$text->placeholder = Lang::get ( "Email" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[phone]";
					$text->value = $filter->phone;
					$text->placeholder = Lang::get ( "Phone" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$select = new Select ();
					$select->value = $filter->countryCode;
					$select->name = "filter[countryCode]";
					$select->attributes = " style='width: 150px' ";
					$select->headerKey = "";
					$select->headerValue = Lang::get ( "All" );
					$select->collections = $countries;
					$select->collectionType = Select::CT_SINGLE_ARRAY_OBJECT;
					$select->propertyName = "iso2";
					$select->propertyValue = "name";
					$select->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ( "text_date" );
					$text->name = "filter[crDateFrom]";
					$text->value = $filter->crDateFrom;
					$text->placeholder = Lang::get ( "From" );
					$text->attributes = "style='width: 100px'";
					$text->render ();
					$text = new Text ( "text_date" );
					$text->name = "filter[crDateTo]";
					$text->value = $filter->crDateTo;
					$text->placeholder = Lang::get ( "To" );
					$text->attributes = "style='width: 100px'";
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
					$select->collections = ApplicationConfig::get ( "contact.status.list" );
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
					$button->attributes = "onclick=\"searchContacts()\"";
					$button->checkActionPath = "admin/contact/search";
					$button->render ();
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"searchContacts(true)\"";
					$button->checkActionPath = "admin/contact/search";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (empty ( $contacts ) || count ( $contacts ) == 0) {
				?>
			<tr role="row">
				<td colspan="7"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $contacts as $contact ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$contact->id?></td>
				<td><?=$contact->fullName?></td>
				<td><?=$contact->email?></td>
				<td><?=$contact->phone?></td>
				<td><?=$contact->countryName?></td>
				<td><?=$contact->crDate?></td>
				<td><?=$contact->status?></td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-desktop";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "detailContactDialog('$contact->id')";
					$actionBtn->title = Lang::get ( "Detail" );
					$actionBtn->checkActionPath = "admin/contact/detail/view";
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deleteContactDialog('$contact->id')";
					$actionBtn->title = Lang::get ( "Delete" );
					$actionBtn->checkActionPath = "admin/contact/del/view";
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
$pagingTemplate->changePageJs = "changePageContacts";
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