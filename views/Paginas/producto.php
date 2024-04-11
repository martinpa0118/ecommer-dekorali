<main class="contenedor seccion contenido-centrado">

    <div id="content-wrapper">

        <div class="column">

            <?php if ($producto->videos) {
                $primerVideo = $producto->videos[0];
                echo "<video id=featuredVideo src='/videos/" . $primerVideo . "' type='video/mp4'controls></video>";
            }
            ?>

            <?php if ($producto->imagenesAuxiliares) {
                $primeraImagen = $producto->imagenesAuxiliares[0];
                echo "<img id='featuredImage' class='thumbnail active' style='display: none;' src='/imagenesAuxiliares/" . $primeraImagen . "' alt='Imagen del producto'>";
            }
            ?>

            <div id="wrapper">
                <img id="slideLeft" class="arrow" src="/imagenesPrincipales/arrow-left.png">

                <div id="sliderUltimo">
                    <!-- Mostrar miniaturas de videos -->

                    <?php
                    if (!empty($producto->videos)) {
                        $esPrimeraImagen = true;
                        foreach ($producto->videos as $extraVideo) {
                            $clase = $esPrimeraImagen ? 'active' : '';
                            echo "<video class ='thumbnail $clase' src='/videos/$extraVideo' type='video/mp4' controls></video>";
                            $esPrimeraImagen = false;
                        }
                    }
                    ?>
                    <?php
                    if (!empty($producto->imagenesAuxiliares)) {
                        foreach ($producto->imagenesAuxiliares as $extraImagen) {
                            echo "<img class='thumbnail' src='/imagenesAuxiliares/$extraImagen' alt='Imagen del producto'>";
                        }
                    }
                    ?>
                </div>
                <img id="slideRight" class="arrow" src="/imagenesPrincipales/arrow-right.png">
            </div>


        </div>

        <div class="column">
            <!-- Contenido del producto -->

            <h1><?php echo $producto->titulo; ?></h1>
            <hr>
            <?php echo $producto->descripcion; ?>
            <p class="precio"><?php echo $producto->precio; ?></p>

            <input value=1 type="number">
            <a class="boton-amarillo-block" href="#">Añadir al Carrito</a>
        </div>
    </div>

    </div>

</main>