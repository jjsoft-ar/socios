<?php
    $action = $_REQUEST['action'];
    $handler->loadModel('comunidad_m');
    $comundiad = new Comunidad;

    switch ($action){
        case 'read':
            echo $comundiad->read($_POST);
            break;
        case 'create':
            echo $comundiad->create($_POST);
            break;
        case 'update':
            echo $comundiad->update($_POST);
            break;
        case 'destroy':
            echo $comundiad->destroy($_POST['data']);
            break;            
        case 'edit':
          echo $comundiad->edit($_POST['id_comunidad'],$_POST); 
          break; 
    }
?>