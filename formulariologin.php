<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="hoja.css">
    <title>Links</title>
</head>
<body>

    <h1>LOGIN LINKS</h1>
    
    <form action="validologin.php" method="post">

        <table class="center sinBorde login">

            <tr>
                <td>Usuario:</td>
                <td>
                    <input type="text" name="usuario" >
                </td>
            </tr>

            <tr>
                <td>Password:</td>
                <td>
                    <input type="password" name="password" >
                </td>
            </tr>

            <tr>
                <td>&nbsp;</td>                
                <td>&nbsp;</td>                
            </tr>

            <tr>
                <td colspan="2" class="textCenter">
                    <input type="submit" name="enviando" value="Login">
                </td>
            </tr>

        </table>        
        
    </form>
    
    <div class="divCentrado">
        <button id="myBtn" onclick="myFunction()">Algo de Musica ?</button>        
    </div>

    <div class="divCentrado">
        <video preload="false" id="video" src="files/Zelda.mp4" playsinline></video>
    </div>

<script>

let vid = document.getElementById("video");
let button =  document.getElementById("myBtn");


function reproducir(){
    vid.play();
}

function myFunction() {
  
    if(confirm("Escuchar Musica ?") == true ){
        button.innerHTML = "Seguir Escuchando ?";
        reproducir();
    }else{
        vid.pause();
    }
    
}

</script>

</body>
</html>
