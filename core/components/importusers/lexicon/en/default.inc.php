<?php

$_lang['importusers'] = 'Import Users';
$_lang['importusers.menu_desc'] = 'Bulk User Importer';
$_lang['importusers.title_import_export_users'] = 'Bulk User Importer/Exporter';
$_lang['importusers.err_no_data'] = 'No data';
$_lang['importusers.err_nf'] = 'Not found';


$_lang['importusers.import_panel_title']        = 'Import Users';
$_lang['importusers.import_panel_description']  = 'Choose a file in CSV format to import.  <br />The format of the file is described below in the "Help" section.<br />You can also export the existing users with the "Export Users" section below.  This will give you an initial CSV file to work with';

$_lang['importusers.export_panel_title']        = 'Export Users';
$_lang['importusers.export_panel_description']  = 'Export all users in the system in CSV format.  The password column will not be included.';

$_lang['importusers.help_panel_title']        = 'Help';

$_lang['importusers.import_settings_description']       = 'The following system settings affect details of the import';
$_lang['importusers.setting']                           = 'Setting';
$_lang['importusers.value']                             = 'value';
$_lang['importusers.import_setting_allow_multiple_emails']      = 'Allow Duplicate Email Addresses in the Sytem';
$_lang['importusers.import_setting_password_min_length']        = 'Minimum length of passwords';
$_lang['importusers.import_setting_password_generated_length']  = 'Length of Passwords when Auto-Generated';
$_lang['importusers.import_setting_signupemail_message']        = 'Current Sign Up Email Message (system setting: signupemail_message)';
$_lang['importusers.import_button'] = 'Import CSV';


$_lang['importusers.download_button'] = 'Download';
$_lang['importusers.panel_description'] = 'This module allows you to import multiple users at once via a CSV file, and to export users to a CSV file.';
$_lang['importusers.panel_help'] = 'The following CSV fields are supported by the importer:';
$_lang['importusers.help_field'] = 'Field';
$_lang['importusers.help_note'] = 'Note';

$_lang['importusers.help_field_username'] = '(required)';

$_lang['importusers.help_field_password'] = 'optional; if absent, a password will be automatically generated';        

$_lang['importusers.help_field_active'] = '1=yes, 0=no (default==1)';

$_lang['importusers.help_field_groups'] = 'comma-delimited list of group memberships; each group membership is in the form of "name:role:rank."<br /><br />For instance:  "Content Editors:Member:0,Premium Content:Member:1,Newsletter Editors:Super User:2".  <br /><br />The user group that has a rank of 0 will be set as the user\'s primary user group.  <br />Role and rank are optional.  <br />Role defaults to "Member" and rank defaults to 0.  <br/>Note also that rank is not supported on versions less than MODx 2.2.2';
                                                
$_lang['importusers.help_field_fullname'] = '';          
                                                
$_lang['importusers.help_field_email'] = '(required)';            
$_lang['importusers.help_field_phone'] = '';            
$_lang['importusers.help_field_mobilephone'] = '';      
$_lang['importusers.help_field_blocked'] = '1=yes, 0=no      (default==0)';          
$_lang['importusers.help_field_blockeduntil'] = 'date string (e.g. 12/31/1979).  Requires MODx 2.2.2'; 
$_lang['importusers.help_field_blockedafter'] = 'date string (e.g. 12/31/1979).  Requires MODx 2.2.2'; 
$_lang['importusers.help_field_dob'] = 'date string (e.g. 12/31/1979).  Requires MODx 2.2.2';
$_lang['importusers.help_field_gender'] = 'M=male, F=female';
$_lang['importusers.help_field_address'] = '';           
$_lang['importusers.help_field_country'] = '';                      
$_lang['importusers.help_field_city'] =    '';                      
$_lang['importusers.help_field_state'] =   '';                     
$_lang['importusers.help_field_zip'] =     '';                      
$_lang['importusers.help_field_fax'] =     '';                      
// $_lang['importusers.help_field_photo'] =   '';                      
$_lang['importusers.help_field_comment'] = '';                      
$_lang['importusers.help_field_website'] = '';                      
$_lang['importusers.help_field_extended'] = 'JSON string';


