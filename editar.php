<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header("location:formulariologin.php");
}


include('conex.php');
include("cabecera.php");

if (!isset($_POST["bot_actualizar"])) {

  $id = $_GET['id'];
  $desc = $_GET['descripcion'];
  $link = $_GET['link'];


  // echo "<strong>Datos Actuales:</strong>  <br> id =  $id <br> descrip = $desc <br> link =  $link <br><br>";
} else {

  $id = $_POST['id'];
  $desc = $_POST['descripcion'];
  $link = $_POST['link'];


  $sql = "UPDATE `wp_buenoslinks` SET `descripcion`=:descrip, `link`=:link WHERE `id`=:id ";

  $resultado = $base->prepare($sql);

  $resultado->execute(array(":id" => $id, ":descrip" => $desc, ":link" => $link));

  header("location:index.php");
}

?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" name="viewport" content="initial-scale=1.0, user-scalable=no">
  <title>Actualizar</title>
  <link rel="stylesheet" type="text/css" href="hoja.css">
  <style>
    a {
      text-decoration: none;
      font-weight: bold;
    }

    .maximo {
      width: 80px;
      max-width: 100px;
      overflow: hidden;
      height: 30px;
    }

    .container {
      width: 96%;
      max-width: 600px;
      height: auto;
      margin: 20px auto;
      display: flex;
      align-items: center;
      flex-direction: column;
      overflow: hidden;
      /* outline: 2px solid red; */
    }

    table {
      width: 96%;
    }

    .peque {
      font-size: x-small;
    }

    table .bot {
      padding: 0;
      display: inline;
      border: 0;
      color: aqua;
    }

    table .sin {
      border: 0;
    }
    .caja {
      width: 200px;
      height: auto;
      padding-left: 5px;
    }
  </style>
</head>

<body>
  <section class="container">
  
    <!-- <a href="cierrasession.php">Cerrar Session <br> <br> </a> -->

    <h1>ACTUALIZAR</h1>

    <!-- <p>&nbsp;</p> -->

    <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

      <table width="25%" border="0" align="center">

        <tr>
          <td> Id </td>
          <td><label for="id"></label>
            <input class="caja" type="text" name="id" id="id" value="<?php echo $id ?>" readonly>
          </td>
        </tr>

        <tr>
          <td>Descripcion</td>
          <td><label for="nom"></label>
            <input class="caja" type="text" name="descripcion" id="descripcion" value="<?php echo $desc ?>">
          </td>
        </tr>

        <tr>
          <td>Link</td>
          <td><label for="ape"></label>
            <input class="caja" type="text" name="link" id="link" value="<?php echo $link ?>">
          </td>
        </tr>

        <tr>
          <td colspan="2"><input type="submit" name="bot_actualizar" id="bot_actualizar" value="Actualizar"></td>
        </tr>

      </table>
    </form>
    <p>&nbsp;</p>
    <a href="index.php">Volver</a>


  </section>


</body>

</html>