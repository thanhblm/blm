<?php
use common\template\extend\Button;
use common\template\extend\ButtonAction;
use common\template\extend\PagingTemplate;
use common\template\extend\Text;
use core\Lang;
use core\utils\RequestUtil;
use core\utils\ActionUtil;
use common\template\extend\SelectInput;
use core\config\ApplicationConfig;

$paging = RequestUtil::get ( "containerList" );
$containerList = $paging->records;
$filter = RequestUtil::get ( "filter" );
?>
<div class="table-scrollable">
	<input id="page" name="page" type="hidden" value="<?=RequestUtil::get("page")?>" />
	<table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="container_table">
		<thead>
			<tr role="row">
				<th><?=Lang::get('Id');?></th>
				<th><?=Lang::get('Name');?></th>
				<th><?=Lang::get('Postion');?></th>
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
					$text->name = "filter[name]";
					$text->value = $filter->name;
					$text->placeholder = Lang::get ( "Name" );
					$text->render ();
					?>
				</td>
				<td>
                    <?php
//                    $select = new SelectInput ();
//                    $select->value = $filter->position;
//                    $select->name = "filter[position]";
//                    $select->collections = ApplicationConfig::get("layout.container.position.list");
//                    $select->collectionType = SelectInput::CT_MULTI_ARRAY_VALUE;
//                    $select->render();
                    ?>
                </td>
				<td>
					<?php
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Search" );
					$button->icon = "<i class='fa fa-search'></i>";
					$button->attributes = "onclick=\"searchContainers()\"";
					$button->render ();
					
					$button = new Button ();
					$button->type = "button";
					$button->title = " " . Lang::get ( "Reset" );
					$button->icon = "<i class='fa fa-refresh'></i>";
					$button->attributes = "onclick=\"searchContainers(true)\"";
					$button->render ();
					?>
				</td>
			</tr>
			<?php
			if (empty ( $containerList ) || count ( $containerList ) == 0) {
				?>
			<tr role="row">
				<td colspan="4"><?=Lang::get("No data available...")?></td>
			</tr>
			<?php
			} else {
				foreach ( $containerList as $containerVo ) {
					?>
			<tr class="gradeX odd" role="row">
				<td><?=$containerVo->id?></td>
				<td><?=$containerVo->name?></td>
				<td><?=$containerVo->position?></td>
				<td>
					<?php
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-edit";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->url = ActionUtil::getFullPathAlias ( 'admin/container/edit/view?containerId=' .$containerVo->id);
					$actionBtn->title = Lang::get ( "Edit" );
					$actionBtn->render ();
					
					$actionBtn = new ButtonAction ();
					$actionBtn->iconClass = "fa fa-copy";
					$actionBtn->color = ButtonAction::COLOR_BLUE;
					$actionBtn->url = ActionUtil::getFullPathAlias ( 'admin/container/copy?containerId=' .$containerVo->id);
					$actionBtn->title = Lang::get ( "Copy" );
					$actionBtn->render ();

					if(!$containerVo->isSystem) {
                        $actionBtn = new ButtonAction ();
                        $actionBtn->iconClass = "fa fa-trash-o";
                        $actionBtn->color = ButtonAction::COLOR_RED;
                        $actionBtn->js = "deleteContainerDialog($containerVo->id)";
                        $actionBtn->title = Lang::get("Delete");
                        $actionBtn->render();
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
$pagingTemplate->changePageJs = "changeContainerPages";
$pagingTemplate->render ();
?>