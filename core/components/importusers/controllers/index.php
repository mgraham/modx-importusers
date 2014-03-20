<?php

/**
 * Controller index.php for the importusers package
 * @author Michael Graham
 *
 * @package importusers

 */

require_once dirname(dirname(__FILE__)).'/model/importusers/importusersapp.class.php'; 
$app = new ImportUsersApp($modx); 
return $app->initialize('mgr');


