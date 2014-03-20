<?php                                    
/**
 * ImportUsersApp
 *
 * Copyright 2012 Collaborative Media
 *
 * @author Michael Graham <michael@collaborativemedia.ca>
 *
 * @package importusers
 */

/**
 * MODx ImportUsersApp Class
 *
 * @package  importusers
 *
 * Utility class for the ImportUsers
 *
 */

class ImportUsersApp { 
    public $modx; 
    public $config = array(); 
    public $lexPrefix = 'importusers';
    public $seenEmailAddress;

    public $csvUserFields = array(
        'username',
        'active',
    );

    public $csvProfileFields = array(
        'fullname',
        'email',
        'phone',
        'mobilephone',
        'blocked',
        'blockeduntil',
        'blockedafter',
        'dob',
        'gender',
        'address',
        'country',
        'city',
        'state',
        'zip',
        'fax',
        'photo',
        'comment',
        'website',
        'extended',
    );
    public $csvOtherFields = array(
        'groups',
    );

    function __construct(modX &$modx,array $config = array()) { 
        $this->modx =& $modx; 
  
        $basePath = $this->modx->getOption('importusers.core_path',$config,$this->modx->getOption('core_path').'components/importusers/'); 
        $assetsUrl = $this->modx->getOption('importusers.assets_url',$config,$this->modx->getOption('assets_url').'components/importusers/'); 
        $this->config = array_merge(array( 
            'basePath' => $basePath, 
            'corePath' => $basePath, 
            'modelPath' => $basePath.'model/', 
            'processorsPath' => $basePath.'processors/', 
            'exportUrl' => 'mgr/importusers/exportusers.php', 
            'chunksPath' => $basePath.'elements/chunks/', 
            'jsUrl' => $assetsUrl.'js/', 
            'cssUrl' => $assetsUrl.'css/', 
            'assetsUrl' => $assetsUrl, 
            'connectorUrl' => $assetsUrl.'connector.php', 
            'setting_allow_multiple_emails'       => $this->modx->getOption( 'allow_multiple_emails' ) ? 'Yes' : 'No',
            'setting_password_min_length'         => $this->modx->getOption( 'password_min_length',         array(), 6),
            'setting_password_generated_length'   => $this->modx->getOption( 'password_generated_length',   array(), 6),
            'setting_signupemail_message'         => $this->modx->getOption( 'signupemail_message'  ),
            'help_table_css'                      => $this->modx->getOption( 'importusers.help_table_css' ,             array(), $assetsUrl.'css/importusers_helptable.css'),
            'help_table_chunk'                    => $this->modx->getOption( 'importusers.help_table_row_chunk' ,       array(), 'importUsersHelp'),
            'help_table_row_chunk'                => $this->modx->getOption( 'importusers.help_table_chunk'  ,          array(), 'importUsersHelpTableRow'),
            'settings_table_row_chunk'            => $this->modx->getOption( 'importusers.settings_table_row_chunk' ,   array(), 'importUsersSettingsTableRow'),

        ),$config); 

        $this->modx->addPackage('importusers',$this->config['modelPath']);
    } 

    public function initialize($ctx = 'web') { 
       switch ($ctx) { 
            case 'mgr': 
                $this->modx->lexicon->load('importusers:default'); 
                if (!$this->modx->loadClass('ImportUsersControllerRequest',$this->config['modelPath'].'importusers/request/',true,true)) { 
                   return 'Could not load controller request handler. path: ' . $this->config['modelPath'].'importusers/request/'; 
                } 
                $this->request = new ImportUsersControllerRequest($this); 
                return $this->request->handleRequest(); 
            break; 
        }
        return true; 
    }

    public function validate_csv_import_form($data, $files) {
        global $modx;
        if (empty($files['csv-file']) || !is_uploaded_file($files['csv-file']['tmp_name'])) {
            $this->console($this->lex('err_no_data'), 'error');
            $modx->error->addField('csv-file',$this->lex('err_no_data'));
            return;
        }
        return $data;
    }

    
    public function validate_csv_data($data, $files) {
        global $modx;

        $csv_file = $files['csv-file']['tmp_name'];

        // $max_line_length = 2048;
        $max_line_length = 16384;
        $lineNum = 0;
        
        $this->console($this->lex('import_validating_csv_data'));

        $this->seenEmailAddress = array();

        if (($handle = fopen("$csv_file", "r")) !== false) { 
            $columns = fgetcsv($handle, $max_line_length, ","); 
            foreach ($columns as &$column) { 
                $column = str_replace(".","",$column); 
            } 
            $rowData = $data;
            while (($row = fgetcsv($handle, $max_line_length, ",")) !== false) { 
                $lineNum++;
                for($i=0; $i < count($row); $i++) {
                    $rowData[$columns[$i]] = $row[$i];
                }
                
                $this->console($this->lex('import_validating_row', array( 'row' => $lineNum)));
                
                // errors will be written to console 
                $rowData = $this->validate($rowData, true, $lineNum);

            } 
            fclose($handle); 
        } 
        if ($modx->error->hasError()) {
            $this->console($this->lex('import_validated_csv_data_error'));
        }
        else {
            $this->console($this->lex('import_validated_csv_data_ok'));
        }

    }


