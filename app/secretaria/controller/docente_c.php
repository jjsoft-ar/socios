<?php
    $action = $_REQUEST['action'];
    $module = 'secretaria';
    $handler->loadModel('docente_m',$module);
    $docente = new Docente;

    switch ($action){
        case 'read':
            echo $docente->read($_POST);
            break;
        case 'create':
            echo $docente->create($_POST);
            break;
        case 'update':
            echo $docente->update($_POST);
            break;
        case 'destroy':
            echo $docente->destroy($_POST['data']);
            break;            
        case 'edit':
          echo $docente->edit($_POST['legajo_doc'],$_POST); 
          break; 
    }
?>