<?php
/**
 * ImportUsers pre-install script
 *
 * Copyright 2012 Collborative Media
 * @author Michael Graham <michael@collaborativemedia.ca>
 * 2011-05-10
 *
 * @package ImportUsers
 */
/**
 * Description: Example validator checks for existence of getResources
 * @package ImportUsers
 * @subpackage build
 */
/**
 * @package ImportUsers
 * Validators execute before the package is installed. If they return
 * false, the package install is aborted. This example checks for
 * the installation of getResources and aborts the install if
 * it is not found.
 */

/* The $modx object is not available here. In its place we
 * use $object->xpdo
 */
$modx =& $object->xpdo;


$modx->log(xPDO::LOG_LEVEL_INFO,'Running PHP Validator.');
switch($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:

        $modx->log(xPDO::LOG_LEVEL_INFO,'Checking for installed getResources snippet ');
        $success = true;
        /* Check for getResources */
        $gr = $modx->getObject('modSnippet',array('name'=>'getResources'));
        if ($gr) {
            $modx->log(xPDO::LOG_LEVEL_INFO,'getResources found - install will continue');
            unset($gr);
        } else {
            $modx->log(xPDO::LOG_LEVEL_ERROR,'This package requires the getResources package. Please install it and reinstall ImportUsers');
            $success = false;
        }


        break;
   /* These cases must return true or the upgrade/uninstall will be cancelled */
   case xPDOTransport::ACTION_UPGRADE:
        $success = true;
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        $success = true;
        break;
}

return $success;