    public function import_csv_data($data, $files) {
        global $modx;
        
        $this->console($this->lex('import_importing_csv_data'));

        $csv_file = $files['csv-file']['tmp_name'];

        // $max_line_length = 2048;
        $max_line_length = 16384;
        $lineNum = 0;
        $created = 0;
        
        $this->seenEmailAddress = array();

        if (($handle = fopen("$csv_file", "r")) !== false) { 
            $columns = fgetcsv($handle, $max_line_length, ","); 
            foreach ($columns as &$column) { 
                $column = str_replace(".","",$column); 
            } 
            $rowData = $data;
            while (($row = fgetcsv($handle, $max_line_length, ",")) !== false) { 
                $lineNum++;
                for($i=0; $i < count($row); $i++){
                    $rowData[$columns[$i]] = $row[$i];
                }
                $rowData = $this->validate($rowData, true, $lineNum);

                if ($modx->error->hasError()) {
                    $message = $this->lex('err_invalid_data_on_import');
                    $this->addError(array('csv-file'),$message,true, $lineNum);
                    return;
                }

                $this->console($this->lex('import_importing_row', array( 'row' => $lineNum)));
                
                $response = $this->createOrUpdateUser($data, $rowData, true, $lineNum);
                
                if ($response->isError()) {
                    // error message was already reported by createUser, so we don't report it again here
                    $this->console($this->lex('import_users_imported', array('num' => $created)));
                    fclose($handle); 
                    return;
                }
                else {
                    $created++;
                }
            } 
            fclose($handle); 
            if ($created > 0) {
                $this->console($this->lex('import_users_imported', array('num' => $created)));
            }
        }                        
    }

    public function createOrUpdateUser(&$data, &$userData, $logToConsole = false, $line) {
        global $modx;
        
        if (!empty($data['sendnotification']) && $data['sendnotification']) {
            $userData['passwordnotifymethod'] = 'e'; 
        }
        else {
            $userData['passwordnotifymethod'] = 's';  
        }

        // get processor to create password, if not specified
        $userData['specifiedpassword'] = $userData['password'];
        $userData['confirmpassword']   = $userData['password'];
        
        if (empty($userData['password'])) {
            $userData['passwordgenmethod'] = 'g'; 
        }
        else {
            $userData['passwordgenmethod'] = 's'; 
        }

        $update = !empty($data['overwriteexisting']) ? $data['overwriteexisting'] : false;
        
        if ($update) {
            $user = $modx->getObject('modUser', array('username' => $userData['username']));
            if (!empty($user)) {
                $userData['id'] = $user->get('id');
            }
        }
        
        if ($update && !empty($userData['id'])) {
            $response = $this->modx->runProcessor('security/user/update', $userData);
        }
        else {
            $response = $this->modx->runProcessor('security/user/create', $userData);
        }
        // work around the problem that calling runProcessor resets the logging target to FILE
        // http://forums.modx.com/thread/31512/bug-connector-overwriting-custom-registry-logging
        // http://tracker.modx.com/issues/4480
        $modx->request->registerLogging($_POST);
        $this->console("message from processor: " . $modx->error->message);
            
        if ($response->hasFieldErrors()) {
            $fieldErrors = $response->getAllErrors();
            $errorMessage = implode("\n", $fieldErrors);
            $this->addError(array('csv-file'),'err_processor_error', $logToConsole, $line, array(
                'errors'  => $errorMessage,
                'message' => $response->getMessage(),
            ));
        }
        else {
            // after creation, the processor will put a message in modx->error like
            // The User has been created. The password is: rXX8tXqg 
            // we extract the password from the message to display in the console
            // we remove the message from $modx->errors because it will show up as 
            // an error if we don't remove it

            $matches = array();
            if ($modx->error->message) {
                // reset it
                $message = $modx->error->message;
                $modx->error->message = '';
                $this->console("message from processor: $message");

                // extract the password
                if (preg_match('/password.*:\s*(.*)\s*$/i', $message, $matches)) {
                    $password = $matches[1];
                    if ($update) {
                        $this->console($this->lex('user_updated', array('username' => $userData['username'], 'password' => $password)));
                    }
                    else {
                        $this->console($this->lex('user_created', array('username' => $userData['username'], 'password' => $password)));
                    }
                }
                else {
                    $this->console($this->lex('err_processor_message', array('username' => $userData['username'], 'message' => $message)), 'error');
                }
            }
            else {
                if (!empty($data['sendnotification']) && $data['sendnotification']) {
                    if ($update) {
                        $this->console($this->lex('user_updated_and_notified', array('username' => $userData['username'])));
                    }
                    else {
                        $this->console($this->lex('user_created_and_notified', array('username' => $userData['username'])));
                    }
                }
                else {
                    if ($update) {
                        $this->console($this->lex('user_updated_with_password_unknown', array('username' => $userData['username'])));
                    }
                    else {
                        $this->console($this->lex('user_created_with_password_unknown', array('username' => $userData['username'])));
                    }
                }
            }
        }

        return $response;
    }

