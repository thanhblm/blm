<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Select;
use common\template\extend\Text;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\AppUtil;
use core\utils\RequestUtil;
$paging = RequestUtil::get ( "userGroupList" );
$userGroupVos = RequestUtil::get ( "userGroupVos" );
$filter = RequestUtil::get ( "filter" );
$statusList = ApplicationConfig::get ( "common.status.list" );
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
	<table
		class="tbl_sort_data table table-striped table-bordered table-hover dataTable no-footer"
		role="grid" id="page_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Name');?></th>
				<th><?=Lang::get('Status');?></th>
				<th><?=Lang::get('Actions');?></th>
			</tr>
		</thead>
		<tbody>
			<tr role="row" class="filter">
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
					$select = new Select ();
					$select->class = "form-control form-filter input-sm";
					$select->name = "filter[status]";
					$select->value = AppUtil::defaultIfEmpty ( $filter->status );
					$select->collectionType = 1;
					$select->collections = $statusList;
					$select->headerKey = "";
					$select->headerValue = "All";
					$select->render ();
					?>
				</td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"sortUserGroup()\"";
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
			if (empty ( $userGroupVos ) || count ( $userGroupVos ) == 0) {
				?>
			<tr role="row">
				<td colspan="3"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $userGroupVos as $vo ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$vo->name?></td>
				<td><?=$statusList[$vo->status]?></td>
				<td>
					<?php
					if ($vo->id != 1) {
						$actionBtn = new ButtonAction ();
						//$actionBtn->attributes = " disabled ";
						$actionBtn->iconClass = "fa fa-edit";
						$actionBtn->checkActionPath = "admin/user/group/edit/view";
						$actionBtn->color = ButtonAction::COLOR_BLUE;
						$actionBtn->js = "editUserGroupDialog($vo->id)";
						$actionBtn->title = Lang::get ( "Edit" );
						$actionBtn->render ();
						
						$actionBtn = new ButtonAction ();
						$actionBtn->iconClass = "fa fa-copy";
						$actionBtn->checkActionPath = "admin/user/group/copy/view";
						$actionBtn->color = ButtonAction::COLOR_BLUE;
						$actionBtn->js = "copyUserGroupDialog($vo->id)";
						$actionBtn->title = Lang::get ( "Clone" );
						$actionBtn->render ();
						
						$actionBtn = new ButtonAction ();
						$actionBtn->iconClass = "fa fa-trash-o";
						$actionBtn->checkActionPath = "admin/user/group/del/view";
						$actionBtn->color = ButtonAction::COLOR_RED;
						$actionBtn->js = "deleteUserGroupDialog($vo->id)";
						$actionBtn->title = Lang::get ( "Delete" );
						$actionBtn->render ();
					}
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
