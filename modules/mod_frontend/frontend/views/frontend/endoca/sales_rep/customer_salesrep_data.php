<?php
use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\PagingTemplate;

$paging = RequestUtil::get("salesRepList");
$salesRepList = $paging->records;
?>
<a name="customers"/>
<div id="account_container">
    <h2>My Customers</h2>
    <input id="page" name="page" type="hidden" value="<?= RequestUtil::get("page") ?>"/>
	<?php foreach ($salesRepList as $salesRep) { ?>
        <div class="box _1of3 customer">
            <div>
			<span class="address">#<?= $salesRep->id ?><br><?= $salesRep->firstName . ' ' . $salesRep->lastName ?>
                <br><?= $salesRep->email ?>
			</span>
                <div class="buttons">
                    <a onclick="autoSaleRepLogin(<?= $salesRep->id ?>);" class="button red" target="_top">
                        <span>Login</span></a>
                    <a onclick="loadEditSaleRepForm(<?= $salesRep->id ?>);" class="button"><span>Edit</span></a>
                </div>
            </div>
        </div>
        
		<?php
	}
	?>
    <div class="box _1of3 customer">
            <div>
                <span class="customer"></span>
                <a onclick="loadAddSaleRepForm()" class="button"><span>Add New</span></a>
            </div>
    </div>
	<?php
	$pagingTemplate = new PagingTemplate ();
	$pagingTemplate->paging = $paging;
	$pagingTemplate->changePageJs = "changePageSaleRep";
	$pagingTemplate->render();
	?>
    <div class="cb"></div>
</div>