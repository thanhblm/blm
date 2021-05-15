<?php
use core\Lang;
if (isset ( $paging )) {
	$data = $paging->records;
	if (! empty ( $data ) && count ( $data ) > 0) {
		?>
<div class="row">
	<div class="col-md-5 col-sm-5" style="margin-top: 9px;">
		<div class="dataTables_info" role="status" aria-live="polite"><?=Lang::getWithFormat('Showing {0} to {1} of {2}',$paging->startRecord,$paging->endRecord,$paging->totalRecords)?></div>
	</div>
	<div class="col-md-7 col-sm-7">
		<div class="dataTables_paginate paging_bootstrap_full_number">
			<ul class="pagination" style="visibility: visible; float: right;">
				<?php if($paging->currentPage!=$paging->firstPage):?>
					<li><a title="<?=Lang::get("Go to first page")?>" href="javascript:<?=$changePageJs?>(1)"><i class="fa fa-angle-double-left"></i></a></li>
				<?php endif;?>	
				<?php
		for($i = $paging->firstPage; $i <= $paging->lastPage; $i ++) {
			if ($i == $paging->currentPage) {
				?>
					<li class='active'><a href="javascript:void(0)"><?=$i?></a></li>
				<?php
			} else {
				?>
			<li><a href="javascript:<?=$changePageJs?>(<?=$i?>)"><?=$i?></a></li>
		<?php
			}
		}
		?>
		<?php if($paging->currentPage!=$paging->lastPage):?>
			<li><a title="<?=Lang::get("Go to last page")?>" href="javascript:<?=$changePageJs?>(<?=$paging->totalPage?>)"><i class="fa fa-angle-double-right"></i></a></li>
		<?php endif;?>	
			</ul>
		</div>
	</div>
</div>
<?php
	}
}
?>