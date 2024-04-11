<?php

namespace Controllers;

use MVC\Router;
use Model\Producto;
use Model\Imagenes;
use Model\Videos;
use Model\Categorias;
use Intervention\Image\ImageManagerStatic as Image;


class ProductoController
{

    public static function index(Router $router)
    {
        $productos = Producto::all();

        $categorias = Categorias::all();

        //Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;


        $router->render('Productos/admin', [
            'productos' => $productos,
            'resultado' => $resultado,
            'categorias' => $categorias
        ]);
    }
    public static function crear(Router $router)
    {
        $producto = new Producto;
        $categorias = Categorias::all();

        //Arreglo con mensajes de errores
        $errores = Producto::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Crea una nueva instancia
            $producto = new Producto($_POST['producto']);


            //SUBIDA DE ARCHIVOS

            //Generar nombre unico imagen principal
            $nombreImagenPrincipal = md5(uniqid(rand(), true)) . ".jpg";

            // debuguear($_FILES['producto']['name']['imagenes']);

            //Setear la imagen
            //Realiza un resize a la imagen con intervention
            if ($_FILES['producto']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['producto']['tmp_name']['imagen'])->fit(800, 600);
                $producto->setImagen($nombreImagenPrincipal);
            }

            if (!empty($_FILES['producto']['tmp_name']['imagenes'])) {
                $imagenesAuxiliares = $_FILES['producto']['tmp_name']['imagenes'];

                foreach ($imagenesAuxiliares as $i => $temporal) {
                    // Verificar si el archivo se subió correctamente
                    if ($_FILES['producto']['error']['imagenes'][$i] === UPLOAD_ERR_OK) {
                        $nombre = $_FILES['producto']['name']['imagenes'][$i];
                        // Generar nombre único para cada imagen auxiliar
                        $nombreImagenAuxiliar = md5(uniqid($nombre, true)) . ".jpg";

                        $producto->agregarImagenAuxiliar($nombreImagenAuxiliar);
                    }
                }
            }
            if (!empty($_FILES['producto']['tmp_name']['videos'])) {
                $videosAuxiliares = $_FILES['producto']['tmp_name']['videos'];

                foreach ($videosAuxiliares as $i => $temporalVideo) {
                    // Verificar si el archivo se subió correctamente
                    if ($_FILES['producto']['error']['videos'][$i] === UPLOAD_ERR_OK) {
                        $nombreVideo = $_FILES['producto']['name']['videos'][$i];
                        // Generar nombre único para cada imagen auxiliar
                        $nombreVideoAuxiliar = md5(uniqid($nombreVideo, true)) . ".mp4";

                        $producto->agregarVideos($nombreVideoAuxiliar);
                    }
                }
            }

            $errores = $producto->validar();

