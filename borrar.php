<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header("location:formulariologin.php");
}


include("conex.php");
include("cabecera.php");

if (!isset($_POST['respuesta'])) {

  $id = $_GET["id"];
  $desc = $_GET["descripcion"];
} else {
  $id = $_POST["id"];
}


if (isset($_POST['respuesta'])) {

  $respuesta = $_POST['respuesta'];

  if ($respuesta == 'SI') {

    $base->query("DELETE FROM wp_buenoslinks WHERE id='$id' ");

    header("location:index.php");

    // echo "$respuesta es ";

  } else {

    header("location:index.php");
    // echo "$respuesta es ";

  }
}

// $base->query("DELETE FROM buenoslinks WHERE id='$id' ");

// header("location:index.php");

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background-color: dimgray;
      color: white;
    }

    .center {
      margin-left: auto;
      margin-right: auto;
    }

    .textCenter {
      text-align: center;
    }

    .espacio {
      margin: 10px;
    }
  </style>
  <title>Document</title>
</head>

<body>

  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <div class="textCenter">

      <h2>Estas Seguro que deseas eliminar el registro</h2>
      <h3><?php echo $desc  ?></h3>
      <p> ¿Sí o no?</p>
      <p>
        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
        <input class="espacio" type="submit" name="respuesta" value="SI">
        <input class="espacio" type="submit" name="respuesta" value="NO">
      </p>
    </div>

  </form>


</body>

</html>