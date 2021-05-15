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
$paging = RequestUtil::get ( "subscribers" );
$subscribers = $paging->records;
$filter = RequestUtil::get ( "filter" );
?>
<div class="table-scrollable">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="subscriber_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Id');?></th>
				<th><?=Lang::get('Email');?></th>
				<th><?=Lang::get('First Name');?></th>
				<th><?=Lang::get('Last Name');?></th>
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
					$text->name = "filter[email]";
					$text->value = $filter->email;
					$text->placeholder = Lang::get ( "Email" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[firstName]";
					$text->value = $filter->firstName;
					$text->placeholder = Lang::get ( "First Name" );
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text = new Text ();
					$text->name = "filter[lastName]";
					$text->value = $filter->lastName;
					$text->placeholder = Lang::get ( "Last Name" );
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
					$button->attributes = "onclick=\"searchSubscribers()\"";
					$button->checkActionPath = "admin/subscriber/search";
					$button->render ();
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"searchSubscribers(true)\"";
					$button->checkActionPath = "admin/subscriber/search";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (empty ( $subscribers ) || count ( $subscribers ) == 0) {
				?>
			<tr role="row">
				<td colspan="7"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $subscribers as $subscriber ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$subscriber->id?></td>
				<td><?=$subscriber->email?></td>
				<td><?=$subscriber->firstName?></td>
				<td><?=$subscriber->lastName?></td>
				<td><?=$subscriber->status?></td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "editSubscriberDialog('$subscriber->id')";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->checkActionPath = "admin/subscriber/edit/view";
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "copySubscriberDialog('$subscriber->id')";
					$actionBtn->title = Lang::get ( "Clone" );
					$actionBtn->checkActionPath = "admin/subscriber/copy/view";
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deleteSubscriberDialog('$subscriber->id')";
					$actionBtn->title = Lang::get ( "Delete" );
					$actionBtn->checkActionPath = "admin/subscriber/del/view";
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
$pagingTemplate->changePageJs = "changePageSubscribers";
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