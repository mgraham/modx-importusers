<?php

/**
 * Script to interact with user during ImportUsers package install
 *
 * Copyright 2011 Michael Graham <magog@the-wire.com>
 * @author Michael Graham <magog@the-wire.com>
 * 2011-05-10
 *
 * @package ImportUsers
 */
/**
 * Description: Script to interact with user during ImportUsers package install
 * @package ImportUsers
 * @subpackage build
 */
/* Use these if you would like to do different things depending on what's happening */

/* The return value from this script should be an HTML form (minus the
 * <form> tags and submit button) in a single string.
 *
 * The form will be shown to the user during install
 * after the readme.txt display.
 *
 * This example presents an HTML form to the user with one input field
 * (you can have more).
 *
 * The user's entries in the form's input field(s) will be available
 * in any php resolvers with $modx->getOption('field_name', $options, 'default_value').
 *
 * You can use the value(s) to set system settings, snippet properties,
 * chunk content, etc. One common use is to use a checkbox and ask the
 * user if they would like to install an example resource for your
 * component.
 */

$output = '<p>&nbsp;</p>
<label for="sitename">The value here will be used to set the site_name system setting on install.</label>
<p>&nbsp;</p>
<input type="text" name="sitename" id="sitename" value="" align="left" size="40" maxlength="60" />
<p>&nbsp;</p>
<input type="checkbox" name="change_sitename" id="change_sitename" checked="checked" value="1" align="left" />&nbsp;&nbsp;
<label for="change_sitename">Set site name on install</label>
<p>&nbsp;</p>';


return $output;
