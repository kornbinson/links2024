<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header("location:formulariologin.php");
}

include("conex.php");
include("cabecera.php");

//------------ la paginacion -----------------------------

$muestras_por_pagina = 30;

if (isset($_GET['pagina'])) {

  if ($_GET['pagina'] == 1) {

    header("location:index.php");
    // header('location:?');
  } else {
    $pagina = $_GET['pagina'];
  }
} else {

  $pagina = 1;
}

$inicio = ($pagina - 1) * $muestras_por_pagina;

if($_SESSION['usuario'] == "kornbinson29a")
{
  $sql_paginacion = "SELECT * FROM wp_buenoslinks";
}else{
  $sql_paginacion = "SELECT * FROM wp_buenoslinks WHERE descripcion NOT LIKE '%xxx%'";
}

$resp = $base->prepare($sql_paginacion);

$resp->execute(array());

$num_filas = $resp->rowCount();

$total_paginas = ceil($num_filas / $muestras_por_pagina);


//------------ fin de paginacion -------------------------

// $conexion = $base->query("SELECT * FROM datos_usuarios");

// $registros = $conexion->fetchAll(PDO::FETCH_OBJ);

// lo mismo que las 2 lineas anteriores en una sola linea

if($_SESSION['usuario'] == "kornbinson29a")
{
  $registros = $base->query("SELECT * FROM wp_buenoslinks ORDER BY id DESC LIMIT $inicio,$muestras_por_pagina")->fetchAll(PDO::FETCH_OBJ);
}else{
  $registros = $base->query("SELECT * FROM wp_buenoslinks WHERE descripcion NOT LIKE '%xxx%' ORDER BY id DESC LIMIT $inicio,$muestras_por_pagina")->fetchAll(PDO::FETCH_OBJ);
}



//$registros = $base->query("SELECT * FROM wp_buenoslinks where NOT descripcion like '%xxx%' LIMIT $inicio,$muestras_por_pagina ")->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['cr'])) {

  $desc = $_POST['descripcion'];
  $link = $_POST['link'];

  $sql = " INSERT INTO wp_buenoslinks (descripcion, link ) VALUES (:descrip,:link)";

  $resultado = $base->prepare($sql);

  $resultado->execute(array(":descrip" => $desc, ":link" => $link));

  header("location:?pagina=" . $total_paginas);
}

?>

<!doctype html>
<html>

<head>
  <meta charset="utf-8" name="viewport" content="initial-scale=1.0, user-scalable=no">
  <title>LINKS</title>
  <!-- CSS only -->
  <link rel="stylesheet" type="text/css" href="slider.css">
  <link rel="stylesheet" type="text/css" href="prueba.css">
</head>

<body>

  <section class="container">
    <div class="textCenter">
      <div>
        <p> Bienvenido <strong> <?php echo $_SESSION['usuario'] ?>  
        <?php echo " <small style='color: red;'>"." " . $pagina ." " . " </small>" ?></strong> <br></p>
        <input type="hidden" value="<?php echo $pagina ?>" id="currentPag" name="currentPag"/>
      </div>

      <div>
        <h3>Paginas de Interes diversas</h3>
      </div>
    </div>

    <span class="ir-abajo">▼</span> 

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
          <td><?php echo $datos->id ?></td>
          <td><?php echo $datos->descripcion ?></td>
          <td>
            <div class='maximo peque'> 
              <a href="<?php echo $datos->link ?>" target="_blank" rel="noopener noreferrer">
                <?php echo $datos->link ?>
              </a>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

      <?php 
        include("sliderPaginacion.php");
      ?>
            
  </section>

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

    <span class="ir-arriba">▲</span>      

  <script>
      var idFila =  "";
      var descripFila = "";
      var linkFila =  "";
      var pagActual = "";

    $("table tbody tr").dblclick(function() {
      idFila =  $.trim( $(this).find("td:eq(0)").text() );
      descripFila = $.trim( $(this).find("td:eq(1)").text() );
      linkFila =  $.trim( $(this).find("td:eq(2)").text() );
      pagActual = $.trim( $("#currentPag").val() );
      //var pagActual = document.getElementById("demo").innerText;      
      //console.log("demo-> ", pagActual);      
      //location.href = `editar2.php?id=${idFila}&pagActual=${pagActual}&descripcion=${descripFila}&link=${linkFila}`;

      var msjModal = `Puedes editar, eliminar Id #${idFila} o crear un nuevo registro.`;
      var modalOutput = document.getElementById("textModal");
      modalOutput.innerHTML = msjModal;      

      $("#modalDeleteEdit").modal("show"); 
    
      // console.log("hiciste dbl click !");

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
      <input type="hidden" name="pagActual" value="${pagActual}"/>
      </form>`;
      $(dataPost).appendTo('body').submit();            
    }

    function eliminarRegistro(){
      var dataPost = `<form action="borrar2.php" method="post">
      <input type="hidden" name="id" value="${idFila}"/>
      <input type="hidden" name="descripcion" value="${descripFila}"/>
      <input type="hidden" name="pagActual" value="${pagActual}"/>
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


    $(document).ready(function(){

      var posicion = $(".slidecontainer").offset().top;

      $('.ir-abajo').click(function(){
        $('body, html').animate({
          scrollTop: posicion
        }, 100);          
      });

      $('.ir-arriba').click(function(){
        $('body, html').animate({
          scrollTop: '0px'
        }, 100);
      });

      $(window).scroll(function(){
        if( $(this).scrollTop() > 200 ){
          $('.ir-arriba').slideDown(500);
          $('.ir-abajo').slideUp(500);
        } else {
          $('.ir-arriba').slideUp(500);
          $('.ir-abajo').slideDown(500);
        }
      });

    });
    
  </script>

</body>
</html> 