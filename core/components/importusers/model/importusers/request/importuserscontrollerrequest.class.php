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


require_once MODX_CORE_PATH . 'model/modx/modrequest.class.php'; 
class ImportUsersControllerRequest extends modRequest { 
    public $app = null; 
    public $actionVar = 'action'; 
    public $defaultAction = 'index'; 
  
    function __construct(ImportUsersApp &$app) { 
        parent :: __construct($app->modx); 
        $this->app =& $app; 
    } 
  
    public function handleRequest() { 
        $this->loadErrorHandler(); 
  
        /* save page to manager object. allow custom actionVar choice for extending classes. */
        $this->action = isset($_REQUEST[$this->actionVar]) ? $_REQUEST[$this->actionVar] : $this->defaultAction; 
  
        $modx =& $this->modx; 
        $app =& $this->app; 
        $viewHeader = include $this->app->config['corePath'].'controllers/mgr/header.php'; 
  
        $f = $this->app->config['corePath'].'controllers/mgr/'.$this->action.'.php'; 
        if (file_exists($f)) { 
            $viewOutput = include $f; 
        } else { 
            $viewOutput = 'Controller not found: '.$f; 
        } 
  
        return $viewHeader.$viewOutput; 
    } 
}
