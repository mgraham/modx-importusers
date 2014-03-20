<?php

/**
 * ImportUsers resolver script - runs on install.
 *
 * Copyright 2012 Collaborative Media
 * @author Michael Graham <michael@collaborativemedia.ca>
 *
 * @package ImportUsers
 */
/**
 * Description: Resolver script for ImportUsers package
 * @package ImportUsers
 * @subpackage build
 */

/* Example Resolver script */

/* The $modx object is not available here. In its place we
 * use $object->xpdo
 */

$modx =& $object->xpdo;

function createSetting ($modx, $setting) {
    $existingSetting = $modx->getObject('modSystemSetting', array('key' => $setting['key']));

    if (empty($existingSetting)) {
        $modx->log(xPDO::LOG_LEVEL_INFO,'Creating System setting: '. $setting['key']);
        $setting['name']        = $setting['key'];
        $setting['namespace']   = 'importusers';
        $setting['area']        = 'importusers';
        $settingObj = $modx->newObject('modSystemSetting');
        foreach ($setting as $key => $value) {
            $settingObj->set($key, $value);
        }
        $settingObj->save();
        
    }
}

$success = true;

$modx->log(xPDO::LOG_LEVEL_INFO,'Running PHP Resolver.');
switch($options[xPDOTransport::PACKAGE_ACTION]) {
    /* This code will execute during an install */

    case xPDOTransport::ACTION_INSTALL:

        $modx =& $object->xpdo; 
        $modx->addPackage('importusers',$modelPath); 
        $manager = $modx->getManager(); 

        break;

    /* This code will execute during an upgrade */
    case xPDOTransport::ACTION_UPGRADE:

        /* put any upgrade tasks (if any) here such as removing
           obsolete files, settings, elements, resources, etc.
        */

        $success = true;
        break;

    /* This code will execute during an uninstall */
    case xPDOTransport::ACTION_UNINSTALL:
        $modx->log(xPDO::LOG_LEVEL_INFO,'Uninstalling . . .');
        $success = true;
        break;
    
}


// Maintain system settings.  Create these only if they do not already exist
$modx =& $object->xpdo; 
$modelPath = $modx->getOption('importusers.core_path',null,$modx->getOption('core_path').'components/importusers/').'model/'; 
$assetsUrl = $modx->getOption('importusers.assets_url',null,$modx->getOption('assets_url').'components/importusers/'); 

createSetting($modx, array(
    'key'           => 'importusers.help_table_css',
    'description'   => 'Path to CSS file for styling Help table',
    'value'         => $assetsUrl.'css/importusers_helptable.css',
));
createSetting($modx, array(
    'key'           => 'importusers.help_table_row_chunk',
    'description'   => 'Name of Chunk used for Import Users Help Screen help table row',
    'value'         => 'importUsersHelp'
));
createSetting($modx, array(
    'key'           => 'importusers.help_table_chunk',
    'description'   => 'Name of Chunk used for Import Users Help Screen',
    'value'         => 'importUsersHelpTableRow'
));
createSetting($modx, array(
    'key'           => 'importusers.settings_table_row_chunk',
    'description'   => 'Name of Chunk used for Import Users Help Screen settings table row',
    'value'         => 'importUsersSettingsTableRow'
));


$modx->log(xPDO::LOG_LEVEL_INFO,'Script resolver actions completed');
return $success;
