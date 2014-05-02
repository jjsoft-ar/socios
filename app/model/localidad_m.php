<?php
class Localidad extends msDB {
    var $grid;

    function  __construct() {
        $this->connect();
        $this->grid = new Grid;
        $this->grid->setTable('localidades');
        $this->grid->addField(
                array(
                    'field' => 'id_localidad',
                    'name'  => 'id_localidad',
                    'primary'=> true,
                    'meta' => array(
                      'st' => array('type' => 'int'),
                      'cm' => array('hidden' => true, 'hideable' => false, 'menuDisabled' => true)
                    )
                ));
        $this->grid->addField(
                array(
                    'field' => 'id_departamento',
                    'name'  => 'id_departamento',
                    'meta' => array(
                      'st' => array('type' => 'int'),
                      'cm' => array('hidden' => true, 'hideable' => false, 'menuDisabled' => true)
                    )
                ));
        $this->grid->addField(
        		array(
        				'field' => 'cod_postal',
        				'name'  => 'cod_postal',
        				'meta' => array(
        						'st' => array('type' => 'int'),
        						'cm' => array('header' => 'CP','width' => 50,'sortable' => false),
        						'filter' => array('type' => 'int')
        				)
        		));
        $this->grid->addField(
                array(
                    'field' => 'marca_post',
                    'name'  => 'marca_post',
                    'meta' => array(
                      'st' => array('type' => 'int'), 
                      'cm' => array('header' => 'Marca Post','width' => 90, 'sortable' => false)
                    )                
                ));
        $this->grid->addField(
        		array(
        				'field' => 'car_tel',
        				'name'  => 'car_tel',
        				'meta' => array(
        						'st' => array('type' => 'int'),
        						'cm' => array('header' => 'Caract. Tel.','width' => 90,'sortable' => false)
        				)
        		));
        $this->grid->addField(
        		array(
        				'field' => 'nombre_loc',
        				'name'  => 'nombre_loc',
        				'meta' => array(
        						'st' => array('type' => 'string'),
        						'cm' => array('header' => 'Localidad','width' => 200,'sortable' => true),
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