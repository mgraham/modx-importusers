
var topic    = '/itmg-territory-search/'; 
var register = 'mgr';
var app      = ImportUsers;
var app_lex  = 'importusers.';

function help_table_rows(prefix) {
    var html = '';

    var matcher = new RegExp('^' + prefix + '_' + '(.*)$');

    for (var k in MODx.lang) {
        var matches = matcher.exec(k);
        if (matches) {
            field = matches[1];
            note  = MODx.lang[k];
            
            line = '<tr><td>' + field + '</td><td>' + note + '</td></tr>';
            html = html + line;

        }
    }
    return html;
}


app.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+_('importusers.desc')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        }
        // ,{
        //     xtype: 'modx-tabs'
        //     ,bodyStyle: 'padding: 10px'
        //     ,defaults: { border: false ,autoHeight: true }
        //     ,border: true
            // ,items: [
            //     {
            //         title: _('importusers.import_tab_name')
            //         ,defaults: { autoHeight: true }
                    // ,items: 

                    // [

                        ,{
                            // title: _(app_lex + 'import_title')
                            url: app.config.connectorUrl
                            ,fileUpload: true
                            ,baseParams: {
                                action:         'mgr/importusers/importusers'
                                ,objtype:       'importusers'
                                ,register:      register 
                                ,topic:         topic 
                            }
                            ,fields: [
                                ,{
                                    xtype: 'textfield'
                                    ,inputType: 'file'
                                    ,fieldLabel: _(app_lex + 'import_upload_csv_file')
                                    ,name: 'csv-file'
                                    ,allowBlank: false
                                    ,width: 300
                                }
                            ]
                            ,buttons: [{
                                text: _(app_lex + 'import_upload_csv_import_button_text') 
                                ,process: 'import' 
                                ,scope: this
                                
                                ,handler: function() {

                                    var form = this.fp.getForm();
                                    if (!form.isValid()) {
                                        return;
                                    }

                                    // there is no validation-only first pass.  Validation errors that sneak 
                                    // past client-side validation will just be reported as errors in the console
                                    

                                    // alert ('starting import');
                                    if (app.consoleWin == null || app.consoleWin == undefined) {
                                        app.consoleWin = MODx.load({
                                           xtype: 'modx-console'
                                           ,register: register
                                           ,topic: topic
                                           ,show_filename: 0
                                           ,listeners: {
                                             'shutdown': {
                                                 fn:function() {
                                                    Ext.getCmp('modx-layout').refreshTrees();
                                                    Ext.getCmp(obj_prefix + '-regions-grid').refresh();
                                                 }
                                                 ,scope:this
                                             }
                                           }
                                        });
                                    } else {
                                        app.consoleWin.setRegister(register, topic);
                                    }
                                    app.consoleWin.show(Ext.getBody());

                                    form.submit({
                                        success: {
                                            fn:function() {
                                                app.consoleWin.fireEvent('complete');
                                                app.grid.reload();
                                            }
                                            ,scope:this
                                        },
                                        failure: {
                                            fn: function() {
                                                // error messages (if any) should be in the console
                                                app.consoleWin.fireEvent('complete');
                                                app.this.grid.reload();
                                            }
                                            ,scope:this
                                        }
                                    });

                                    this.hide();
                                }
                            }]

                        }
                        ,{
                           html: '<p>'+
                                _('importusers.panel_description')+
                                '</p><br />'+
                                '<table>'+
                                '<tr><th>'+ _(app_lex + 'help_field') + '</th>'+
                                '<th>'+ _(app_lex + 'help_note') + '</th>'+
                                help_table_rows(app_lex + 'help_field')
                           ,border: false
                        }
                    // ]
            //     }
            ]
        // }
        // ]
    });
    app.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(app.panel.Home,MODx.Panel);
Ext.reg('importusers-panel-home',app.panel.Home);

