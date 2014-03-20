
var topic    = '/import-users/'; 
var register = 'mgr';
var app      = ImportUsers;
var app_lex  = 'importusers.';



function start_import_csv(form, url) {
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
    // alert ('url: ' + url);
    alert ('form: ' + form.id);
    alert ('form: ' + Ext.getDom(form.id));
    alert ('form: ' + Ext.getDom(form.id).fields.get('overwriteexisting').value);
    form.submit({
        success: function() {
            app.consoleWin.fireEvent('complete');
        }
        ,failure: function() {
            // if there were any error messages, they should be in the console
            app.consoleWin.fireEvent('complete');
        }
    });
    
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
}

// ACCORDION
app.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'import-users-panel-container'
        ,url: app.config.connectorUrl 
        ,baseParams: {
            action:    'mgr/importusers/importusers'
        }
        ,layout: 'fit'
        ,items: [
            {
                html: '<h2>'+_('importusers.title_import_export_users')+'</h2>'
                ,id: 'import-users-header'
                ,cls: 'modx-page-header'
                ,border: false
                ,anchor: '100%'
            }
            ,{
                html: '<p>'+_('importusers.panel_description')+'</p>'
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
                        title: 'Import Users'
                        ,id: 'import-users-panel-upload-form'
                        ,border: false
                        ,items: [
                            {
                                border: true
                                ,labelWidth: 250
                                ,width: '100%'
                                ,autoHeight: true
                                ,buttonAlign: 'center'
                                ,items: [
                                    {
                                        xtype: 'form'
                                        ,layout: 'form'
                                        ,border: false
                                        ,fileUpload: true
                                        ,baseCls: 'modx-formpanel'
                                        ,cls:'main-wrapper'
                                        ,items: [
                                            {
                                                xtype: 'textfield'
                                                ,inputType: 'file'
                                                ,fieldLabel: _(app_lex + 'import_upload_csv_file')
                                                ,name: 'csv-file'
                                                ,allowBlank: false
                                                ,width: 300
                                                ,labelSeparator: ''
                                                ,anchor: '100%'
                                            }
                                            ,{
                                                xtype: 'checkbox'
                                                ,fieldLabel: _(app_lex + 'import_checkbox_overwrite_existing')
                                                ,name: 'overwriteexisting'
                                                ,width: 300
                                                ,labelSeparator: ''
                                                ,anchor: '100%'
                                            }
                                            ,MODx.PanelSpacer
                                            ,{
                                                xtype: 'checkbox'
                                                ,fieldLabel: _(app_lex + 'import_checkbox_send_notifications')
                                                ,name: 'sendnotification'
                                                ,width: 300
                                                ,labelSeparator: ''
                                                ,anchor: '100%'
                                            }
                                            ,MODx.PanelSpacer
                                            ,{
                                                xtype: 'button',
                                                text: _(app_lex + 'import_upload_csv_import_button_text') 
                                                ,process: 'import' 
                                                ,scope: this
                                                ,handler: function() {
                                                    var form = this.getForm();
                                                    start_import_csv(form, app.config.connectorUrl); 
                                                }
                                            }
                                            ,MODx.PanelSpacer
                                        ]
                                    }
                                ]
                            }
                        ]   
                    }
                    ,{
                        title: 'Help'
                        ,html: Ext.getDom('importusers-help').innerHTML
                        ,border: false
                    }
                ]
            }        
        ]
    });
    app.panel.Home.superclass.constructor.call(this,config);
};



