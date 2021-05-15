<?php
use core\config\ApplicationConfig;
use core\utils\ActionUtil;
use core\utils\SessionUtil;
$loginUserInfoMo = SessionUtil::get ( ApplicationConfig::get ( "session.user.login.name" ) );
$loginFullName= "";
if (isset ( $loginUserInfoMo )) {
	$loginFullName = $loginUserInfoMo->fullName;
}
?>
<ul class="nav navbar-nav pull-right">
	<li class="dropdown dropdown-user dropdown-dark"><a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> <!-- img alt="" class="img-circle" src="<?php //echo AppUtil::resource_url("layouts/layout3/img/avatar9.jpg") ?>"--> <span class="username username-hide-mobile">
	Hello: <?=$loginFullName?></span>
	</a> <!-- ul class="dropdown-menu dropdown-menu-default">
			<li><a href="page_user_profile_1.html"> <i class="icon-user"></i> My Profile
			</a></li>
			<li><a href="app_calendar.html"> <i class="icon-calendar"></i> My Calendar
			</a></li>
			<li><a href="app_inbox.html"> <i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger"> 3 </span>
			</a></li>
			<li><a href="app_todo_2.html"> <i class="icon-rocket"></i> My Tasks <span class="badge badge-success"> 7 </span>
			</a></li>
			<li class="divider"></li>
			<li><a href="page_user_lock_1.html"> <i class="icon-lock"></i> Lock Screen
			</a></li>
			<li><a href="page_user_login_1.html"> <i class="icon-key"></i> Log Out
			</a></li>
		</ul--></li>
	<li><a href="<?=ActionUtil::getFullPathAlias('admin/logout') ?>"><i class="icon-logout"></i></a></li>
	<!-- END USER LOGIN DROPDOWN -->
</ul>