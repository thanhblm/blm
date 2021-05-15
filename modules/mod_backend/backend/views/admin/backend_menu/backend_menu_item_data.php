<?php 
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$showInfoStatus = RequestUtil::get('showInfoStatus');
if(isset($v['class'])) $class = "class='{$v['class']}'";
?>
<li class="dd-item dd3-item" id="menu_item_<?=$v['id']?>"
	data-id="<?=$v['id']?>" 
	data-level="<?=$v['level']?>"
	>
	<div class="dd-handle dd3-handle" title="<?=Lang::get("Move menu")?>"></div>
	<div class="dd3-content">
		<a href="<?=ActionUtil::getFullPathAlias($v['link']) ?>" <?=$class?> title="<?=$v['title'];?>" target="_blank">
			<?=$v['title'];?>
		</a>
		<div class="nestable_control">
			<span class="fa fa-key btn_control show_info margin-right-10" title="ID" style="<?= (!$showInfoStatus) ? 'display: none' : ''?>"><?=$v['id']?></span>
			<span class="fa fa-sort-amount-asc btn_control show_info margin-right-10" title="Order" style="<?= (!$showInfoStatus) ? 'display: none' : ''?>"><?=$v['order']?></span>
			<a class="fa fa-edit btn_control btn_edit" title="<?=Lang::get('Edit menu')?>"
				href="javascript:editBackendMenu(<?=$v['id']?>)">
				</a>
			<a class="fa fa-trash btn_control btn_delete" title="<?=Lang::get('Delete menu')?>"
				href="javascript:deleteBackendMenu(<?=$v['id']?>)">
			</a>
		</div>
	</div>
<?php if (isset($v['isEnd'])) echo '</li>'?>