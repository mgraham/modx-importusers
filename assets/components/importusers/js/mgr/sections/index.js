Ext.onReady(function() {
    MODx.load({ xtype: 'importusers-page-home'});
    // MODx.load({ xtype: 'mycomponent-page-home'});
});
 
ImportUsers.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'importusers-panel-home'
            // xtype: 'mycomponent-panel-home'
            ,renderTo: 'importusers-panel-home-div'
        }]
    });
    ImportUsers.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(ImportUsers.page.Home,MODx.Component);
Ext.reg('importusers-page-home',ImportUsers.page.Home);
// Ext.reg('mycomponent-page-home',ImportUsers.page.Home);
