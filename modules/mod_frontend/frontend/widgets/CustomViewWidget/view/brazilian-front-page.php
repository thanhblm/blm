<?php
use core\Lang;
use common\utils\IpUtils;
use common\helper\LocalizationHelper;

// Get current IP.
$ip = IpUtils::getClientIp();
// Get country code of the IP.
$countryCode = IpUtils::getCountryByIP($ip);
if (empty ($countryCode)) {
	$countryCode = IpUtils::getCountryByIPviaAPI($ip);
}
$countryCode = "-" === $countryCode ? "" : $countryCode;

$countryCode = "BR";

if($countryCode == "BR"){
	$before = "<div class='row'><div class='text-center' style='margin-top:20px;margin-bottom:20px;font-size:20px'>";
	$before .= Lang::get("Buy CBD oil easy call our office in Brazil:<a href='tel:115-581-647-6'><span class='color'>115-581-647-6</span></a> Monday-Friday 9am-6pm");
	$before .= "</div></div>";
	
	$after = "<div class='row front-after'><div class='col-xs-3'></div><div class='col-xs-9'>";
	$after .= Lang::get("<p>In order to buy CBD in Brazil you have 2 options:</p><p>1. Contact agent:</p><p>Buy CBD Oil easy call our office in Brazil: <a href='tel:115-581-647-6'><span class='color'>115-581-647-6</span></a>Monday-Friday 9am-6pm<br>Email: <a href='mailto:brazil@endoca.com'><span class='color'>brazil@endoca.com</span></a></p>2. Do it yourself (click <a href='uploads/en/Endoca_Brazil_ANVISA.pdf' target='_blank'><span class='color'>here</span></a> to download the guideline)");
	$after .="</div></div>";
?>
	<script type="text/javascript">
		$("#top_line").before("<?=$before?>");
		$("#top_line").after("<?=$after?>");
	</script>
<?php 
}
?>