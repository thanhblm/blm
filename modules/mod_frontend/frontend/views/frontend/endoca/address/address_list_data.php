<?php
use common\template\extend\Text;
use common\template\extend\PagingTemplate;
use core\utils\RequestUtil;
use core\Lang;
$page = RequestUtil::get ( "page" );
$paging = RequestUtil::get ( "addressList" );
$address = RequestUtil::get ( "address" );
$text = new Text ();
$text->name = "page";
$text->value = $page;
$text->type = "hidden";
$text->id = "pageAddress";
$text->render ();

$text = new Text ();
$text->name = "pageSize";
$text->value = "10";
$text->id = "pageSize";
$text->type = "hidden";
$text->render ();

$text = new Text ();
$text->name = "address[groupId]";
$text->value = $address->groupId;
$text->type = "hidden";
$text->id = "groupId";
$text->render ();

if (count ( $paging->records) == 0) {
?>
<div class="box col-xs-4 address">
    <div>
        <span class="address"></span><a href="#" class="button" onclick="addAddress()"><span><?=Lang::get ( "Add New" )?></span></a>
    </div>
</div>
<?php
}else{
	foreach ( $paging->records as $vo){
?>
<div class="box col-xs-4 address">
	<div>
		<span class="address"><?=$vo->firstName . " " . $vo->lastName ?> <br>
		<?=$vo->address ?>
		<br><?=$vo->postalCode ." " . $vo->city?> , <?=$vo->stateName ?><br><?=$vo->countryName ?>
		</span><a href="#" class="button" onclick="editAddress(<?=$vo->id ?>)"><span>Edit</span></a> <a href="#"
			class="button red" onclick="delAddress(<?=$vo->id ?>)"><span>Delete</span></a>
	</div>
</div>
<?php  } ?>
<div class="box col-xs-4 address">
	<div>
		<span class="address"></span><a href="#" class="button" onclick="addAddress()"><span><?=Lang::get ( "Add New" )?></span></a>
	</div>
</div>
<?php  } 

$pagingTemplate = new PagingTemplate ();
$pagingTemplate->paging = $paging;
$pagingTemplate->changePageJs = "changeAddressPage";
$pagingTemplate->render ();
?>