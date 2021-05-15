<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Select;
use common\template\extend\Text;
use core\Lang;
use core\template\html\base\BaseSelect;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\config\ApplicationConfig;
$paging = RequestUtil::get ( "userList" );
$userVos = RequestUtil::get ( "userVos" );
$userMo = RequestUtil::get ( 'userMo' );
$filter = RequestUtil::get ( "filter" );
$statusList = ApplicationConfig::get("common.status.list");
$listUserGroup = RequestUtil::get("listUserGroup");
?>
<div class="table-scrollable">
	<?php 
		$text = new Text();
		$text->type 	= 'hidden';
		$text->value 	= AppUtil::defaultIfEmpty(RequestUtil::get("page"),1);
		$text->name 	= "page";
		$text->id 		= "page";
		$text->render();
	?>
	<table class="tbl_sort_data table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="page_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('User Name');?></th>
				<th><?=Lang::get('Email');?></th>
				<th><?=Lang::get('Full Name');?></th>
				<th><?=Lang::get('Phone');?></th>
				<th><?=Lang::get('Group');?></th>
				<th><?=Lang::get('Status');?></th>
				<th><?=Lang::get('Actions');?></th>
			</tr>
		</thead>
		<tbody>
			<tr role="row" class="filter">
				<td>
					<?php
					$text 				= new Text ();
					$text->placeholder 	= Lang::get ( "User Name" );
					$text->class 		= "form-control form-filter input-sm";
					$text->name 		= "filter[userName]";
					$text->value 		= $filter->userName;
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text 				= new Text ();
					$text->placeholder 	= Lang::get ( "Email" );
					$text->class 		= "form-control form-filter input-sm";
					$text->name 		= "filter[email]";
					$text->value 		= $filter->email;
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text 				= new Text ();
					$text->placeholder 	= Lang::get ( "Full Name" );
					$text->class 		= "form-control form-filter input-sm";
					$text->name 		= "filter[fullName]";
					$text->value 		= $filter->fullName;
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$text 				= new Text ();
					$text->placeholder 	= Lang::get ( "Phone" );
					$text->class 		= "form-control form-filter input-sm";
					$text->name 		= "filter[phone]";
					$text->value 		= $filter->phone;
					$text->render ();
					?>
				</td>
				<td>
					<?php
					$select = new Select();
					$select->collectionType = BaseSelect::CT_SINGLE_ARRAY_OBJECT;
					$select->name = "filter[ugName]";
					$select->headerKey = "";
					$select->headerValue = "All";
					$select->collections = $listUserGroup;
					$select->propertyName = "name";
					$select->propertyValue = "name";
					$select->value 		= $filter->ugName;
					$select->class = "form-control form-filter input-sm";
					$select->render();
					?>
				</td>
				<td>
					<?php
					$select = new Select();
					$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
					$select->name = "filter[status]";
					$select->headerKey= "";
					$select->headerValue= "All";
					$select->collections = $statusList;
					$select->class = "form-control form-filter input-sm";
					$select->value = AppUtil::defaultIfEmpty($filter->status);
					$select->render();
					?>
				</td>
				<td>
					<?php
					$button 			= new Button ();
					$button->type 		= "button";
					$button->title 		= " " . Lang::get ( "Search" );
					$button->icon 		= "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"searchUser()\"";
					$button->render ();
					
					$button 			= new Button();
					$button->type 		= "button";
					$button->title 		= " " . Lang::get ( "Reset" );
					$button->icon 		= "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"resetFormUser()\"";
					$button->render ();
					?>
				</td>
			</tr>
			
			<?php
			if (empty ( $userVos ) || count ( $userVos ) == 0) {
				?>
			<tr role="row">
				<td colspan="7"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $userVos as $vo ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$vo->userName?></td>
				<td><?=$vo->email?></td>
				<td><?=$vo->fullName?></td>
				<td><?=$vo->phone?></td>
				<td><?=$vo->ugName?></td>
				<td><?=$statusList[$vo->status]?></td>
				<td>
				<?php 
				$actionBtn = new ButtonAction();
				$actionBtn->iconClass = "fa fa-edit";
				$actionBtn->checkActionPath = "admin/user/edit/view";
				$actionBtn->color = ButtonAction::COLOR_BLUE;
				$actionBtn->js = "editUserDialog($vo->id)";
				$actionBtn->title = Lang::get("Edit");
				$actionBtn->render();
				
				$actionBtn = new ButtonAction ();
				$actionBtn->iconClass = "fa fa-copy";
				$actionBtn->checkActionPath = "admin/user/copy/view";
				$actionBtn->color = ButtonAction::COLOR_BLUE;
				$actionBtn->js = "copyUserDialog($vo->id)";
				$actionBtn->title = Lang::get ( "Clone" );
				$actionBtn->render ();
				
				$actionBtn = new ButtonAction();
				$actionBtn->iconClass = "fa fa-trash-o";
				$actionBtn->checkActionPath = "admin/user/del/view";
				$actionBtn->color = ButtonAction::COLOR_RED;
				$actionBtn->js = "deleteUserDialog($vo->id)";
				$actionBtn->title = Lang::get("Delete");
				$actionBtn->render();
				?>
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