// import window - Principal regions and Area Reps
$_lang['importusers.import_checkbox_overwrite_existing'] = 'If user already exists then overwrite existing user settings with those in CSV file'; 
$_lang['importusers.import_upload_csv_file']         = 'CSV file'; 
$_lang['importusers.import_checkbox_send_notifications']         = 'Send password notification messages to users'; 
$_lang['importusers.import_upload_csv_file_empty_text'] = 'Select a CSV file...'; 
$_lang['importusers.import_upload_csv_file_button_text'] = 'Browse...'; 
$_lang['importusers.import_upload_csv_import_button_text'] = 'Import';
$_lang['importusers.import_upload_csv_export_button_text'] = 'Export';
$_lang['importusers.import_line_number'] = 'Line number';
$_lang['importusers.import_clear_existing'] = 'Clearing existing users before import'; 
$_lang['importusers.import_importing_csv_data'] = 'importing CSV data';
$_lang['importusers.import_users_imported'] = '[[+num]] user(s) imported';
$_lang['importusers.import_importing_row'] = 'Importing CSV row #[[+row]]';
$_lang['importusers.import_validating_row'] = 'Validating CSV row #[[+row]]';
$_lang['importusers.import_validating_csv_data'] = 'Validating CSV data';
$_lang['importusers.import_validated_csv_data_error'] = 'Errors in CSV file';
$_lang['importusers.import_validated_csv_data_ok'] = 'Validated CSV data OK';

$_lang['importusers.import_title']      = "Import Users";
$_lang['importusers.import_err_import'] = 'Could not import the users'; 
$_lang['importusers.err_invalid_data_on_import']      = 'Inconsistent data validation - either validation step was skipped, or file changed after validation'; 


// invalid fields


$_lang['importusers.err_field_extended_invalid_json']      = "invalid field 'extended': JSON string cannot be parsed";
$_lang['importusers.err_field_gender_invalid']             = "invalid field 'gender': '[[+field]]' is not a valid gender - must only be the letter F or the letter M";
$_lang['importusers.err_field_dob_invalid']                = "invalid field 'dob': '[[+field]]' is not a valid date";
$_lang['importusers.err_field_blockeduntil_invalid']       = "invalid field 'blockeduntil': '[[+field]]' is not a valid date";
$_lang['importusers.err_field_blockedafter_invalid']       = "invalid field 'blockedafter': '[[+field]]' is not a valid date";
$_lang['importusers.err_field_email_ns']                   = "required field 'email' not specified";
$_lang['importusers.err_field_email_already_exists']       = "invalid field 'email': there is already a user in the system with address '[[+field]]'";
$_lang['importusers.err_field_email_duplicate_in_csv_file']= "invalid field 'email': the email address '[[+field]]' appears more than once in CSV file.  It last appeared on line [[+line]]";
$_lang['importusers.err_field_groups_invalid']             = "invalid field 'groups': could not parse: '[[+field]]'";
$_lang['importusers.err_field_username_ns']                = "required field 'username' is not specified";
$_lang['importusers.err_field_username_invalid']           = "invalid field 'username': '[[+field]]' contains disallowed characters ";
$_lang['importusers.err_field_username_ae']                = "invalid field 'username': there is already a user in the system with the username '[[+field]]'";
$_lang['importusers.err_field_password_too_short']         = "invalid field 'password': '[[+field]]' is too short; must be minimum of [[+min]] characters";
$_lang['importusers.err_field_password_invalid']           = "invalid field 'password': '[[+field]]' contains disallowed characters ";
$_lang['importusers.err_field_group_name_ns']              = "invalid field 'groups': one or more group names not specified.  Groups string is '[[+groups]]'";
$_lang['importusers.err_field_group_name_nf']              = "invalid field 'groups': No usergroup named '[[+name]]' exists.  Groups string is [[+groups]]'";
$_lang['importusers.err_field_group_role_nf']              = "invalid field 'groups': could not find a role in the system with the name '[[+role]]'. Groups string is '[[+groups]]'";
$_lang['importusers.err_field_group_rank_invalid']         = "invalid field 'groups': rank '[[+rank]]' not a valid number.  Groups string is '[[+groups]]'";
$_lang['importusers.err_processor_error']                  = "User could not be created: the specific errors were '[[+errors]]' and message was '[[+message]]'";
$_lang['importusers.err_processor_message']                = "There was an error creating user '[[+username]]': '[[+message]]'";

$_lang['importusers.user_created']                         = "User '[[+username]]' created with password '[[+password]]'";
$_lang['importusers.user_created_and_notified']            = "User '[[+username]]' created and sent an email with their password";
$_lang['importusers.user_created_with_password_unknown']   = "User '[[+username]]' created";

$_lang['importusers.user_updated']                         = "User '[[+username]]' updated with password '[[+password]]'";
$_lang['importusers.user_updated_and_notified']            = "User '[[+username]]' updated and sent an email with their password";
$_lang['importusers.user_updated_with_password_unknown']   = "User '[[+username]]' updated";

/* These are for any new system settings your component creates */
