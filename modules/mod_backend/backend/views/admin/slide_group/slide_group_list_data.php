<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Text;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\template\html\base\BaseSelect;
use common\template\extend\Select;

$paging = RequestUtil::get ( "slideGroupList" );
$slideGroupVos = $paging->records;
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
	<table class="tbl_sort_data table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="page_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Id');?></th>
				<th><?=Lang::get('Name');?></th>
                <th><?=Lang::get('Code');?></th>
				<th><?=Lang::get('Status');?></th>
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
                    $text->placeholder = Lang::get ( "Code" );
                    $text->class = "form-control form-filter input-sm";
                    $text->name = "filter[code]";
                    $text->value = $filter->code;
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
					$select = new Select();
					$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
					$select->name = "filter[status]";
					$select->headerKey = "";
					$select->headerValue = "All";
					$select->collections = $statusList;
					$select->class = "form-control form-filter input-sm";
					$select->value = AppUtil::defaultIfEmpty ( $filter->status );
					$select->render ();
					?>
				</td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"sortSlideGroup()\"";
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
			if (empty ( $slideGroupVos ) || count ( $slideGroupVos ) == 0) {
				?>
			<tr role="row">
				<td colspan="4"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $slideGroupVos as $vo ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$vo->id?></td>
                <td><?=$vo->code?></td>
				<td><?=$vo->name?></td>
				<td>
					<?php
					$select = new Select ();
					$select->collectionType = BaseSelect::CT_MULTI_ARRAY_VALUE;
					$select->collections = $statusList;
					$select->class = "form-control form-filter input-sm";
					$select->value = AppUtil::defaultIfEmpty ( $vo->status );
					$select->attributes ="onchange='changeSlideStatus(".$vo->id.", $(this).val(), \"".$vo->name."\")'";
					$select->render ();
					?>
				</td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-eye";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					// $actionBtn->url = ActionUtil::getFullPathAlias ( "admin/slide/list" ) . "?slideMo[slideGroupId]=" . $vo->id;
					$actionBtn->js = "viewSlideGroups($vo->id)";
					$actionBtn->title = Lang::get ( "View" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					//$actionBtn->js = "editSlideGroupDialog($vo->id)";
					$actionBtn->js = "editSlideGroupDialog($vo->id)";
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->js = "copySlideGroupDialog($vo->id)";
					$actionBtn->title = Lang::get ( "Clone" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-trash-o";
					$actionBtn->color = ButtonAction::COLOR_RED;
					$actionBtn->js = "deleteSlideGroupDialog($vo->id)";
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
$pagingTemplate->changePageJs = "changePageSlideGroup";
$pagingTemplate->render ();
?>
