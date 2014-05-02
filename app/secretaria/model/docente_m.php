<?php
class Persona extends msDB {
    var $grid;

    function  __construct() {
        $this->connect();
        $this->grid = new Grid;
        $this->grid->setTable('personas');
        $this->grid->addField(
                array(
                    'field' => 'id_persona',
                    'name'  => 'id_persona',
                    'primary'=> true,
                    'meta' => array(
                      'st' => array('type' => 'int'),
                      'cm' => array('hidden' => true, 'hideable' => false, 'menuDisabled' => true)
                    )
                ));
        $this->grid->addField(
                array(
                    'field' => 'apellido',
                    'name'  => 'apellido',
                    'meta' => array(
                      'st' => array('type' => 'string'), 
                      'cm' => array('header' => 'Apellido','width' => 100,'sortable' => true),
                      'filter' => array('type' => 'string')
                    )
                ));
        $this->grid->addField(
        		array(
        				'field' => 'nombre',
        				'name'  => 'nombre',
        				'meta' => array(
        						'st' => array('type' => 'string'),
        						'cm' => array('header' => 'Nombre','width' => 200,'sortable' => true),
        						'filter' => array('type' => 'string')
        				)
        		));
        $this->grid->addField(
                array(
                    'field' => 'fecha_nac',
                    'name'  => 'fecha_nac',
                    'meta' => array(
                      'st' => array('type' => 'date'), 
                      'cm' => array('header' => 'Nacimiento','width' => 90, 'sortable' => true, 
                      		'renderer' => "Ext.util.Format.date(val,'d/m/Y')"),
                      'filter' => array('type' => 'date')
                    )                
                ));
        $this->grid->addField(
        		array(
        				'field' => 'dom_calle',
        				'name'  => 'dom_calle',
        				'meta' => array(
        						'st' => array('type' => 'string'),
        						'cm' => array('header' => 'Domicilio','width' => 200,'sortable' => true),
        						'filter' => array('type' => 'string')
        				)
        		));
        $this->grid->addField(
        		array(
        				'field' => 'telefono',
        				'name'  => 'telefono',
        				'meta' => array(
        						'st' => array('type' => 'string'),
        						'cm' => array('header' => 'Telefono','width' => 100,'sortable' => true),
        						'filter' => array('type' => 'string')
        				)
        		));
        $this->grid->addField(
        		array(
        				'field' => 'celular',
        				'name'  => 'celular',
        				'meta' => array(
        						'st' => array('type' => 'string'),
        						'cm' => array('header' => 'Celular','width' => 100,'sortable' => true),
        						'filter' => array('type' => 'string')
        				)
        		));
        $this->grid->addField(
        		array(
        				'field' => 'email',
        				'name'  => 'email',
        				'meta' => array(
        						'st' => array('type' => 'string'),
        						'cm' => array('header' => 'E-mail','width' => 200,'sortable' => true),
        						'filter' => array('type' => 'string')
        				)
        		));

    }

    function create($request){
        $data = array(
          'apellido' => $request['apellido'],
          'nombre' => $request['nombre'],
          'fecha_nacimiento' => $this->grid->formatDate($request['fecha_nacimiento']),
          'domicilio' => $request['domicilio'],
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
          'id_persona' => $request['id_persona'],
          'apellido' => $request['apellido'],
          'nombre' => $request['nombre'],
          'fecha_nacimiento' => $this->grid->formatDate($request['fecha_nacimiento']),
          'domicilio' => $request['domicilio'],
          'telefono' => ($request['telefono']?$request['telefono']:0),
          'celular' => ($request['celular']?$request['celular']:0),
          'email' => ($request['email']?$request['email']:0)
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