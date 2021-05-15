<?php
define ( 'DS', DIRECTORY_SEPARATOR );
define ( 'ROOT', dirname ( __FILE__ ) );

// Define some const for the app.
define ( 'CTX', "_dato_" );
define ( 'FIELD_ERRORS', "field_errors" );
define ( 'ACTION_ERRORS', "action_errors" );
define ( 'ACTION_MESSAGES', "action_messages" );
define ( 'REDIRECT_PARAMS', "redirect_params" );
define ('LAYOUT_OPTION','layout_option');
require_once (ROOT . DS . 'app' . DS . 'loader.php');
