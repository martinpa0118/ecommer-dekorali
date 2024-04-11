<main class="contenedor seccion">
    <h1>Administrador de Productos Dekorali</h1>
    <?php
    if ($resultado) {
        $mensaje = mostrarNotificacion(intval($resultado));
        if ($mensaje) {  ?>
            <p class="alerta exito"><?php echo s($mensaje) ?></p>

    <?php   }
    }
    ?>


    <a href="/productos/crear" class="boton boton-verde">Nuevo Producto</a>
    <a href="/categorias/crear" class="boton boton-amarillo-inline">Nueva Categoria</a>
    <h2>Productos</h2>
    <table class="productos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Codigo</th>
                <th>Categoria</th>
                <th>Precio</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody> <!--Mostrar los Resultados -->
            <?php foreach ($productos as $producto) : ?>
                <tr>
                    <td><?php echo $producto->id; ?></td>
                    <td><?php echo $producto->titulo; ?></td>
                    <td><img src="../imagenesPrincipales/<?php echo $producto->imagen; ?>" class="imagen-tabla"></td>
                    <td><?php echo $producto->codigo; ?></td>
                    <td><?php echo $producto->categoriaId; ?></td>
                    <td>$ <?php echo $producto->precio; ?></td>
                    <td>
                        <form method="POST" class="w-100" action= "/productos/eliminar">
                            <input type="hidden" name="id" value="<?php echo $producto->id; ?>">
                            <input type="hidden" name="tipo" value="producto">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="/productos/actualizar?id=<?php echo $producto->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach ?>

        </tbody>
    </table>
    <h2>Categorías</h2>
    <table class="productos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Prefijo</th>
                <th>categoria</th>
                <!-- <th>Imagen</th> -->
                <th>Acciones</th>


            </tr>
        </thead>
        <tbody> <!--Mostrar los Resultados -->
            <?php foreach ($categorias as $categoria) : ?>
                <tr>
                    <td><?php echo $categoria->id; ?></td>
                    <td><?php echo $categoria->prefijo; ?></td>

                    <td><?php echo $categoria->nombre; ?></td>
                    <td>
                        <form method="POST" class="w-100" action="/categorias/eliminar">
                            <input type="hidden" name="id" value="<?php echo $categoria->id; ?>">
                            <input type="hidden" name="tipo" value="categoria">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="categorias/actualizar?id=<?php echo $categoria->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach ?>

        </tbody>
    </table>




</main>