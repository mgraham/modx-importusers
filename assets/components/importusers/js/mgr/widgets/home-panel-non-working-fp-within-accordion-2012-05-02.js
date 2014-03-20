
var topic    = '/import-users/'; 
var register = 'mgr';
var app      = ImportUsers;
var app_lex  = 'importusers.';

function export_csv(form) {
    
    // when using standardSubmit, must manually set <form action="...">
    formAsDom = form.getEl().dom;

    console.log("ac %o", formAsDom.action);
    formAsDom.setAttribute("action", form.url);
    
    // when using standardSubmit, form does not accept params
    formAsDom.submit();
}

function start_import_csv(form) {
    
    if (!form.isValid()) {
        return;
    }

    // there is no validation-only first pass.  Validation errors that sneak 
    // past client-side validation will just be reported as errors in the console

    // Uncommenting the alert() below will allow you to start your debugger right before the form submission
    // 
    // Note that I'm submitting the form before creating the console window because if I don't then
    // most of the time the debugger catches one of the console update requests instead of the main
    // form submit request
    //
    // alert ('starting import');
    
    if (app.consoleWin == null || app.consoleWin == undefined) {
        app.consoleWin = MODx.load({
           xtype: 'modx-console'
           ,register: register
           ,topic: topic
           ,show_filename: 0
        });
    } else {
        app.consoleWin.setRegister(register, topic);
    }
    app.consoleWin.show(Ext.getBody());
    
    form.submit({
        success: function() {
            app.consoleWin.fireEvent('complete');
        }
        ,failure: function() {
            // if there were any error messages, they should be in the console
            app.consoleWin.fireEvent('complete');
        }
    });
}


app.panel.UploadForm = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'import-users-upload-form'
        ,xtype: 'import-users-upload-form'
        ,fileUpload: true
        ,baseParams: {
            register: register 
            ,topic:    topic 
            ,action:   'mgr/importusers/importusers'
        }
        ,title: _(app_lex + 'import_panel_title')
        ,layout: 'form'
        ,border: false
        ,items: [
            {
                html: '<p>'+_(app_lex + 'import_panel_description')+'</p>'
                ,border: false
            }
            ,{
                xtype: 'textfield'
                ,inputType: 'file'
                ,fieldLabel: _(app_lex + 'import_upload_csv_file')
                ,name: 'csv-file'
                ,id: 'csv-file'
                ,allowBlank: false
                ,width: 300
                ,labelSeparator: ''
                ,anchor: '100%'
            }
           ,{
               xtype: 'checkbox'
               ,fieldLabel: _(app_lex + 'import_checkbox_overwrite_existing')
               ,name: 'overwriteexisting'
               ,id: 'overwriteexisting'
               ,width: 300
               ,labelSeparator: ''
               ,anchor: '100%'
           }
           ,MODx.PanelSpacer
           ,{
               xtype: 'checkbox'
               ,fieldLabel: _(app_lex + 'import_checkbox_send_notifications')
               ,name: 'sendnotification'
               ,id: 'sendnotification'
               ,width: 300
               ,labelSeparator: ''
               ,anchor: '100%'
           }
           ,{
               xtype: 'button'
               ,text: _(app_lex + 'import_upload_csv_import_button_text') 
               ,name: 'import-button'
               ,id:   'import-button'
               ,scope: this
               ,handler: function() {
                   var form = this.getForm();
                   console.log("app.panel.Home %o: " , app.panel.Home);
                   console.log("this %o: " , this);
                   console.log("form %o: " , form);
                   start_import_csv(form);
               }
           }
        ]
    });
    app.panel.UploadForm.superclass.constructor.call(this,config);
};
// Ext.extend(app.panel.UploadForm,MODx.FormPanel);

// alert('h0');
app.panel.DownloadForm = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'import-users-download-form'
        // ,standardSubmit: true
        // ,title: _(app_lex + 'export_panel_title')
        // ,layout: 'form'
        ,header: false
        ,border: false
        ,items: [
           //  {
           //      html: '<p>'+_(app_lex + 'export_panel_description')+'</p>'
           //      ,border: false
           //  }
           // ,{
           //     xtype: 'button'
           //     ,text: _(app_lex + 'import_upload_csv_export_button_text') 
           //     ,name: 'export-button'
           //     ,id:   'export-button'
           //     ,scope: this
           //     ,handler: function() {
           //         var form = this.getForm();
           //         export_csv(form);
           //     }
           // }
           // ,{
           //     // anti-CSF token which is necessary to allow posting to the connector
           //     xtype:  'hidden'
           //     ,id:    'import-users-HTTP_MODAUTH'
           //     ,name:  'HTTP_MODAUTH'
           //     ,value: MODx.siteId
           // }
           // ,{
           //     // action so that the connector knows how to dispatch
           //     xtype:  'hidden'
           //     ,name:  'action'
           //     ,id:    'import-users-action'
           //     ,value: 'mgr/importusers/exportusers'
           // }
        ]
    });
    // alert('h1');
    app.panel.DownloadForm.superclass.constructor.call(this,config);
    // alert('h2');
}
// alert('h3');
Ext.extend(app.panel.DownloadForm,MODx.FormPanel);
// alert('h4');
Ext.reg('import-users-download-form',app.panel.DownloadForm);
// alert('h5');



app.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'import-users-panel-container'
        ,url: app.config.connectorUrl 
        ,fileUpload: true
        ,baseParams: {
            register: register 
            ,topic:    topic 
        }
        ,items: [
            {
                html: '<h2>'+_(app_lex + 'title_import_export_users')+'</h2>'
                ,id: 'import-users-header'
                ,cls: 'modx-page-header'
                ,border: false
                ,anchor: '100%'
            }
            ,{
                html: '<p>'+_(app_lex + 'panel_description')+'</p>'
                                ,bodyCssClass: 'panel-desc'
            }
            ,{
                id: 'import-users-panel-accordion'
                ,layout: 'accordion'
                ,defaults: {
                    bodyStyle: 'padding:15px'
                }
                ,layoutConfig: {
                    titleCollapse: true
                    ,animate: true
                    ,activeOnTop: false
                    ,fill: false
                }
                ,items: [
                    {
                        title: 'za'
                        ,html: 'woo'
                    }
                    // {
                    //     xtype: 'import-users-upload-form'
                    // }
                    // ,{
                    //     xtype: 'import-users-download-form'
                    // }
                ]
            }
        ]
    });
    // alert('h6');
    app.panel.Home.superclass.constructor.call(this,config);
    // alert('h7');
};
// alert('h8');



Ext.extend(app.panel.Home,MODx.Panel);
// alert('h9');
// Ext.extend(app.panel.ExportForm,MODx.FormPanel);
// Ext.extend(ExportForm,MODx.FormPanel);
// Ext.extend(Ext.getCmp('upload-form'),MODx.FormPanel);
// app.panel.Home.add('csv-file');
// app.panel.Home.add('overwriteexisting');
// app.panel.Home.add('sendnotification');

Ext.reg('importusers-panel-home',app.panel.Home);


