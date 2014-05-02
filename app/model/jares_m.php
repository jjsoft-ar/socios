<?php
class Jares extends msDB {
	var $grid;
	public function __construct() {
		$this->connect ();
		$this->grid = new Grid ();
		$this->grid->setTable ( 'jares j' );
		$this->grid->setJoin ( ',comunidades c, personas p' );
		$this->grid->setManualFilter ( ' AND c.id_comunidad = j.id_comunidad AND p.id_persona = j.id_persona' );
		$this->grid->addField ( array (
			'field' => 'j.id_jar',
			'name' => 'id_jar',
			'primary' => true,
			'meta' => array (
				'st' => array (
					'type' => 'int' 
				),
				'cm' => array (
					'hidden' => true,
					'hideable' => false,
					'menuDisabled' => true 
				) 
			) 
		) );
		$this->grid->addField ( array (
			'field' => 'j.id_comunidad',
			'name' => 'id_comunidad',
			'primary' => true,
			'meta' => array (
				'st' => array (
					'type' => 'int' 
				),
				'cm' => array (
					'hidden' => true,
					'hideable' => false,
					'menuDisabled' => true 
				) 
			) 
		) );
		$this->grid->addField ( array (
			'field' => 'j.id_persona',
			'name' => 'id_persona',
			'primary' => true,
			'meta' => array (
				'st' => array (
					'type' => 'int' 
				),
				'cm' => array (
					'hidden' => true,
					'hideable' => false,
					'menuDisabled' => true 
				) 
			) 
		) );
		$this->grid->addField ( array (
			'field' => 'c.nombre',
			'name' => 'comunidad',
			'meta' => array (
				'st' => array (
					'type' => 'string' 
				),
				'cm' => array (
					'header' => 'Comunidad',
					'width' => 200,
					'sortable' => true 
				),
				'filter' => array (
					'type' => 'string' 
				) 
			) 
		) );
		$this->grid->addField ( array (
			'field' => 'j.coordinador',
			'name' => 'coordinador',
			'meta' => array (
				'st' => array (
					'type' => 'bool' 
				),
				'cm' => array (
					'xtype' => 'checkcolumn',
					'header' => 'Coordinador',
					'width' => 60,
					'sortable' => true 
				),
				'filter' => array (
					'type' => 'boolean' 
				) 
			) 
		) );
		$this->grid->addField ( array (
			'field' => 'p.apellido',
			'name' => 'apellido',
			'meta' => array (
				'st' => array (
					'type' => 'string' 
				),
				'cm' => array (
					'header' => 'Apellido',
					'width' => 100,
					'sortable' => true 
				),
				'filter' => array (
					'type' => 'string' 
				) 
			) 
		) );
		$this->grid->addField ( array (
			'field' => 'p.nombre',
			'name' => 'nombre',
			'meta' => array (
				'st' => array (
					'type' => 'string' 
				),
				'cm' => array (
					'header' => 'Nombre',
					'width' => 200,
					'sortable' => true 
				),
				'filter' => array (
					'type' => 'string' 
				) 
			) 
		) );
		$this->grid->addField ( array (
			'field' => 'p.email',
			'name' => 'email',
			'meta' => array (
				'st' => array (
					'type' => 'string' 
				),
				'cm' => array (
					'header' => 'E-mail',
					'width' => 200,
					'sortable' => true 
				),
				'filter' => array (
					'type' => 'string' 
				) 
			) 
		) );
		$this->grid->addField ( array (
			'field' => 'celular',
			'name' => 'celular',
			'meta' => array (
				'st' => array (
					'type' => 'string' 
				),
				'cm' => array (
					'header' => 'Celular',
					'width' => 100,
					'sortable' => true 
				),
				'filter' => array (
					'type' => 'string' 
				) 
			) 
		) );
	}
	function create($request) {
		$data = array (
			'comunidad' => $request ['comunidad'],
			'coordinador' => $request ['coordinador'],
			'desde' => $this->grid->formatDate ( $request ['desde'] ),
			'hasta' => $this->grid->formatDate ( $request ['hasta'] ),
			'apellido' => $request ['apellido'],
			'nombre' => $request ['nombre'] 
		);
		return $this->grid->doCreate ( json_encode ( $data ) );
	}
	function edit($id, $request) {
		$this->grid->loadSingle = true;
		$this->grid->setManualFilter ( " AND id_jares = $id" );
		return $this->grid->doRead ( $request );
	}
	function read($request) {
		return $this->grid->doRead ( $request );
	}
	function update($request) {
		$data = array (
			'id_jar' => $request ['id_jar'],
			'id_comunidad' => $request ['id_comunidad'],
			'id_persona' => $request ['id_persona'],
			'comunidad' => $request ['comunidad'],
			'desde' => $this->grid->formatDate ( $request ['desde'] ),
			'desde' => $this->grid->formatDate ( $request ['desde'] ),
			'coordinador' => $request ['coordinador'],
			'apellido' => $request ['apellido'],
			'nombre' => $request ['nombre'] 
		);
		return $this->grid->doUpdate ( json_encode ( $data ) );
	}
	function doReport($request) {
		return $this->grid->dosql ( $request );
	}
	function destroy($request) {
		return $this->grid->doDestroy ( $request );
	}
}
?>