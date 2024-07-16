<div class="containerIndex" >        
    <div class="slidecontainer textCenter">        
        <a id="abc" onclick="f1()" href=""> <p>Go Pag: <span id="demo"></span></p> </a>
        <input type="range" min="1" max="<?php echo $total_paginas ?>" value="<?php echo $pagina ?>" class="slider" id="myRange">        
    </div>        
</div>

<script>
var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value;

slider.oninput = function() {
    output.innerHTML = this.value;
}

function f1(){
    document.getElementById("abc").href=`?pagina=${slider.value}`; 
}
</script>