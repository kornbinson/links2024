<?php

try{

    // $base = new PDO("mysql:host=pdb53.awardspace.net; dbname=3741818_wpresscfeb66bc","3741818_wpresscfeb66bc","_qO5Iz7YGMpKrMouIIbUeSTMgUqGJKR4");
    // $base = new PDO("mysql:host=localhost; dbname=pruebas_links","root","");
    // $base->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    include("conex.php");

    $sql ="SELECT * FROM wp_usuarios_pass WHERE usuarios=:login AND password=:pass";
    $resultado = $base->prepare($sql);
    $login = htmlentities(addslashes($_POST['usuario']));
    $password = htmlentities(addslashes($_POST['password']));
    $resultado->bindValue(":login",$login);
    $resultado->bindValue(":pass",$password);
    $resultado->execute();
    $num_registro = $resultado->rowCount();

    if($num_registro != 0){
        // echo "aqui numeros de count:  $num_registro <br>";

        session_start();
        $_SESSION['usuario']=$_POST['usuario'];
        header("location:index.php");
        setcookie("pruebacookie","esta es una coookie deiby 1 de 30 segundos ",time()+30);

    }else{

        header("location:formulariologin.php");

    }


}catch(Exception $e){

    die("Error : " . $e->getMessage() . $e->getLine());

}


?>