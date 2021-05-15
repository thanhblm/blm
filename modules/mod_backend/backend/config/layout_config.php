<?php
// Decorators.
return array (
		'excludes' => array (
				'*data.php'
		),
		'layouts' => array (
				array (
						'layout' => 'default/default-login.layout.php',
						'pattern' => 'admin/login/login.php'
				),
				array (
						'layout' => 'default/default.layout.php',
						'pattern' => '*.php'
				)
		)
);