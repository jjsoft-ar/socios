valid_script = true;  
ajax_url = 'ajax.handler.php?id=' + page;  

function reportSelect(bt){
  dynamic_grid_persona.getTopToolbar().get(8).setText(bt.text); 
  dynamic_grid_persona.getTopToolbar().get(8).mode = bt.mode;   
}

var dynamic_grid_persona = new Ext.ux.PhpDynamicGridPanel({
    border:false,
    remoteSort:true, //optional default true
    autoLoadStore:true, //optional default true
    storeUrl:ajax_url,
    sortInfo:{field:'apellido',direction:'ASC'}, //must declaration
    baseParams:{
      action:'read'
    },
    tbar:[
    '-',{
      text:'Modo de reporte',
      iconCls:'report-mode',
      menu:{
        items:[
        {text:'PDF',mode:'pdf',handler:reportSelect},
        {text:'XLS',mode:'xls',handler:reportSelect}
        ]
      }
    },'-',{
      text:'Imprimir PDF',
      iconCls:'report-mode',
      mode:'pdf',
      handler:function(){
        options = dynamic_grid_persona.getParamsFilter();
        report_link = 'report.php?id=' + page;
        options = Ext.apply(options,{mode:this.mode}); 
        winReport({
            id : this.id_persona,
            title : 'Lista Personas',
            url : report_link,
            type : this.mode,
            params:options        
        }); 
      }
    }
    ],
    tbarDisable:{  //if not declaration default is true
      add:!ROLE.ADD_DATA,
      edit:!ROLE.EDIT_DATA,
      remove:!ROLE.REMOVE_DATA
    },
   
    onAddData:function(bt){
      win_persona.get(0).getForm().reset();
      win_persona.setTitle('Agregar'); 
      win_persona.show(bt.id_persona); 
    },
    onEditData:function(bt,rec){
      win_persona.setTitle('Editar');
      win_persona.show(bt.id_persona); 
      win_persona.get(0).getForm().load({
          waitMsg:'Loading Data..',
          params:{action:'edit',id_persona:rec.data.id_persona}
      }); 
    },
    onRemoveData:function(bt,rec){
      data = []; 
      Ext.each(rec,function(r){
        data.push(r.data.id_persona); 
      }); 
      Ext.Ajax.request({
        url: ajax_url, 
        params:{
          action:'destroy',
          data:data.join(",")
        },
        success:function(){
          this.store.reload(); 
        },
        scope:this
      });       
    }
}); 



/**form edit dan form add **/ 
win_persona = new Ext.Window({
  id:'win-people',
  closeAction:'hide',
  closable:true,
  title:'Agregar',
  height:200,
  border:false,
  width:350,
  modal:true,
  layout:'fit',
  items:[{
    xtype:'form',
    border:false,
    frame:true,
    labelWidth:100,
    waitMsgTarget: true,
    url:ajax_url,
    defaults:{
      anchor:'98%',
      labelSeparator:''
    },
    bodyStyle:{padding:'10px'},
    items:[
    {xtype:'hidden', name:'id_persona'},
    {xtype:'textfield',name:'apellido',fieldLabel:'Apellido',allowBlank:false},
    {xtype:'textfield',name:'nombre',fieldLabel:'Nombre',allowBlank:false},
    {xtype:'textfield',name:'domicilio',fieldLabel:'Domicilio',allowBlank:false},
    {xtype:'datefield',name:'fecha_nacimiento',fieldLabel:'Nacimiento',format:'d/m/Y'},
    {xtype:'numberfield',name:'telefono',fieldLabel:'Telefono'},
    {xtype:'numberfield',name:'celular',fieldLabel:'celular'},
    {xtype:'textfield',name:'email',fieldLabel:'E-mail',allowBlank:false}
    ]
  }], 
  buttons:[
  {
    text:'Save',
    handler:function(){
      if(!win_persona.get(0).getForm().isValid()){
        Ext.example.msg('Advertencia','Hay datos vacios'); 
        return false; 
      }
      
      id_data = win_persona.get(0).getForm().getValues().id_persona; 
      action = (id_data?'update':'create'); 
      win_persona.get(0).getForm().submit({
          params:{action:action},
          waitMsg : 'Guardando datos',
          success:function(){
            win_persona.hide();
            Ext.example.msg('Gardar','Los datos han sido gardados'); 
            dynamic_grid_persona.store.reload(); 
          },
          failure:function(){
            Ext.MessageBox.alert('Advertencia','Los datos no se pudieron guardar!!'); 
          }
      }); 
      
    }
  },{
    text:'Close',
    handler:function(){
      win_persona.hide(); 
    }
  }
  ]
}); 

/**end of form**/


var main_content = {
  id : id_panel,  
  title:n.text,  
  iconCls:n.attributes.iconCls,  
  items : [dynamic_grid_persona],
  listeners:{
    destroy:function(){
      my_win = Ext.getCmp('win-people');
      if (my_win)
          my_win.destroy(); 
    }
  }
}; 
