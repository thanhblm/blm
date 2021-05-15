<?php
use core\Lang;
?>
<div id="main">
	<div class="light">
		<div>
			<article class="box col-xs-5 login">
				<h2><?=Lang::get("Reset Your Password") ?></h2>
				<p><?=Lang::get("Please enter email address you have used during account creation, and we will send you instruction on how to reset your password.") ?></p>
				<form name="recoverPassword" action="/en/password-reminder?action=recoverPassword" method="post" enctype="multipart/form-data" class="_recoverPassword  purlForm">
					<ul class="message-stack">
						<li class="error"><?=Lang::get("Please enter your Email Address") ?></li>
					</ul>
					<div class="_form">
						<div class="required _field _email _email">
							<div class="_label"><?=Lang::get("Email Address") ?>:</div>
							<div class="_input">
								<span class="frm_field frm_email"><input type="email" name="email" value="aaaaaaaaa@aad.ddd" required="required"></span>
							</div>
						</div>
					</div>
					<div class="_buttons">
						<button type="submit" class="continue">
							<span><?=Lang::get("Reset Password") ?></span>
						</button>
					</div>
				</form>
			</article>
			<article class="box col-xs-2" style="text-align: center !important;"><?=Lang::get("or")?></article>
			<article class="box col-xs-5 register_links">
				<h2><?=Lang::get("Don't Have an Account") ?></h2>
				<p><?=Lang::get("Create an account to get access to the newest products, sales and special offers!") ?></p>
				<button type="submit" class="continue" onclick="$('button.login').click(); $('.login-dialog .nav-tabs a').eq(1).click();">
					<span><?=Lang::get("Create Account") ?></span>
				</button>
			</article>
		</div>
	</div>
</div>