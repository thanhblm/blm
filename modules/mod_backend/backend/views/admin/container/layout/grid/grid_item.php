<?php 
use core\Lang;
use common\persistence\base\vo\WidgetVo;
$widgetContentList = $v['widgetContentList'];
$containerVo = $params['containerVo'];
$containerId = $params['containerId'];
?>

<li id="grid_<?=$v['id']?>" 
	class="grid grid_<?=$v['width']?> bm-full-width level-<?=$level ?> 
	cm-sortable-grid ui-sortable col-md-<?=$v['width']?> <?=($v['haveChild'] || empty($widgetContentList)) ? "grid_parent grid_parent$containerId" : ''?>"
	data-order="<?=$v['order']?>"
	data-gridid="<?=$v['id']?>"
	>
	<div class="bm-full-menu grid-control-menu bm-control-menu ui-sortable-handle">
		<div class="grid-control-menu-actions">
			<div class="btn-group action">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<span class="cm-tooltip" title="<?=Lang::get('Add grid or widget')?>">
						<i class="fa fa-plus"></i>
					</span>
				</a>
				<ul class="dropdown-menu droptop">
					<li <?php if(!empty($widgetContentList)) echo 'style="display: none;"' ?>>
						<a class="cm-action bm-action-add-grid" href="javascript:gridAddView<?=$containerId?>(<?=$containerVo->id?>, <?=$v['id']?>)">
							<?=Lang::get('Add grid')?>
						</a>
					</li>
					<li <?php if($v['haveChild']) echo 'style="display: none;"' ?>>
						<a class="cm-action bm-action-add-block" href="javascript:widgetContentAddView<?=$containerId?>(<?=$containerId?>, <?=$v['id']?>)">
							<?=Lang::get('Add widget')?>
						</a>
					</li>
				</ul>
			</div>
			<div class="cm-action cm-tooltip action">
				<a href="javascript:gridEditView<?=$containerId?>(<?=$v['id']?>)" title="<?=Lang::get('Edit grid') ?>">
					<i class="fa fa-edit"></i>
				</a>
			</div>
			<?php if($v['statusParent'] == 'active'){?>
			<div class="cm-action cm-tooltip action">
				<a href="javascript:gridEditStatus<?=$containerId?>(<?=$containerId?>, <?=$v['id']?>, '<?=$v['status']?>')" title="<?=Lang::get('Activate/Deactivate Grid') ?>">
					<i class="fa fa-power-off"></i>
				</a>
			</div>
			<?php }?>
			<div class="cm-action cm-tooltip pull-right extra action" >
				<a href="javascript:gridDeleteView<?=$containerId?>(<?=$v['id']?>)" title="<?=Lang::get('Delete grid') ?>">
					<i class="fa fa-trash"></i>
				</a>
			</div>
		</div>
		<h4 class="grid-control-title">
			#<?=$v['id']?> <?=Lang::getWithFormat("Width {0}", $v['width'])?>
		</h4>
	</div>
	<?php 
		//build widgetContent list
		if(!$v['haveChild'] & empty($widgetContentList)){
			echo "<ul class='grid_widget_list grid_widget_list$containerId sortable_widget_content connectedSortable connectedSortable$containerId ul-sortable ul-sortable$containerId' data-gridid='{$v['id']}'>";
			echo "</ul> <!-- end .connectedSortable$containerId -->";
		}
		else if(!$v['haveChild'] & !empty($widgetContentList)){
			echo "<ul class='grid_widget_list grid_widget_list$containerId sortable_widget_content connectedSortable connectedSortable$containerId' data-gridid='{$v['id']}'>";
			foreach ($widgetContentList as $widgetContent){
				$widgetId = $widgetContent['widgetId'];
				$widgetIcon = ($widgetContent['widgetIcon'] != '') ? "{$widgetContent['widgetIcon']} fa-2x" : "fa fa-bars fa-2x";
	?>
		<li class="block grid_widget_item block-<?=$v['align']?>
			<?=($widgetContent['gridWidgetStatus'] == 'deactive' || $v['status'] == 'deactive' || $v['statusParent'] == 'deactive') ? 'block-off' : '' ?>"
			id="grid_widget_<?=$widgetContent['gridWidgetId']?>"
			data-gridwidgetid="<?=$widgetContent['gridWidgetId']?>"
			data-gridid="<?=$v['id']?>"
			data-widgetcontentid="<?=$widgetContent['id']?>"
			data-order="<?=$widgetContent['gridWidgetOrder']?>"
			>
			<div class="block-header">
				<div class="block-header-icon">
					<i class="<?=$widgetIcon?>" title="<?=$widgetContent['widgetName']?>"></i>
				</div>
				<h4 class="block-header-title" title="<?=$widgetContent['name']?>">
					<?=$widgetContent['name']?>
				</h4>
			</div>
			<div class="bm-full-menu block-control-menu bm-control-menu ui-sortable-handle">
                <a class="cm-tooltip cm-action action" title="<?=Lang::get('Edit widget')?>"
                    href="javascript:widgetContentEditView<?=$containerId?>(<?=$widgetContent['id']?>)">
                    <i class="fa fa-edit"></i>
                </a>
                <?php if($v['status'] == 'active' & $v['statusParent'] == 'active'){?>
                <a class="cm-tooltip cm-action action" title="<?=Lang::get('Activate/Deactivate widget')?>"
                    href="javascript:gridWidgetEditStatus<?=$containerId?>(<?=$containerId?>, <?=$v['id']?>, <?=$widgetContent['id']?>, '<?=$widgetContent['gridWidgetStatus']?>')">
                    <i class="fa fa-power-off"></i>
                </a>
                <?php }?>
                <a class="cm-tooltip cm-action pull-right extra action"
                    href="javascript:gridWidgetDeleteView<?=$containerId?>(<?=$widgetContent['gridWidgetId']?>, <?=$widgetContent['id']?>)"
                    title="<?=Lang::get('Delete widget') ?>">
                    <i class="fa fa-trash"></i>
                </a>
			</div>
		</li>
	<?php }
	echo "</ul> <!-- end .connectedSortable$containerId -->";
		}
	?>
	
<?php if (isset($v['isEnd'])) echo '</div>'?>