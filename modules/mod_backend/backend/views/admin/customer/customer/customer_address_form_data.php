<?php
use common\template\extend\FormContainer;
use common\template\extend\Link;
use core\Lang;
use core\utils\RequestUtil;
use common\template\extend\Text;
$taxRate = RequestUtil::get ( "taxRate" );
$pageSizes = RequestUtil::get ( "pageSizes" );
$form = new FormContainer ();
$form->id = "addressFormId";
$form->attributes = 'class="form-horizontal" ';
$address= RequestUtil::get("address");
$form->renderStart ();

$text = new Text();
$text->name = "address[groupId]";
$text->value = $address->groupId;
$text->id = "groupId";
$text->type = "hidden";
$text->render ();


?>
<div class="form-body">
	<div class="portlet light">
		<div class="portlet-title">
			<div class="caption font-green-sharp">
				<i class="fa fa-cogs"></i><?=Lang::get("List address") ?>
			</div>
			<div class="actions">
					<select name="pageSize" onchange="sortAddress()" class="form-control input-sm input-xsmall input-inline" style="height: 25px; padding: 2px 10px;">
					<?php
					foreach ( $pageSizes as $pageSize ) {
						?>
						<option value="<?=$pageSize?>" <?=(RequestUtil::get("pageSize")==$pageSize)?"selected":""?>><?=$pageSize?></option>
						<?php
					}
					?>
					</select>
                <?php
                $link = new Link();
                $link->class = "btn btn-circle blue";
                $link->link = "javascript:addAddressDialog($address->groupId );";
                $link->title = "<i class=\"fa fa-plus white\"></i> ".Lang::get("Add new");
                $link->id = "iAdd";
                $link->checkActionPath = "admin/address/add/view";
                $link->render();

                $link = new Link();
                $link->class = "btn btn-circle btn-icon-only btn-default fullscreen";
                $link->render();
                ?>
			</div>
		</div>
			<div class="portlet-body " id="page_result_address">
				<?php include 'address/address_list_view_data.php';?>
			</div>
	</div>
</div>
<?php $form->renderEnd(); ?>
