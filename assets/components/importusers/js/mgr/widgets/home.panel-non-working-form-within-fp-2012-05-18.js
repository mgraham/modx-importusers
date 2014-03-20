
ImportUsers.panel.SampleForm = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'my-sample-form'
        ,header: false
        ,border: false
        ,items: [
           {
               xtype: 'button'
               ,text: 'button'
               ,name: 'export-button'
               ,id:   'export-button'
               ,scope: this
               ,handler: function() {
                   alert('hello');
               }
           }
        ]
    });
    ImportUsers.panel.SampleForm.superclass.constructor.call(this,config);
}
Ext.extend(ImportUsers.panel.SampleForm,MODx.FormPanel);
Ext.reg('my-sample-form',ImportUsers.panel.SampleForm);


ImportUsers.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'import-users-panel-container'
        ,items: [
            {
                html: '<h2>Heading</h2>'
                ,id: 'import-users-header'
                ,cls: 'modx-page-header'
            }
            ,{
                id: 'import-users-panel-accordion'
                ,layout: 'accordion'
                ,items: [
                    {
                        xtype: 'my-sample-form'
                    }
                ]
            }
        ]
    });
    ImportUsers.panel.Home.superclass.constructor.call(this,config);
};


Ext.extend(ImportUsers.panel.Home,MODx.Panel);
Ext.reg('importusers-panel-home',ImportUsers.panel.Home);

