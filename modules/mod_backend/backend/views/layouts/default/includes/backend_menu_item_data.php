<?php 
use core\Lang;
use core\utils\ActionUtil;
?>

<?php if($v['haveChild']){?>
	<li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown ">
		<a href="javascript:;"> 
			<?php if($v['icon'] != '') echo "<i class='{$v['icon']}'></i>" ?>
			<?=Lang::get($v['title'])?>
			<span class="arrow"></span>
		</a>
<?php } else{?>
<li aria-haspopup="true" class=" ">
	<a href="<?=ActionUtil::getFullPathAlias($v['link'])?>" class="nav-link"> 
		<?php if($v['icon'] != '') echo "<i class='{$v['icon']}'></i>" ?>
		<?=Lang::get($v['title'])?>
	</a>
<?php }?>

<?php if (isset($v['isEnd'])) echo '</li>'?>