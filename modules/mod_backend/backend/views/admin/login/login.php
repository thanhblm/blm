<?php
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\Lang;
use core\utils\ActionUtil;

if (! AppUtil::isEmptyString ( RequestUtil::get ( "path" ) )) {
	$path = RequestUtil::get ( "path" );
} else {
	$path = "";
}
?>
<body class=" login">
	<!-- BEGIN LOGO -->
	<div class="logo">
        <img width="300px" src="<?=AppUtil::resource_url("global/img/vdato-logo.png")?>" alt="" />
	</div>
	<!-- END LOGO -->
	<!-- BEGIN LOGIN -->
	<div class="content">
		<!-- BEGIN LOGIN FORM -->
		<form class="login-form" action="<?= ActionUtil::getFullPathAlias("admin/login")?>" method="post">
			<input type="hidden" name="path" value="<?=$path ?>">
			<h3 class="form-title">Login to your account</h3>
			<?php
			if (RequestUtil::hasActionMessages ()) {
				?>
			<div class="alert alert-info" role="alert">
				<?=RequestUtil::getActionMessage();?>
			</div>
			<?php } ?>
			<div class="form-group">
				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
				<label class="control-label visible-ie8 visible-ie9"><?=Lang::get("Username") ?></label>
				<div class="input-icon">
					<i class="fa fa-user"></i> <input class="form-control placeholder-no-fix" type="text" autocomplete="on" placeholder="Username" name="userMo[userName]" /> <span><?php echo RequestUtil::getFieldError('userMo[userName]'); ?></span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label visible-ie8 visible-ie9"><?=Lang::get("Password") ?></label>
				<div class="input-icon">
					<i class="fa fa-lock"></i> <input class="form-control placeholder-no-fix" type="password" autocomplete="on" placeholder="Password" name="userMo[password]" /> <span><?php echo RequestUtil::getFieldError('userMo[password]'); ?></span>
				</div>
			</div>
			<div class="form-actions">
				<label class="rememberme mt-checkbox mt-checkbox-outline"> <input type="checkbox" name="remember" value="1" /><?=Lang::get("Remember me") ?><span></span>
				</label>
				<button type="submit" class="btn green pull-right"><?=Lang::get("Login") ?></button>
			</div>
		</form>
		<!-- END LOGIN FORM -->
		<!-- BEGIN CORE PLUGINS -->
		<script src="<?=AppUtil::resource_url("global/plugins/jquery.min.js") ?>" type="text/javascript"></script>
		<script src="<?=AppUtil::resource_url("global/plugins/bootstrap/js/bootstrap.min.js")?>" type="text/javascript"></script>
		<script src="<?=AppUtil::resource_url("global/plugins/js.cookie.min.js")?>" type="text/javascript"></script>
		<script src="<?=AppUtil::resource_url("global/plugins/jquery-slimscroll/jquery.slimscroll.min.js")?>" type="text/javascript"></script>
		<script src="<?=AppUtil::resource_url("global/plugins/jquery.blockui.min.js")?>" type="text/javascript"></script>
		<script src="<?=AppUtil::resource_url("global/plugins/bootstrap-switch/js/bootstrap-switch.min.js")?>" type="text/javascript"></script>
		<!-- END CORE PLUGINS -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<script src="<?=AppUtil::resource_url("global/plugins/jquery-validation/js/jquery.validate.min.js")?>" type="text/javascript"></script>
		<script src="<?=AppUtil::resource_url("global/plugins/jquery-validation/js/additional-methods.min.js")?>" type="text/javascript"></script>
		<script src="<?=AppUtil::resource_url("global/plugins/select2/js/select2.full.min.js")?>" type="text/javascript"></script>
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN THEME GLOBAL SCRIPTS -->
		<script src="<?=AppUtil::resource_url("global/scripts/app.min.js")?>" type="text/javascript"></script>
		<!-- END THEME GLOBAL SCRIPTS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="<?=AppUtil::resource_url("pages/scripts/login.min.js")?>" type="text/javascript"></script>
		<!-- END PAGE LEVEL SCRIPTS -->
		<!-- BEGIN THEME LAYOUT SCRIPTS -->
		<!-- END THEME LAYOUT SCRIPTS -->
	</div>
</body>