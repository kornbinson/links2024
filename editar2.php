<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header("location:formulariologin.php");
}

include('conex.php');
include("cabecera.php");

if (!isset($_POST["bot_actualizar"])) {

  $id = $_POST['id'];
  $desc = $_POST['descripcion'];
  $link = $_POST['link'];
  $pagActual = $_POST['pagActual'];
  $msjError = "";
  
  $titleEdit = "Actualizar registro";
  if($id == 0){
    $titleEdit = "Nuevo registro";
  }

  //echo "<strong>Datos Actuales:</strong>  <br> pagActual =  $pagActual <br><br>";
  //echo "<strong>Datos Actuales:</strong>  <br> id =  $id <br> descrip = $desc <br> link =  $link <br><br>";
} else {

  $id = $_POST['id'];
  $desc = $_POST['descripcion'];
  $link = $_POST['link'];
  $pagActual = $_POST['pagActual'];
  $titleEdit = "Nuevo registro";
  $msjError = "";
  //echo "<strong>Datos Actuales:</strong>  <br> id =  $id <br> descrip = $desc <br> link =  $link <br><br>";

  if($id == 0){

    try{
      $sql = "INSERT INTO `wp_buenoslinks`(`descripcion`, `link`) VALUES ( :descrip, :link )";
      $resultado = $base->prepare($sql);
      $resultado->execute(array(":descrip" => $desc, ":link" => $link));

    } catch(Exception $e){
      if($e->getCode() == 23000 ){                        
        $msjError = "Este link ya existe en el sistema !";        
      }
      else{
        // $msjError =  $e->getMessage();
        $msjError = "<script> alert('". $e->getMessage(). "'); </script>";        
      }      
    }
    
  }

  if($id > 0){

    $sql = "UPDATE `wp_buenoslinks` SET `descripcion`=:descrip, `link`=:link WHERE `id`=:id ";
    $resultado = $base->prepare($sql);
    $resultado->execute(array(":id" => $id, ":descrip" => $desc, ":link" => $link));    
  }
  
  if($msjError == ""){
    header("location:index.php?pagina=$pagActual");
  }

  //header("location:index.php?pagina=$pagActual");
}

?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" name="viewport" content="initial-scale=1.0, user-scalable=no">
  <title><?php echo $titleEdit ?></title>
  <link rel="stylesheet" type="text/css" href="prueba.css">
</head>

<body>
  <section class="container">
    <div class="textCenter">
      <h3><?php echo $titleEdit ?></h3>
    </div>
    
    <form class="bg-dark p-3" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

      <input type="hidden" value="<?php echo $pagActual ?>" id="pagActual" name="pagActual"/>
      <input type="hidden" value="<?php echo $id ?>" name="id" id="id"/>

      <div class="row d-flex justify-content-between pl-3 pr-3">        
        <p class="form-text"># <?php echo $id ?></p>                  
        <a class="link-action-click" onclick="volverPagina()">Volver</a>
      </div>      

      <p class="text-warning"><?php echo $msjError ?></p>

      <div class="form-group">
        <label for="descripcion">Descripcion</label>
        <textarea class="form-control" name="descripcion" id="descripcion" rows="2"><?php echo $desc ?></textarea>       
      </div>

      <div class="form-group">
        <label for="link">Link</label>        
        <textarea class="form-control mb-4" name="link" id="link" rows="3"><?php echo $link ?></textarea>
      </div>

      <input type="submit" name="bot_actualizar" id="bot_actualizar" value="Guardar">
      
    </form>            
  </section>

  <script>
    function volverPagina(){
      var pagActual = $("#pagActual").val();      
      location.href = `index.php?pagina=${pagActual}`;
    }
  </script>
</body>
</html>