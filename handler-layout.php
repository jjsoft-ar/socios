<?php
	session_start();
	$userid = isset($_SESSION['userid'])?$_SESSION['userid']:0;
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
	header('Cache-Control: no-cache, must-revalidate');
	header('Pragma: no-cache');
	header('Content-Type: text/javascript');
	if ($userid){
		include_once("config_sistem.php");
		include_once("class/class.msDB.php"); 
		include_once("class/class.handler.php"); 
		$handler = new handler(true); 
		$page = isset($_POST['page'])?$_POST['page']:0; 	
		if ($page){
			
			$id = explode(".",$page); 
			$js = $handler->gethandler($id[1]); 
			if ($js)
				$parent = $handler->getParent($id[1]);
				if (!$parent){
					$file = "app/view_js/$js";
				}else{
					$module = $handler->getModule($parent);
					$file = "app/$module/view_js/$js";
				}
				if (file_exists($file)){
					$role = $handler->getEvent($id[1]); 
					if ($role)
						echo "ROLE = Ext.decode('".$role."');\n"; 
					$result = file_get_contents($file);
					echo stripslashes(trim($result)); 
				}
		}
	}
 ?>