// NO ACCORDION
app.panel.Home2 = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'import-users-panel'
        ,baseParams: {
            objtype:       'importusers'
            ,action:         'mgr/importusers/importusers'
            ,register:      register 
            ,topic:         topic 
        }

        ,url: app.config.connectorUrl
        ,fileUpload: true
        ,border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+_('importusers.desc')+'</h2>'
            ,id: 'import-users-header'
            ,cls: 'modx-page-header'
            ,border: false
            ,anchor: '100%'
        }
        ,{
            border: true
            // ,layout: 'form'
            // ,xtype: 'form'
            ,labelWidth: 250
            ,width: '100%'
            ,autoHeight: true
            ,buttonAlign: 'center'
            ,items: [{
                    html: '<p>'+_('importusers.panel_description')+'</p>'
                                    ,bodyCssClass: 'panel-desc'
                }
                ,{
                    xtype: 'panel'
                    ,border: false
                    ,cls:'main-wrapper'
                    ,layout: 'form'
                    ,items: [
                        {
                            xtype: 'textfield'
                            ,inputType: 'file'
                            ,fieldLabel: _(app_lex + 'import_upload_csv_file')
                            ,name: 'csv-file'
                            ,allowBlank: false
                            ,width: 300
                            ,labelSeparator: ''
                            ,anchor: '100%'
                        }
                        ,{
                            xtype: 'checkbox'
                            ,fieldLabel: _(app_lex + 'import_checkbox_overwrite_existing')
                            ,name: 'overwriteexisting'
                            ,width: 300
                            ,labelSeparator: ''
                            ,anchor: '100%'
                        }
                        ,MODx.PanelSpacer
                        ,{
                            xtype: 'checkbox'
                            ,fieldLabel: _(app_lex + 'import_checkbox_send_notifications')
                            ,name: 'sendnotification'
                            ,width: 300
                            ,labelSeparator: ''
                            ,anchor: '100%'
                        }
                        ,MODx.PanelSpacer
                        ,{
                            xtype: 'button',
                            text: _(app_lex + 'import_upload_csv_import_button_text') 
                            ,process: 'import' 
                            ,scope: this
                            ,handler: function() {
                                var form = this.getForm();
                                start_import_csv(form); 

                            }
                        }
                        ,MODx.PanelSpacer
                        ,{
                            // html: '<p>'+
                            //      _('importusers.import_settings_description')+
                            //      '</p><br />'+
                            //      '<table class="import-users-help">'+
                            //      '<tr><th>'+ _(app_lex + 'setting') + '</th>'+
                            //      '<th>'+ _(app_lex + 'value') + '</th>'+
                            //      settings_table_rows(app_lex)
                            html: Ext.getDom('importusers-help').innerHTML
                            ,border: false
                        }
                    ]
                }
            ]
        }]   
    });
    app.panel.Home.superclass.constructor.call(this,config);
};

// MINIMALIST ACCORDION
app.panel.Home3 = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'mycomponent-panel-container'
        ,layout: 'fit'
        ,items: [
            {
                html: '<h2>Some title</h2>'
                ,id: 'mycomponent-header'
                ,cls: 'modx-page-header'
                ,border: false
                // ,anchor: '100%'
            }
            ,{
                html: '<p>Description of my component</p>'
                ,bodyCssClass: 'panel-desc'
            }
            ,{
                id: 'mycomponent-panel-accordion'
                ,title: 'The Accordion'
                ,layout: 'accordion'
                ,defaults: {
                    bodyStyle: 'padding:15px'
                }
                ,layoutConfig: {
                    titleCollapse: false
                    ,animate: false
                    ,activeOnTop: false
                    ,collapseFirst: true
                    ,fill: false
                    ,hideCollapseTool: true
                    ,titleCollapse: true
                }
                ,items: [
                    {
                        title: 'Help'
                        ,border: false
                        ,html: 'Some long <br />long<br />long<br />long<br />long<br />long<br />long<br />long<br />long<br />long<br />HTML'
                    }
                    ,{
                        title: 'Help'
                        ,border: false
                        ,html: 'Some long <br />long<br />long<br />long<br />long<br />long<br />long<br />long<br />long<br />long<br />HTML'
                    }
                ]
            }        
        ]
    });
    app.panel.Home.superclass.constructor.call(this,config);
};

Ext.extend(app.panel.Home,MODx.FormPanel);
// Ext.reg('mycomponent-panel-home',app.panel.Home);
Ext.reg('importusers-panel-home',app.panel.Home);

