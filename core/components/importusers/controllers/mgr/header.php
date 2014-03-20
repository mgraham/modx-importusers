<?php 
$modx->regClientStartupScript($app->config['jsUrl'].'mgr/importusers.js'); 
$modx->regClientStartupHTMLBlock('<script type="text/javascript"> 
Ext.onReady(function() { 
    ImportUsers.config = '.$modx->toJSON($app->config).'; 
}); 
</script>'); 
return ''; 
