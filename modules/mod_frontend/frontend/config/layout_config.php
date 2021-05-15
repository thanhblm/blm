<?php
// Decorators.
$template = \core\config\ApplicationConfig::get('template.name');
return array(
    'excludes' => array(
        '*data.php'
    ),
    'layouts' => array(
        array(
            'layout' => "$template/default.layout.php",
            'pattern' => '*.php'
        )
    )
);