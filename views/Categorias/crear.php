<main class="contenedor seccion">
    <h1>Registrar Categoría</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">

            <?php echo $error ?>
        </div>
    <?php endforeach; ?>
    <form action="/categorias/crear" class="formulario" method="POST" enctype="multipart/form-data">

        <?php include 'formulario.php'; ?>

        <input type="submit" value="Registrar Categoría" class="boton boton-verde">
    </form>

</main>