valid_script = true;  
ajax_url = 'ajax.handler.php?id=' + page;  

function reportSelect(bt){
	dynamic_grid_jar.getTopToolbar().get(8).setText(bt.text); 
	dynamic_grid_jar.getTopToolbar().get(8).mode = bt.mode;   
}

var dynamic_grid_jar = new Ext.ux.PhpDynamicGridPanel({
    border:false,
    remoteSort:true, //optional default true
    autoLoadStore:true, //optional default true
    storeUrl:ajax_url,
    sortInfo:{field:'comunidad',direction:'ASC'}, //must declaration
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
        options = dynamic_grid_jar.getParamsFilter();
        report_link = 'report.php?id=' + page;
        options = Ext.apply(options,{mode:this.mode}); 
        winReport({
            id : this.id_jar,
            title : 'Lista jares',
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
      win_jar.get(0).getForm().reset();
      win_jar.setTitle('Agregar'); 
      win_jar.show(bt.id_jar); 
    },
    onEditData:function(bt,rec){
      win_jar.setTitle('Editar');
      win_jar.show(bt.id_jar); 
      win_jar.get(0).getForm().load({
          waitMsg:'Loading Data..',
          params:{action:'edit',id_jar:rec.data.id_jar}
      }); 
    },
    onRemoveData:function(bt,rec){
      data = []; 
      Ext.each(rec,function(r){
        data.push(r.data.id_jar); 
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
win_jar = new Ext.Window({
  id:'win-jar',
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
    {xtype:'hidden', name:'id_jar'},
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
      if(!win_jar.get(0).getForm().isValid()){
        Ext.example.msg('Advertencia','Hay datos vacios'); 
        return false; 
      }
      
      id_data = win_jar.get(0).getForm().getValues().id_jar; 
      action = (id_data?'update':'create'); 
      win_jar.get(0).getForm().submit({
          params:{action:action},
          waitMsg : 'Guardando datos',
          success:function(){
            win_jar.hide();
            Ext.example.msg('Gardar','Los datos han sido gardados'); 
            dynamic_grid_jar.store.reload(); 
          },
          failure:function(){
            Ext.MessageBox.alert('Advertencia','Los datos no se pudieron guardar!!'); 
          }
      }); 
      
    }
  },{
    text:'Close',
    handler:function(){
      win_jar.hide(); 
    }
  }
  ]
}); 

/**end of form**/


var main_content = {
  id : id_panel,  
  title:n.text,  
  iconCls:n.attributes.iconCls,  
  items : [dynamic_grid_jar],
  listeners:{
    destroy:function(){
      my_win = Ext.getCmp('win-jar');
      if (my_win)
          my_win.destroy(); 
    }
  }
}; 
