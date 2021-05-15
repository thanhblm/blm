<?php
use core\utils\RequestUtil;

$stateList = RequestUtil::get ( "stateList" );
?>
<select id="stateSelect" class="form-control">
	<option value="" selected>Select state</option>
<?php
foreach ( $stateList as $state ) {
	?>
	<option value=<?=$state->id?>><?=$state->name?></option>
	<?php
}
?>
</select>