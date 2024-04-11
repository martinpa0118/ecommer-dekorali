<div class="contenedor-anuncios">
    <?php foreach($categorias as $categoria) { ?>
        <div class="anuncio">

            <img loading="lazy" src="../../imagenesPrincipales/<?php echo $producto->imagen; ?>" alt="anuncio">

            <div class="contenido-anuncio">
                <h3><?php echo $categoria->prefijo; ?></h3>
                <h3><?php echo $categoria->nombre; ?></h3>



                <a href="/producto?id=<?php echo $categoria->id?>" class="boton-amarillo-block">
                    Ver
                </a>
            </div><!--.contenido-anuncio-->
        </div><!--anuncio-->

    <?php } ?>
</div> <!--.contenedor-anuncios-->