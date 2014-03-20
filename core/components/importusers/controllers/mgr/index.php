<?php

$classkey = 'importusers';
$class    = 'ImportUsersApp';

$app = $modx->getService($classkey,$class,$modx->getOption("$classkey.core_path",null,$modx->getOption('core_path')."components/$classkey/")."model/$classkey/",array()); 
if (!($app instanceof $class)) {
    $modx->error->failure('could not load ' . $class);
    return 'Could not load ' . $class ;
}

$modx->regClientStartupScript($app->config['jsUrl'].'mgr/widgets/home.panel.js'); 
$modx->regClientStartupScript($app->config['jsUrl'].'mgr/sections/index.js'); 
$modx->regClientCSS($app->config['help_table_css']); 

// The div to which Ext will render the manager panel
$o = '<div id="importusers-panel-home-div"></div>';

// The help table that Ext will place on the panel
$o = $o . '<div id="importusers-help" style="display:none">';
$o = $o . $app->help();
$o = $o . '</div>';

// The settings table that Ext will place on the panel
$o = $o . '<div id="importusers-settings" style="display:none">';
$o = $o . $app->help();
$o = $o . '</div>';

return $o;

