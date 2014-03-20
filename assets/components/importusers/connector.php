<?php
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';
 
$corePath = $modx->getOption('importusers.core_path',null,$modx->getOption('core_path').'components/importusers/');
require_once $corePath.'model/importusers/importusersapp.class.php';
$modx->importusersapp = new ImportUsersApp($modx);
 
$modx->lexicon->load('importusers:default');
 
/* handle request */
$path = $modx->getOption('processorsPath',$modx->importusers->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));
