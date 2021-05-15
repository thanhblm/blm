<?php
use core\Decorator;
use core\config\ApplicationConfig;
use core\utils\AppUtil;
?>
<!DOCTYPE html>

<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
<meta charset="utf-8" />
<title><?=ApplicationConfig::get('site.name') ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta content="Preview page of Metronic Admin Theme #3 for " name="description" />
<meta content="" name="author" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
<link href="<?=AppUtil::resource_url("global/plugins/font-awesome/css/font-awesome.min.css")?>" rel="stylesheet" type="text/css" />
<link href="<?=AppUtil::resource_url("global/plugins/simple-line-icons/simple-line-icons.min.css")?>" rel="stylesheet" type="text/css" />
<link href="<?=AppUtil::resource_url("global/plugins/bootstrap/css/bootstrap.min.css")?>" rel="stylesheet" type="text/css" />
<link href="<?=AppUtil::resource_url("global/plugins/bootstrap-switch/css/bootstrap-switch.min.css")?>" rel="stylesheet" type="text/css" />
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="<?=AppUtil::resource_url("global/plugins/select2/css/select2.min.css")?>" rel="stylesheet" type="text/css" />
<link href="<?=AppUtil::resource_url("global/plugins/select2/css/select2-bootstrap.min.css")?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="<?=AppUtil::resource_url("global/css/components.css")?>" rel="stylesheet" id="style_components" type="text/css" />
<link href="<?=AppUtil::resource_url("global/css/plugins.min.css")?>" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?=AppUtil::resource_url("pages/css/login.css")?>" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL STYLES -->

<!-- BEGIN THEME LAYOUT STYLES -->
<link href="<?=AppUtil::resource_url("layouts/layout3/css/layout.min.css")?>" rel="stylesheet" type="text/css" />
<link href="<?=AppUtil::resource_url("layouts/layout3/css/themes/default.min.css")?>" rel="stylesheet" type="text/css" id="style_color" />
<link href="<?=AppUtil::resource_url("layouts/layout3/css/custom.min.css")?>" rel="stylesheet" type="text/css" />
</head>
<!-- END HEAD -->

<?php include Decorator::getBodyPath()?>

</html>