<?php
use core\config\ActionConfig;
use core\config\ApplicationConfig;
use core\config\ModuleConfig;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use common\helper\AddressHelper;
?>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>System info</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style type="text/css">
/* unvisited link */
a:link {
	color: blue;
	text-decoration: none;
}

/* visited link */
a:visited {
	color: blue;
	text-decoration: none;
}

/* mouse over link */
a:hover {
	color: red;
}

/* selected link */
a:active {
	color: red;
}
</style>
<script>
  $( function() {
    $( "#accordion2" ).accordion({active: false,collapsible: true});
    $( "#accordion1" ).accordion({active: false,collapsible: true});
    
    $( "#tabs" ).tabs();
  } );
  </script>
</head>
<body>
<?php 
//AppUtil::debugInfo(AddressHelper::getWashingtonTax("6500  Linderson way", "aa", 985011001));
?>
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Module config</a></li>
			<li><a href="#tabs-2">Action info</a></li>
			<li><a href="#tabs-4">Duplicated/Override Action Module</a></li>
			<li><a href="#tabs-5">Application Config</a></li>
			<li><a href="#tabs-6">All Action config</a></li>
			<li><a href="#tabs-7">-</a></li>
			<li><a href="#tabs-8">-</a></li>
		</ul>
		<div id="tabs-1">
			<div id="accordion1">
				<?php foreach (ModuleConfig::getModules() as $key=>$value){?>
				<h3><?="[".$key."]"?> </h3>
				<div>
					<p>
						<?=AppUtil::debugInfo($value)?>
					</p>
				</div>
				<?php }?>
			</div>
		</div>
		<div id="tabs-2">
			<div id="accordion2">
				<?php foreach (ActionConfig::getSettings() as $key=>$value){?>
				<h3><?="[".ActionConfig::getActionModules()[$key]."] =>  ".$key?> </h3>
				<div>
					<p>
						<a href="<?=ActionUtil::getFullPathAlias($key)?>"><?=$key?></a>
						<?=AppUtil::debugInfo($value)?>
					</p>
				</div>
				<?php }?>
			</div>
		</div>
		<div id="tabs-4">
  		<?=AppUtil::debugInfo(ActionConfig::getDuplicatedActionModules());?>
   </div>
		<div id="tabs-5">
  		<?=AppUtil::debugInfo(ApplicationConfig::getSettings());?>
   </div>
		<div id="tabs-6"><?=AppUtil::debugInfo(ActionConfig::getSettings());?></div>
		<div id="tabs-7"></div>
		<div id="tabs-8"></div>
	</div>
</body>
</html>