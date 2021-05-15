<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Text;
use core\Lang;
use core\utils\AppUtil;
use core\utils\RequestUtil;

$paging = RequestUtil::get ( "attrGroupList" );
$attrGroupList = $paging->records;
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
				<th><?=Lang::get('Name');?></th>
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
					$button->attributes = "onclick=\"sortAttrGroup()\"";
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
			if (empty ( $attrGroupList ) || count ( $attrGroupList ) == 0) {
				?>
			<tr role="row">
				<td colspan="3"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $attrGroupList as $vo ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$vo->id?></td>
				<td><?=$vo->name?></td>
				<td>
					<?php
				/* 	$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-eye";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					// $actionBtn->url = ActionUtil::getFullPathAlias ( "admin/batch/list" ) . "?batchMo[batchGroupId]=" . $vo->id;
					$actionBtn->js = "viewAttrGroups($vo->id)";
					$actionBtn->title = Lang::get ( "View" );
					$actionBtn->render ();  */
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					//$actionBtn->js = "editAttrGroupDialog($vo->id)";
					$actionBtn->js = "editAttrGroupDialog($vo->id)";
				/*  $actionBtn->checkActionPath = "admin/batch/group/edit/view";*/	
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->render ();
					
					 $actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "copyAttrGroupDialog($vo->id)";
					$actionBtn->title = Lang::get ( "Clone" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deleteAttrGroupDialog($vo->id)";
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
$pagingTemplate->changePageJs = "changePageAttrGroup";
$pagingTemplate->render ();
?>
