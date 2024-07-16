<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header("location:formulariologin.php");
}


include("conex.php");
include("cabecera.php");

$muestras_por_pagina = 1000;

if (isset($_GET['pagina'])) {

  if ($_GET['pagina'] == 1) {

    header("location:busquedas.php");
    // header('location:?');
  } else {
    $pagina = $_GET['pagina'];
  }
} else {

  $pagina = 1;
}

$inicio = ($pagina - 1) * $muestras_por_pagina;




if (!isset($_POST["boton_Busqueda"])) {
    
    $descripBusqueda = "disco";
    //$linkBusqueda = "youtube";
    
    // echo "<strong>Datos Actuales:</strong>  <br> id =  $id <br> descrip = $desc <br> link =  $link <br><br>";
  } else {
  
  
    $descripBusqueda = $_POST['descripBusqueda'];
    $descripBusqueda = trim($descripBusqueda);
    //$linkBusqueda = $_POST['linkBusqueda'];
  
  }
    // $sql = "UPDATE `wp_buenoslinks` SET `descripcion`=:descrip, `link`=:link WHERE `id`=:id ";
    // $resultado = $base->prepare($sql);
    // $resultado->execute(array(":descrip" => $desc, ":link" => $link));
    // $sql = "UPDATE `wp_buenoslinks` SET `descripcion`=:descrip, `link`=:link WHERE `id`=:id ";

    if($_SESSION['usuario'] == "kornbinson29a")
    {
      $sql = "SELECT * FROM `wp_buenoslinks` WHERE descripcion LIKE '%$descripBusqueda%' 
      OR link LIKE '%$descripBusqueda%' ORDER BY id DESC";
    }else{
      $sql = "SELECT * FROM `wp_buenoslinks` 
      WHERE (descripcion LIKE '%$descripBusqueda%' 
      OR link LIKE '%$descripBusqueda%') AND ( descripcion NOT LIKE '%xxx%' ) ORDER BY id DESC";
    }
      
    $resultado = $base->prepare($sql);
  
    $resultado->execute(array());

    $num_filas = $resultado->rowCount();

    $total_paginas = ceil($num_filas / $muestras_por_pagina);

    $registros = $base->query($sql)->fetchAll(PDO::FETCH_OBJ);

    // echo $resultado;
  
    // header("location:index.php");
  

?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" name="viewport" content="initial-scale=1.0, user-scalable=no">
  <title>Actualizar</title>
  <link rel="stylesheet" type="text/css" href="prueba.css">
  <!-- <link rel="stylesheet" type="text/css" href="hoja.css"> -->
</head>

<body>
  <div class="container">

    <h1>Busquedas</h1>
    <p> "<?php echo $descripBusqueda ?>"  <?php echo $num_filas ?> resultados</p>

    <form name="form1" class="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<!-- 
      <table class="table table-dark">
        <tr>
          <td>Descripcion</td>
          <td><label for="descripBusqueda"></label>
            <input class="caja" type="text" name="descripBusqueda" id="descripBusqueda" value="<?php echo $descripBusqueda ?>">
          </td>
        </tr>

        <tr>
          <td colspan="2"><input type="submit" name="boton_Busqueda" id="boton_Busqueda" value="Buscar"></td>
        </tr>

      </table> -->

      <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Ingrese texto a buscar" 
        aria-label="Recipient's username" aria-describedby="basic-addon2"
        name="descripBusqueda" id="descripBusqueda">

        <div class="input-group-append">
          <input type="submit" name="boton_Busqueda" id="boton_Busqueda" value="Buscar">
        </div>

      </div>

    </form>



    <table class="table table-dark">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Descripción</th>
          <th scope="col">Links</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($registros as $datos) :  ?>
          <tr>
            <td> <?php echo $datos->id ?> </td>
            <td> <?php echo $datos->descripcion ?> </td>
            <td>
              <div class='maximo peque'> <a href="<?php echo $datos->link ?>" target="_blank" rel="noopener noreferrer">
                  <?php echo $datos->link ?>
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>  
    </table>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="modalDeleteEdit" tabindex="-1">
      <div class="modal-dialog modal-sm text-dark">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar / Eliminar</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <p id="textModal" ></p>

            <div class="row d-flex justify-content-between p-3">
              <button onclick="nuevoRegistro()" type="button" class="btn btn-success">Nuevo</button>
              <button onclick="editarRegistro()"  type="button" class="btn btn-primary">Editar</button>
              <button onclick="eliminarRegistro()" type="button" class="btn btn-danger">Eliminar</button>
            </div>            

          </div>
          <div class="modal-footer d-flex justify-content-between">
            <button onclick="copyToClipboard()" type="button" class="btn btn-secondary">Copiar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>            
          </div>
        </div>
      </div>
    </div>

  <script>
      var idFila =  "";
      var descripFila = "";
      var linkFila =  "";

    $("table tbody tr").dblclick(function() {
      idFila =  $.trim( $(this).find("td:eq(0)").text() );
      descripFila = $.trim( $(this).find("td:eq(1)").text() );
      linkFila =  $.trim( $(this).find("td:eq(2)").text() );
      //var pagActual = document.getElementById("demo").innerText;      
      //console.log("demo-> ", pagActual);      
      //location.href = `editar2.php?id=${idFila}&pagActual=${pagActual}&descripcion=${descripFila}&link=${linkFila}`;

      var msjModal = `Puedes editar, eliminar Id #${idFila} o crear un nuevo registro.`;
      var modalOutput = document.getElementById("textModal");
      modalOutput.innerHTML = msjModal;      
      $("#modalDeleteEdit").modal("show");        
    });

    function nuevoRegistro(){
      var dataPost = `<form action="editar2.php" method="post">
      <input type="hidden" name="id" value="0"/>
      <input type="hidden" name="descripcion" value=""/>
      <input type="hidden" name="link" value=""/>
      <input type="hidden" name="pagActual" value="1"/>
      </form>`;
      $(dataPost).appendTo('body').submit();            
    }


    function editarRegistro(){
      var dataPost = `<form action="editar2.php" method="post">
      <input type="hidden" name="id" value="${idFila}"/>
      <input type="hidden" name="descripcion" value="${descripFila}"/>
      <input type="hidden" name="link" value="${linkFila}"/>
      <input type="hidden" name="pagActual" value="1"/>
      </form>`;
      $(dataPost).appendTo('body').submit();            
    }

    function eliminarRegistro(){
      var dataPost = `<form action="borrar2.php" method="post">
      <input type="hidden" name="id" value="${idFila}"/>
      <input type="hidden" name="descripcion" value="${descripFila}"/>
      <input type="hidden" name="pagActual" value="1"/>
      </form>`;
      $(dataPost).appendTo('body').submit();              
    }

    // Auxiliar function to copy clipboard
    function copyToClipboard() {
      clipboard.writeText(linkFila);    
      $("#modalDeleteEdit").modal("hide"); 

      $.notify('link copiado', {
        globalPosition: 'right center',
        className: 'success'
      });       
    }

  </script>


</body>
</html>
