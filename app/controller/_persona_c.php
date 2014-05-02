<?php
    $action = $_REQUEST['action'];
    $handler->loadModel('persona_m');
    $persona = new Persona;

    switch ($action){
        case 'read':
            echo $persona->read($_POST);
            break;
        case 'create':
            echo $persona->create($_POST);
            break;
        case 'update':
            echo $persona->update($_POST);
            break;
        case 'destroy':
            echo $persona->destroy($_POST['data']);
            break;            
        case 'edit':
          echo $persona->edit($_POST['id_persona'],$_POST); 
          break; 
    }
?>