    public function validate(&$data, $logToConsole = false, $line = 0) {
        global $modx;

        // reset script time out
        $max_execution_time = ini_get('max_execution_time') ? ini_get('max_execution_time') : 30;
        set_time_limit($max_execution_time);
            
        // trim whitespace from all values
        foreach ($data as $k => $v) {
            if (is_string($data[$k])) {
                $data[$k] = trim($data[$k]);
            }
        }
        // username is required, can't coantain illegal characters
        $username = $data['username'];
        if (empty($username)) {
            $this->addError(array('csv-file'),'err_field_username_ns', $logToConsole, $line);
        } 
        elseif (!preg_match('/^[^\'\\x3c\\x3e\\(\\);\\x22]+$/', $username)) {
            $this->addError(array('csv-file'),'err_field_username_invalid', $logToConsole, $line, array(
                'field' => $username
            ));
        }
        elseif (!empty($username)) {
            // if update Existing is off, the username not be already taken
            if (empty($data['overwriteexisting'])) {
                if ($this->modx->getCount('modUser',array( 'username' => $username ))) {
                    $this->addError(array('csv-file'),'err_field_username_ae', $logToConsole, $line, array(
                        'field' => $username
                    ));
                }
            }
        }

        if (!empty($data['password'])) {
            $password = $data['password'];
            $minLength = $modx->getOption('password_min_length',null,6);
            if (strlen($password) < $minLength) {
                $this->addError(array('csv-file'),'err_field_password_too_short', $logToConsole, $line, array(
                    'field' => $password,
                    'min'   => $minLength
                ));
            }
            if (!preg_match('/^[^\'\\x3c\\x3e\\(\\);\\x22]+$/', $password)) {
                $this->addError(array('csv-file'),'err_field_password_invalid', $logToConsole, $line, array(
                    'field' => $password
                ));
            }
        }



        // groups must be in the right format
        // comma separated list of name:role:rank
        if (!empty($data['groups'])) {
            $groups = array();
            
            $groupMemberships = preg_split('/\s*,\s*/', $data['groups']);

            foreach ($groupMemberships as $groupMembership) {
                $parts = preg_split('/\s*:\s*/', $groupMembership);

                $name = empty($parts[0])? '' : $parts[0];
                $role = empty($parts[1])? '' : $parts[1];
                $rank = empty($parts[2])? '' : $parts[2];

                $groupId = null;
                $roleId = null;

                if (empty($name)) {
                    $this->addError(array('csv-file'),'err_field_group_name_ns', $logToConsole, $line, array(
                        'groups' => $groupMembership,
                    ));
                }
                else {
                    $groupObj = $modx->getObject('modUserGroup', array('name' => $name));
                    if (!empty($groupObj)) {
                        $groupId = $groupObj->get('id');
                    }
                    else {
                    
                        $this->addError(array('csv-file'),'err_field_group_name_nf', $logToConsole, $line, array(
                            'name'   => $name,
                            'groups' => $groupMembership,
                        ));
                    }
                }
                
                if (empty($role)) {
                    $role = 'Member';
                }

                $roleObj = $modx->getObject('modUserGroupRole', array('name' => $role));
                if (!empty($roleObj)) {
                    $roleId = $roleObj->get('id');
                }
                else {
                    $this->addError(array('csv-file'),'err_field_group_role_nf', $logToConsole, $line, array(
                        'role'   => $role,
                        'groups' => $groupMembership,
                    ));
                }

                if (!empty($rank) && !preg_match('/^\d+$/', $rank)) {
                    $this->addError(array('csv-file'),'err_field_group_rank_invalid', $logToConsole, $line, array(
                        'groups' => $groupMembership,
                        'rank'   => $rank,
                    ));
                }
                $groups[] = array(
                    'usergroup'   => $groupId,
                    'name'        => $name,
                    'role'        => $roleId,
                    'rank'        => $rank    ? $rank : 0,
                );
            }
            
            // the create user processor will accept group data as a JSON string or as an array of membership hashes as we've made
            $data['groups'] = $groups;  
        }
        else {
            // the create user processor needs an array, even a blank one.  It will not accept a null or an empty string
            $data['groups'] = array();  
        }
        
        if (empty($data['email'])) {
            $this->addError(array('csv-file'),'err_field_email_ns', $logToConsole, $line);
        }

        if (!empty($data['email'])) {
            if (!$this->modx->getOption('allow_multiple_emails',null,true)) {
                if (!empty($this->seenEmailAddress[$data['email']])) {
                    $this->addError(array('csv-file'),'err_field_email_duplicate_in_csv_file', $logToConsole, $line, array(
                        'field' => $data['email'],
                        'line' => $this->seenEmailAddress[$data['email']],
                    ));
                }
                $emailExists = $this->modx->getObject('modUserProfile',array('email' => $data['email']));
                if ($emailExists) {
                    $this->addError(array('csv-file'),'err_field_email_already_exists', $logToConsole, $line, array(
                        'field' => $data['email']
                    ));
                }
                $this->seenEmailAddress[$data['email']] = $line;
            }
        }
        
        $booleanFields = array(
            'active',
            'blocked'
        );

        foreach ($booleanFields as $booleanFieldName) {
            if (!empty($data[$booleanFieldName])) {
                $booleanFieldValue = $data[$booleanFieldName];
                if ( $booleanFieldValue != '' && $booleanFieldValue != 0 && $booleanFieldValue != 1) {
                    $this->addError(array('csv-file'),'err_field_'.$booleanFieldName.'_invalid', $logToConsole, $line, array(
                        'field' => $booleanFieldValue
                    ));
                }
            }
        }

        // all date fields must be valid and parsable
        // the modx user processor requires that they are in the format of mm/dd/yyyy

        // we validate dates but we don't store the values; the create processor will do that

        $dateFields = array(
            'blockeduntil',
            'blockedafter',
            'dob'
        );

        foreach ($dateFields as $dateFieldName) {
            if (!empty($data[$dateFieldName])) {
                $dateFieldValue = $data[$dateFieldName];
                if (!empty($dateFieldValue)) {
                    if (!strtotime($dateFieldValue)) {
                        $this->addError(array('csv-file'),'err_field_'.$dateFieldName.'_invalid', $logToConsole, $line, array(
                            'field' => $dateFieldValue
                        ));
                    }        
                }
            }
        }


        // gender must be M or F
        if (!empty($data['gender'])) {
            $gender = strtolower($data['gender']);
            if ($gender == 'm') {
                $data['gender'] = 1;
            }
            elseif ($gender == 'f') {
                $data['gender'] = 2;
            }
            else {
                $this->addError(array('csv-file'),'err_field_gender_invalid', $logToConsole, $line, array(
                    'field' => $data['gender']
                ));
            }
        }

        // extended must be valid jason
        if (!empty($data['extended'])) {
            $extended = json_decode($data['extended']);
            if (json_last_error() != JSON_ERROR_NONE) {
                $this->addError(array('csv-file'),'err_field_extended_invalid_json', $logToConsole, $line);
            }
        }
        
        return $data;

    }

