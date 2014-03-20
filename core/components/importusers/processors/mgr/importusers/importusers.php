<?php 
/**
 * ImportUsers
 *
 * Copyright 2012 Collaborative Media
 *
 * @author Michael Graham <michael@collaborativemedia.ca>
 *
 * @package importusers
 */

/**
 * CSV Import processor 
 *
 * @package  importusers
 *
 */

$data = $scriptProperties;

require_once dirname(dirname(dirname(dirname(__FILE__)))).'/model/importusers/importusersapp.class.php'; 

// explicitly sets up logging on our register and topic - in case there are multiple consoles running
$modx->request->registerLogging($_POST);

$app = new ImportUsersApp($modx); 


$data = $app->validate_csv_import_form($data, $_FILES);

if ($modx->error->hasError()) { return $app->fatal(''); }

$app->validate_csv_data($data, $_FILES);

// if any errors, we fail

if ($modx->error->hasError()) { return $app->fatal(''); }

$app->import_csv_data($data, $_FILES);

if ($modx->error->hasError()) { return $app->fatal(''); }


return $app->success('');

