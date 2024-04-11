<main class="contenedor seccion">
    <h1>Contacto</h1>
    <?php if($mensaje)
    {
        echo "<p class= 'alerta exito'>" . $mensaje . "</p>";
        
    }
    ?>
    <picture>
        <source srcset="build/img/destacada3.webp" type="image/webp">
        <source srcset="build/img/destacada3.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen Contacto">
    </picture>

    <h2>Llene el formulario de Contacto</h2>

    <form class="chelito" action="/contacto" method="POST">
        <?php include 'formulario.php'?>
        <input type="submit" value="Enviar" class="boton boton-verde">
    </form> 
</main>