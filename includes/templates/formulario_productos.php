<fieldset>
    <legend>Informacion General</legend>
    <!-- Poducto -->
    <label for="titulo">Nombre:</label>
    <input type="text" id="titulo" name="producto[titulo]" value="<?php echo s($producto->titulo); ?>" placeholder="Nombre Producto">
    <!-- Imagen -->
    <label for="imagen">Imagen Principal:</label>
    <input type="file" id="imagen" name="producto[imagen]" accept="image/jpeg, image/png">
    <?php if ($producto->imagen) { ?>
        <img src="/imagenesPrincipales/<?php echo $producto->imagen ?>" class="imagen-small">
    <?php } ?>
    <!-- Imagenes -->
    <label for="imagenes">Imagenes Auxiliares:</label>
    <input type="file" id="imagenes" name="producto[imagenes][]" multiple accept="image/*">
    <?php if ($producto->imagenesAuxiliares !== [''] && !is_null($producto->id)) { ?>
        <?php foreach ($imagenesProducto as $bandera) { ?>
            <img src="/imagenesAuxiliares/<?php echo $bandera->imagen; ?>" class="imagen-small">
        <?php } ?>
    <?php } ?>

    <!-- videos -->
    <label for="videos">Videos del Producto:</label>
    <input type="file" id="videos" name="producto[videos][]" multiple accept="video/*">
    <?php if ($producto->videos !== [''] && !is_null($producto->id)) { ?>
        <?php foreach ($videosProducto as $videoProducto) { ?>
            <video class="imagen-small" controls>
                <source src="/videos/<?php echo $videoProducto->video; ?>" class="imagen-small">
            </video>
        <?php } ?>
    <?php } ?>

    <!-- Categorias -->
    <label for="categoriaId">Categoria del Producto:</label>
    <select name="producto[categoriaId]" id="categoriaId">
        <option selected value="">-- seleccione --</option>
        <?php
        foreach ($categorias as $categoria) { ?>
            <option <?php echo $producto->categoriaId === $categoria->id ? 'selected' : ''; ?> value="<?php echo s($categoria->id); ?>"><?php echo s($categoria->prefijo) . "-" . s($categoria->nombre); ?></option>

        <?php } ?>

    </select>

    <!-- Codigo Producto -->
    <label for="codigo">Código:</label>
    <input type="number" id="codigo" name="producto[codigo]" value="<?php echo s($producto->codigo); ?>" placeholder="Código Producto">

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="producto[descripcion]"><?php echo s($producto->descripcion); ?></textarea>
    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="producto[precio]" value="<?php echo s($producto->precio); ?>" placeholder="Precio Producto">



</fieldset>