<?php
use core\Decorator;
use core\utils\AppUtil;
use core\utils\RequestUtil;

?>
<!DOCTYPE html>

<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
	<meta charset="utf-8"/>
	<title><?= RequestUtil::get("pageTitle") ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="Preview page of Metronic Admin Theme #3 for " name="description"/>
	<meta content="" name="author"/>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="<?= AppUtil::resource_url("global/plugins/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet" type="text/css"/>
    <link href="<?=AppUtil::resource_url("global/css/file_manage.css") ?>" rel="stylesheet" type="text/css" />

	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN THEME GLOBAL STYLES -->
	<link href="<?= AppUtil::resource_url("global/css/components.css") ?>" rel="stylesheet" id="style_components" type="text/css"/>
	<link href="<?= AppUtil::resource_url("global/css/plugins.css") ?>" rel="stylesheet" type="text/css"/>
	<!-- END THEME GLOBAL STYLES -->
	<!-- BEGIN THEME LAYOUT STYLES -->
	<link href="<?= AppUtil::resource_url("layouts/layout3/css/layout.min.css") ?>" rel="stylesheet" type="text/css"/>
	<link href="<?= AppUtil::resource_url("layouts/layout3/css/themes/default.min.css") ?>" rel="stylesheet" type="text/css" id="style_color"/>
    <script src="<?= AppUtil::resource_url("global/plugins/jquery.min.js") ?>" type="text/javascript"></script>
</head>
<body>
<?php include Decorator::getBodyPath() ?>
</body>