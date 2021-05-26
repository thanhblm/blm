<?php
use core\utils\RequestUtil;

$customers = RequestUtil::get ( 'customers' );
?>
<div>
<?php 
if(count($customers)>0){
	foreach ($customers as $customer){
?>
	<div class="box _1of3 customer">
		<div>
			<span class="address">#<?=$customer->id?><br><?=$customer->firstName.' '.$customer->lastName?><br><?=$customer->email?>
			</span>
			<div class="buttons">
				<a href="#"
					class="button red" target="_top"><span><?= Lang::get("Login") ?></span></a>
				<a href="#"
					class="button"><span><?= Lang::get("Edit") ?></span></a>
			</div>
		</div>
	</div>
<?php 
	}
}
?>
	<div class="box _1of3 customer">
		<div>
			<span class="customer"></span><a
				href="#"
				class="button"><span><?= Lang::get("Add New") ?></span></a>
		</div>
	</div>
</div>