    public function exportUsers() {
        global $modx;
        
        $filename = 'Users-' . date('Y-m-d') . '.csv';

        header( 'Content-Type: text/csv' );
        header( 'Content-Disposition: attachment;filename='.$filename);
        $fp = fopen('php://output', 'w');

        $csvFields = array_merge(
            $this->csvUserFields,
            $this->csvProfileFields,
            $this->csvOtherFields
        );

        fputcsv ($fp, $csvFields);

        $users = $modx->getCollection('modUser');

        foreach ($users as $user) {
            $row = array();
            foreach ($this->csvUserFields as $key) {
                $row[] = $user->get($key);
            }
            $profile = $user->getOne('Profile');
            foreach ($this->csvProfileFields as $key) {
                $value = $profile->get($key);
                if ($key === 'blockeduntil' || $key === 'blockedafter' || $key === 'dob') {
                    if ($value) {
                        $value = date('m/d/Y', $value);
                    }
                    else {
                        $value = '';
                    }
                }
                elseif ($key === 'gender') {
                    if ($value == 1) {
                        $value = 'M';
                    }
                    elseif ($value == 2) {
                        $value = 'F';
                    }
                    else {
                        $value = '';
                    }
                }
                elseif ($key === 'extended') {
                    $value = json_encode($value);
                    if ($value === 'null' || $value === '[]') {
                        $value = '';
                    }
                }
                $row[] = $value;
            }

            
            $row[] = $this->groupMembershipString($user);
            fputcsv ($fp, $row);
        }

        fclose($fp);

    }
    public function groupMembershipString($user) {
        global $modx;
        $groupMembers = $user->getMany('UserGroupMembers');

        $memberships = array();

        foreach ($groupMembers as $groupMember) {
            $role          = $groupMember->getOne('UserGroupRole');
            $roleName      = $role->get('name');
            $userGroup     = $groupMember->getOne('UserGroup');
            $userGroupName = $userGroup->get('name');
            $rank          = $groupMember->get('rank');
            $memberships[] = implode(':', array($userGroupName, $roleName, $rank));
        }

        return implode(',', $memberships);
    }


