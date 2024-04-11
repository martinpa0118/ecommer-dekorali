<fieldset>
    <legend>Informacion General</legend>
    <!-- Poducto -->
    <label for="prefijo">Prefijo:</label>
    <input type="text" id="prefijo" name="categoria[prefijo]" value="<?php echo s($categoria->prefijo); ?>" placeholder="Prefijo Categoría">
    <!-- Poducto -->
    <label for="nombre">Nombre Categoria:</label>
    <input type="text" id="categoria" name="categoria[nombre]" value="<?php echo s($categoria->nombre); ?>" placeholder="Nombre Categoría">

</fieldset>