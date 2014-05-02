<?php
session_start ();
$userid = isset ( $_SESSION ['userid'] ) ? $_SESSION ['userid'] : 0;
if ($userid) {
	include_once ("config_sistem.php");
	include_once ("class/class.msDB.php");
	include_once ("class/class.grid.php");
	include_once ("class/class.handler.php");
	$handler = new handler ( true );
	$id = isset ( $_GET ['id'] ) ? $_GET ['id'] : 0;
	if ($id) {
		$id = explode ( ".", $id );
		$ajax = $handler->getAjax ( $id [1] );
		$parent = $handler->getParent($id [1]);
		if (!$parent){
			$file_path = "app/controller/$ajax";
		}else{
			$module = $handler->getModule($parent);
			$file_path = "app/$module/controller/$ajax";
		}
		if ($file_path)
			if (file_exists ( $file_path )) {
				include_once 'app/config/config.db.php';
				include_once ($file_path);
			}
	}
}
?> 