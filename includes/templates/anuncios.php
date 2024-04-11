<?php

use Model\Producto;



if($_SERVER['SCRIPT_NAME'] === '/anuncios.php'){
    $productos = Producto::all();
}else{
    $productos = Producto::get(2);
}

?>



<div class="contenedor-anuncios">
    <?php foreach($productos as $producto) { ?>
        <div class="anuncio">

            <img loading="lazy" src="../../imagenesPrincipales/<?php echo $producto->imagen; ?>" alt="anuncio">

            <div class="contenido-anuncio">
                <h3><?php echo $producto->titulo; ?></h3>
                <p><?php echo $producto->descripcion; ?></p>
                <p class="precio"><?php echo $producto->precio; ?></p>


                <a href="anuncio.php?id=<?php echo $producto->id?>" class="boton-amarillo-block">
                    Ver Producto
                </a>
            </div><!--.contenido-anuncio-->
        </div><!--anuncio-->

    <?php } ?>
</div> <!--.contenedor-anuncios-->


