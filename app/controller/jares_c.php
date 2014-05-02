<?php
    $action = $_REQUEST['action'];
    $handler->loadModel('jares_m');
    $jar = new Jares;

    switch ($action){
        case 'read':
            echo $jar->read($_POST);
            break;
        case 'create':
            echo $jar->create($_POST);
            break;
        case 'update':
            echo $jar->update($_POST);
            break;
        case 'destroy':
            echo $jar->destroy($_POST['data']);
            break;            
        case 'edit':
          echo $jar->edit($_POST['id_jar'],$_POST); 
          break; 
    }
?>