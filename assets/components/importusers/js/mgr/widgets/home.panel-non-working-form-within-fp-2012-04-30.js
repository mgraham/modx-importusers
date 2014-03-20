
var topic    = '/import-users/'; 
var register = 'mgr';
var app      = ImportUsers;
var app_lex  = 'importusers.';



function start_import_csv(form, url) {
    alert ('hello');
    // if (!form.isValid()) {
    //     return;
    // }

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
    // alert ('value: ' + Ext.getCmp('overwriteexisting').getValue());
    // alert ('form: ' + form.id);
    console.log('form.id: %o',  form.id);
    console.log('form.fields: %o', form.fields);
    // alert ('form: ' + Ext.getDom(form.id));
    // alert ('form: ' + Ext.getDom(form.id).fields.get('overwriteexisting').value);
    console.log("object: %o", form.getValues());
    // return;
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
                                        id: 'the-real-form'
                                        ,xtype: 'modx-formpanel'
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
                                                ,name: 'csvfile'
                                                ,id: 'csvfile'
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
                                            ,MODx.PanelSpacer
                                            ,{
                                                xtype: 'button',
                                                text: _(app_lex + 'import_upload_csv_import_button_text') 
                                                ,process: 'import' 
                                                ,scope: this
                                                ,handler: function() {
                                                    var form = this.getForm();

                                                    // there's a problem with Ext forms - elements that are not immediate children of the form
                                                    // are ignored by the form:
                                                    //
                                                    //    http://www.sencha.com/forum/showthread.php?41093-New-template-method-for-the-Container-architecture.
                                                    //
                                                    // To work around this, this submit method adds the children
                                                    // back to their own form. Yuck.
                                                    
                                                    form = Ext.getCmp('the-real-form');
                                                    console.log("the-real-form: %o", Ext.getCmp('the-real-form'));
                                                    // console.log("csvfile: %o", Ext.getCmp('csvfile'));
                                                    // console.log("overwriteexiting: %o", Ext.getCmp('overwriteexisting'));
                                                    console.log("this.form: %o", form);
                                                    // form.add(Ext.getCmp('csvfile'));
                                                    // form.add(Ext.getCmp('overwriteexisting'));
                                                    // form.add(Ext.getCmp('sendnotification'));
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



Ext.extend(app.panel.Home,MODx.FormPanel);
// Ext.extend(Ext.getCmp('the-real-form'),MODx.FormPanel);
// app.panel.Home.add('csv-file');
// app.panel.Home.add('overwriteexisting');
// app.panel.Home.add('sendnotification');

Ext.reg('importusers-panel-home',app.panel.Home);

