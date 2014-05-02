<?php
class Comunidad extends msDB {
    var $grid;

    function  __construct() {
        $this->connect();
        $this->grid = new Grid;
        $this->grid->setTable('comunidades');
        $this->grid->addField(
                array(
                    'field' => 'id_comunidad',
                    'name'  => 'id_comunidad',
                    'primary'=> true,
                    'meta' => array(
                      'st' => array('type' => 'int'),
                      'cm' => array('hidden' => true, 'hideable' => false, 'menuDisabled' => true)
                    )
                ));
        $this->grid->addField(
                array(
                    'field' => 'nombre',
                    'name'  => 'nombre',
                    'meta' => array(
                      'st' => array('type' => 'string'), 
                      'cm' => array('header' => 'Comunidad','width' => 200,'sortable' => true),
                      'filter' => array('type' => 'string')
                    )
                ));
        $this->grid->addField(
        		array(
        				'field' => 'ref',
        				'name'  => 'ref',
        				'meta' => array(
        						'st' => array('type' => 'string'),
        						'cm' => array('header' => 'Año Nacimiento','width' => 200,'sortable' => true),
        						'filter' => array('type' => 'string')
        				)
        		));
        $this->grid->addField(
                array(
                    'field' => 'desde',
                    'name'  => 'desde',
                    'meta' => array(
                      'st' => array('type' => 'date'), 
                      'cm' => array('header' => 'Desde','width' => 90, 'sortable' => true, 
                      		'renderer' => "Ext.util.Format.date(val,'d/m/Y')"),
                      'filter' => array('type' => 'date')
                    )                
                ));
        $this->grid->addField(
        		array(
        				'field' => 'hasta',
        				'name'  => 'hasta',
        				'meta' => array(
        						'st' => array('type' => 'date'),
        						'cm' => array('header' => 'Hasta','width' => 90, 'sortable' => true,
        								'renderer' => "Ext.util.Format.date(val,'d/m/Y')"),
        						'filter' => array('type' => 'date')
        				)
        		));
        $this->grid->addField(
                array(
                    'field' => 'fusion',
                    'name'  => 'fusion',
                    'meta' => array(
                      'st' => array('type' => 'bool'), 
                      'cm' => array('xtype' => 'checkcolumn','header' => 'Fusion','width' => 60, 'sortable' => true),
                      'filter' => array('type' => 'boolean')
                    )                
                )); 

    }

    function create($request){
        $data = array(
          'nombre' => $request['nombre'],
          'ref' => $request['ref'],
          'desde' => $this->grid->formatDate($request['desde']),
          'hasta' => $this->grid->formatDate($request['hasta']),
          'fusion' => $request['fusion'],
          'telefono' => ($request['telefono']?$request['telefono']:0),
          'celular' => ($request['celular']?$request['celular']:0),
          'email' => ($request['email']?$request['email']:0)
        );                
        return $this->grid->doCreate(json_encode($data));
    }

    function edit($id,$request){
       $this->grid->loadSingle = true;
       $this->grid->setManualFilter(" and id_persona = $id"); 
       return $this->grid->doRead($request); 
    }
    
    function read($request){
        return $this->grid->doRead($request);
    }
    function update($request){
        $data = array(
          'id_comunidad' => $request['id_comunidad'],
          'nombre' => $request['nombre'],
          'desde' => $this->grid->formatDate($request['desde']),
          'desde' => $this->grid->formatDate($request['desde']),
          'ref' => $request['ref'],
          'fusion' => $request['fusion']
        );                
        return $this->grid->doUpdate(json_encode($data));
    }
    
    function doReport($request){
      return $this->grid->dosql($request); 
    }

    function destroy($request){
        return $this->grid->doDestroy($request);
    }
}
?>