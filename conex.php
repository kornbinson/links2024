<?php

try{
        
    //$base = new PDO("mysql:host=pdb53.awardspace.net; dbname=3741818_wpresscfeb66bc","3741818_wpresscfeb66bc","_qO5Iz7YGMpKrMouIIbUeSTMgUqGJKR4");
    //$base = new PDO("mysql:host=localhost; dbname=pruebas_links","root","");
    $base = new PDO("mysql:host=localhost; dbname=info_links","docker","docker");
    $base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $base->exec("SET CHARACTER SET UTF8");



}catch(Exception $e){

    die("Error : " . $e->getMessage() );
    echo "Liniea de error : " .$e->getLine();

}

?>