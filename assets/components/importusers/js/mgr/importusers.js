var ImportUsers = function(config) { 
    config = config || {}; 
    ImportUsers.superclass.constructor.call(this,config); 
}; 
Ext.extend(ImportUsers,Ext.Component,{ 
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {} 
}); 
Ext.reg('importusers',ImportUsers); 
ImportUsers = new ImportUsers();
