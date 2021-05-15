<?php 
use core\utils\AppUtil;
?>
Huumn ... if no error then ... maybe your permission table should be updated....
<?php 
$actionNoGroups = $_REQUEST['actionNoGroups'];
if (count($actionNoGroups)>0){
	echo "<BR> those action paths dont have config for 'group':";
	AppUtil::debugInfo($actionNoGroups);	
}
?>