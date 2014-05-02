valid_script = true;  
ajax_url = 'ajax.handler.php?id=' + page;  

function reportSelect(bt){
  dynamic_grid_comunidad.getTopToolbar().get(8).setText(bt.text); 
  dynamic_grid_comunidad.getTopToolbar().get(8).mode = bt.mode;   
}

var dynamic_grid_comunidad = new Ext.ux.PhpDynamicGridPanel({
    border:false,
    remoteSort:true, //optional default true
    autoLoadStore:true, //optional default true
    storeUrl:ajax_url,
    sortInfo:{field:'nombre',direction:'ASC'}, //must declaration
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
        options = dynamic_grid_comunidad.getParamsFilter();
        report_link = 'report.php?id=' + page;
        options = Ext.apply(options,{mode:this.mode}); 
        winReport({
            id : this.id_comunidad,
            title : 'Lista Comunidades',
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
      win_comunidad.get(0).getForm().reset();
      win_comunidad.setTitle('Agregar'); 
      win_comunidad.show(bt.id_comunidad); 
    },
    onEditData:function(bt,rec){
      win_comunidad.setTitle('Editar');
      win_comunidad.show(bt.id_comunidad); 
      win_comunidad.get(0).getForm().load({
          waitMsg:'Loading Data..',
          params:{action:'edit',id_comunidad:rec.data.id_comunidad}
      }); 
    },
    onRemoveData:function(bt,rec){
      data = []; 
      Ext.each(rec,function(r){
        data.push(r.data.id_comunidad); 
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
win_comunidad = new Ext.Window({
  id:'win-comunidad',
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
    {xtype:'hidden', name:'id_comunidad'},
    {xtype:'textfield',name:'nombre',fieldLabel:'Nombre',allowBlank:false},
    {xtype:'textfield',name:'ref',fieldLabel:'REF nacimiento',allowBlank:false},
    {xtype:'datefield',name:'desde',fieldLabel:'Desde',format:'d/m/Y'},
    {xtype:'datefield',name:'hasta',fieldLabel:'Hasta',format:'d/m/Y'},
    {xtype:'numberfield',name:'fusion',fieldLabel:'Fusion'}
    ]
  }], 
  buttons:[
  {
    text:'Guardar',
    handler:function(){
      if(!win_comunidad.get(0).getForm().isValid()){
        Ext.example.msg('Advertencia','Hay datos vacios'); 
        return false; 
      }
      
      id_data = win_comunidad.get(0).getForm().getValues().id_comunidad; 
      action = (id_data?'update':'create'); 
      win_comunidad.get(0).getForm().submit({
          params:{action:action},
          waitMsg : 'Guardando datos',
          success:function(){
            win_comunidad.hide();
            Ext.example.msg('Gardar','Los datos han sido gardados'); 
            dynamic_grid_comunidad.store.reload(); 
          },
          failure:function(){
            Ext.MessageBox.alert('Advertencia','Los datos no se pudieron guardar!!'); 
          }
      }); 
      
    }
  },{
    text:'Close',
    handler:function(){
      win_comunidad.hide(); 
    }
  }
  ]
}); 

/**end of form**/


var main_content = {
  id : id_panel,  
  title:n.text,  
  iconCls:n.attributes.iconCls,  
  items : [dynamic_grid_comunidad],
  listeners:{
    destroy:function(){
      my_win = Ext.getCmp('win-comunidad');
      if (my_win)
          my_win.destroy(); 
    }
  }
}; 