            //Revisar que el arreglo de errores este vacio
            if (empty($errores)) {

                //Crear la carpeta para guardar imagenes_principales
                if (!is_dir(CARPETA_IMAGENES_PRINCIPALES)) {
                    mkdir(CARPETA_IMAGENES_PRINCIPALES);
                }
                if (!is_dir(CARPETA_IMAGENES_AUXILIARES)) {
                    mkdir(CARPETA_IMAGENES_AUXILIARES);
                }
                if (!is_dir(CARPETA_VIDEOS)) {
                    mkdir(CARPETA_VIDEOS);
                }


                $producto->guardar();
                //Guarda la imagen_principal en el servidor
                $image->save(CARPETA_IMAGENES_PRINCIPALES . $nombreImagenPrincipal);

                if ($_FILES['producto']['tmp_name']['imagenes']) {

                    $imagenesAuxiliares = $_FILES['producto']['tmp_name']['imagenes'];
                    foreach ($imagenesAuxiliares as $i => $temporal) {

                        // Generar nombre único para cada imagen auxiliar
                        $nombreImagenAuxiliar = md5(uniqid(rand(), true)) . ".jpg";

                        $producto->agregarImagenAuxiliar($nombreImagenAuxiliar);

                        $imageAuxiliar = Image::make($temporal)->fit(800, 600);

                        //Crea una nueva instancia
                        $imagenesAuxiliares = new Imagenes();

                        $imagenesAuxiliares->productoId = $producto->id;

                        $imagenesAuxiliares->imagen = $nombreImagenAuxiliar;


                        $imagenesAuxiliares->guardar();

                        // Guardar las imagenes auxiliares en el servidor
                        $imageAuxiliar->save(CARPETA_IMAGENES_AUXILIARES . $nombreImagenAuxiliar);
                    }
                }
                if ($_FILES['producto']['tmp_name']['videos']) {

                    $videos = $_FILES['producto']['tmp_name']['videos'];

                    foreach ($videos as $i => $temporalVideo) {

                        // Generar nombre único para cada imagen auxiliar
                        $nombreUnicoVideo = md5(uniqid(rand(), true)) . ".mp4";

                        $producto->agregarVideos($nombreUnicoVideo);

                        //Crea una nueva instancia
                        $videos = new Videos();

                        $videos->productoId = $producto->id;

                        $videos->video = $nombreUnicoVideo;


                        $videos->guardar();

                        // Guardar los videos en el servidor
                        move_uploaded_file($temporalVideo, CARPETA_VIDEOS . $nombreUnicoVideo);
                    }
                }
            }
        }

        $router->render('Productos/crear', [
            'producto' => $producto,
            'categorias' => $categorias,
            'errores' => $errores
        ]);
    }
    public static function actualizar(Router $router)
    {
        $id = validarORedireccionar('/admin');

        $producto = Producto::find($id);
        // Obtener todas las imágenes auxiliares para un producto específico
        $imagenesProducto = Imagenes::findAuxiliar($id);
        // Obtener todos los videos del producto
        $videosProducto = Videos::findAuxiliar($id);

        foreach ($videosProducto as $videoProducto) {

            $producto->videos[] = $videoProducto->video;
        }

        foreach ($imagenesProducto as $imagenProducto) {

            $producto->imagenesAuxiliares[] = $imagenProducto->imagen;
        }

        $imagenesProducto = Imagenes::findAuxiliar($id);

        $videosProducto = Videos::findAuxiliar($id);

        $categorias = Categorias::all();

        $errores = Producto::getErrores();

        //Ejecutar el codigo despues de que el usuario envia el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Asignar los atributos
            $args = $_POST['producto'];

            $producto->sincronizar($args);

            //Validacion
            $errores = $producto->validar();

            //Generae nombre unico
            $nombreImagenPrincipal = md5(uniqid(rand(), true)) . ".jpg";


            //subida de archivos
            if ($_FILES['producto']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['producto']['tmp_name']['imagen'])->fit(800, 600);
                $producto->setImagen($nombreImagenPrincipal);
            }
            if ($_FILES['producto']['tmp_name']['imagenes'] !== [''] && empty($errores)) {

                $producto->borrarImagenes();
                $imagenesProducto = Imagenes::findAuxiliar($id);
                foreach ($imagenesProducto as $imagenProducto) {

                    $imagenProducto->eliminarAuxiliares();
                }
                $imagenesAuxiliares = $_FILES['producto']['tmp_name']['imagenes'];
                foreach ($imagenesAuxiliares as $i => $temporal) {
                    // Verificar si el archivo se subió correctamente

                    $nombre = $_FILES['producto']['name']['imagenes'][$i];
                    // Generar nombre único para cada imagen auxiliar
                    $nombreImagenAuxiliar = md5(uniqid($nombre, true)) . ".jpg";

                    $imageAuxiliar = Image::make($temporal)->fit(800, 600);

                    $producto->agregarImagenAuxiliar($nombreImagenAuxiliar);
                    $imageAuxiliar->save(CARPETA_IMAGENES_AUXILIARES . $nombreImagenAuxiliar);

                    $imagenesProducto = new Imagenes();

                    $imagenesProducto->productoId = $producto->id;

                    $imagenesProducto->imagen = $nombreImagenAuxiliar;

                    $imagenesProducto->guardar();
                }
            }

            if ($_FILES['producto']['tmp_name']['videos'] !== [''] && empty($errores)) {

                $producto->borrarVideos();
                $videosProducto = Videos::findAuxiliar($id);
                foreach ($videosProducto as $videoProducto) {

                    $videoProducto->eliminarAuxiliares();
                }
                $videos = $_FILES['producto']['tmp_name']['videos'];
                foreach ($videos as $i => $temporalVideo) {
                    //Verificar si el archivo se subió correctamente
                    if ($_FILES['producto']['error']['videos'][$i] === UPLOAD_ERR_OK) {
                        $nombreVideo = $_FILES['producto']['name']['videos'][$i];
                        //Generar nombre único para cada imagen auxiliar
                        $nombreUnicoVideo = md5(uniqid($nombreVideo, true)) . ".mp4";

                        $producto->agregarVideos($nombreUnicoVideo);
                        // Guardar la imagen auxiliar en el servidor
                        move_uploaded_file($temporalVideo, CARPETA_VIDEOS . $nombreUnicoVideo);
                    }
                }
            }
            //Revisar que el arreglo de errores este vacio
            if (empty($errores)) {
                if ($_FILES['producto']['tmp_name']['imagen']) {
                    //Almacenar la imagen
                    $image->save(CARPETA_IMAGENES_PRINCIPALES . $nombreImagenPrincipal);
                }
                if ($_FILES['producto']['tmp_name']['imagenes'] !== ['']) {
                    $imagenesAuxiliares = $_FILES['producto']['tmp_name']['imagenes'];
                    // debuguear($imagenesAuxiliares);
                    foreach ($imagenesAuxiliares as $i => $temporal) {
                    }
                }

                if ($_FILES['producto']['tmp_name']['videos'] !== ['']) {

                    $videos = $_FILES['producto']['tmp_name']['videos'];

                    foreach ($videos as $i => $temporalVideo) {

                        // Crea una nueva instancia
                        $videosProducto = new Videos();

                        $videosProducto->productoId = $producto->id;

                        $videosProducto->video = $nombreUnicoVideo;


                        $videosProducto->guardar();
                    }
                }

                $producto->guardar();
            }
        }




        $router->render('/productos/actualizar', [
            'producto' => $producto,
            'errores' => $errores,
            'imagenesProducto' => $imagenesProducto,
            'videosProducto' => $videosProducto,
            'categorias' => $categorias
        ]);
    }
    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {

                $tipo = $_POST['tipo'];

                if (validarTipoContenido($tipo)) {


                    $producto = Producto::find($id);
                    $imagenesAuxiliares = Imagenes::findAuxiliar($id);
                    $videos = Videos::findAuxiliar($id);

                    foreach ($imagenesAuxiliares as $imagenAuxiliar => $valor) {

                        $imagen = $valor->imagen;
                        $producto->imagenesAuxiliares[] = $imagen;
                    }
                    foreach ($videos as $video => $valorVideo) {

                        $video = $valorVideo->video;
                        $producto->videos[] = $video;
                    }

                    $producto->borrarImagenes();
                    $producto->borrarVideos();
                    foreach ($videos as $video) {

                        $video->eliminarAuxiliares();
                    }

                    foreach ($imagenesAuxiliares as $imagenAuxiliar) {

                        $imagenAuxiliar->eliminarAuxiliares();
                    }

                    $producto->eliminar();
                }
            }
        }
    }
}
