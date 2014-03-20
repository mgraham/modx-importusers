<?php
/* Define the MODX path constants necessary for connecting to your core and other directories.
 *
 * If you have not moved the core, the current values should work.
 * 
 * In some cases, you may have to hard-code the full paths */

define('MODX_CORE_PATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/core/');
define('MODX_BASE_PATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/');
define('MODX_MANAGER_PATH', MODX_BASE_PATH . 'manager/');
define('MODX_CONNECTORS_PATH', MODX_BASE_PATH . 'connectors/');
define('MODX_ASSETS_PATH', MODX_BASE_PATH . 'assets/');

define('MODX_BASE_URL','/modx/'); 
define('MODX_CORE_URL', MODX_BASE_URL . 'core/'); 
define('MODX_MANAGER_URL', MODX_BASE_URL . 'manager/'); 
define('MODX_CONNECTORS_URL', MODX_BASE_URL . 'connectors/'); 
define('MODX_ASSETS_URL', MODX_BASE_URL . 'assets/'); 

// uncomment for running the test suite
// define('MODX_CONFIG_KEY', 'test_config'); 



?>