    public function help() {
        global $modx;
        $lang = $modx->lexicon->fetch();
        
        $prefix         = 'importusers.help_field_';
        $helpRows       = '';
        $settingRows    = '';

        $settings = array(
            'setting_allow_multiple_emails',     
            'setting_password_min_length',       
            'setting_password_generated_length', 
            'setting_signupemail_message',       
        );

        $count = 0;
        foreach ($settings as $setting) {
            $settingsRows = $settingsRows . $modx->getChunk($this->config['settings_table_row_chunk'], array(
                'setting'  => $this->lex('import_' . $setting),
                'value'    => $this->config[$setting],
                'rowClass' => $count++ % 2 ?  'even' : 'odd'
            ));
        }
        

        $count = 0;
        foreach ($lang as $key => $value) {
            if (preg_match("/^{$prefix}(.*)$/", $key, $matches)) {
                $field = $matches[1];
                $helpRows = $helpRows . $modx->getChunk($this->config['help_table_row_chunk'], array(
                    'field'     => $field,
                    'note'      => $value,
                    'rowClass'  => $count++ % 2 ?  'even' : 'odd'
                ));
            }
        }

        $out = $modx->getChunk($this->config['help_table_chunk'], array(
            'exportUrl'     => $this->config['exportUrl'],
            'settingsRows'  => $settingsRows,
            'helpRows'      => $helpRows,
        ));

        return $out;

    }


    
    public function lex($message, $data = array()) {
        global $modx;
        return $modx->lexicon($this->lexPrefix . '.' . $message, $data);
    }
    

    public function console($message, $level = 'info') {
        global $modx;
        switch ($level) {
            case 'info': 
                $modx->log(modX::LOG_LEVEL_INFO, $message);
            
            break;

            case 'warn': 
                $modx->log(modX::LOG_LEVEL_WARN, $message);
            
            break;

            case 'error': 
                $modx->log(modX::LOG_LEVEL_ERROR, $message);
            break;


        }
    }
    public function fatal($message) {
        global $modx;
        sleep(1);
        $this->console($message,'error');
        sleep(2);
        $this->console('COMPLETED');
        sleep(1);
        return $modx->error->failure($message);
    }
    public function success($message) {
        global $modx;
        sleep(1);
        $this->console($message);
        $this->console('COMPLETED');
        sleep(1);
        return $modx->error->success($message);
    }

    public function addError ($fields, $lexKey, $logToConsole = false, $line = 0, $lexData = array(), $level = 'error') {
        global $modx;
        
        
        if ($line > 0) {
            $message = $this->lex('import_line_number') . " $line: " . $this->lex($lexKey, $lexData);
        }
        else {
            $message = $this->lex($lexKey, $lexData);
        }

        foreach ($fields as $field) {
            $modx->error->addField($field,$message);
        }
        
        if ($logToConsole) {
            $this->console($message, $level);
        }
    }

} 


