<?php
   $handler->loadModel("persona_m"); 
  $people = new Persona;
  
  $rs = $people->doReport($_POST); 
  
  $include_file = ($_POST['mode']=='pdf')?'pdf.php':'xls.php'; 
  
  include 'people/'.$include_file;
  
  
?>