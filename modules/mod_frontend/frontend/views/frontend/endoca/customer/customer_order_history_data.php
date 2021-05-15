<?php
use core\utils\RequestUtil;
use core\Lang;
use core\utils\AppUtil;
use core\utils\DateTimeUtil;

$orderHistories = RequestUtil::get ( 'orderHistories' );
if (count ( $orderHistories) > 0) {
	foreach ($orderHistories as $history ) {
		if((AppUtil::isEmptyString($history->description) || $history->description =="Status Update" ) && $history->cusNotified == "no"){
			?>
	<div class="history-entry" >
		<div class="title">
			<time><?=DateTimeUtil::mySqlStringDate2String($history->crDate, DateTimeUtil::getDateTimeFormat())?></time>
			<?= Lang::get('Status Update').' - '.'<em>'. $history->orderStatusName.'</em>' ?>		
		</div>
	</div>
<?php
		}
		if( $history->cusNotified == "yes"){
		?>
		<div class="history-entry" >
		<div class="title">
			<time><?=DateTimeUtil::mySqlStringDate2String($history->crDate, DateTimeUtil::getDateTimeFormat())?></time>
			<a href="javascript:commentHistory(<?=$history->id?>)" class="button show-comment" style="padding: 0px 15px; float: right;"><span><?=Lang::get("View Comment")?></span></a>
		</div>
		<div id="divComment_<?=$history->id?>" class="comment" style="display: none">
			<div><?=str_replace("\n", "<br/>", $history->description)?></div>
		</div>
	</div>
		<?php 
		}
	}
}else{
	echo Lang::get("No data avaiable...");
}
?>
<script type="text/javascript">
function commentHistory(historyId){
	$("#divComment_"+historyId).toggle();
}
</script>