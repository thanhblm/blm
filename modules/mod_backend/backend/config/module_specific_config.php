<?php
use core\config\ApplicationConfig;
use core\config\ModuleConfig;
use core\config\FConstants;
ApplicationConfig::set ( "html.template.path", ModuleConfig::getModuleConfig("mod_common")[FConstants::VIEW_PATH].DS."template" );

