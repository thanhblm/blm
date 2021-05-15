<?php
use core\Decorator;
use core\utils\AppUtil;
?>
<link rel="stylesheet" type="text/css"
	href="<?=AppUtil::resource_url("css/style.css")?>" />
<table>
	<tr>
		<td class="header"><img
			src="<?=AppUtil::resource_url("img/logo.png")?>" /> This is header</td>
	</tr>
	<tr>
		<td class="body_content"><?php include Decorator::getBodyPath()?></td>
	</tr>
	<tr>
		<td class="footer">This is footer</td>
	</tr>
</table>
