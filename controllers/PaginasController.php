<?php

namespace Controllers;

use MVC\Router;
use Model\Videos;
use Model\Imagenes;
use Model\Producto;
use Model\Categorias;
use PHPMailer\PHPMailer\PHPMailer;


class PaginasController
{

    public static function index(Router $router)
    {
        $productos = Producto::get(3);
        $categorias = Categorias::get(3);
        $inicio = true;

        $router->render('paginas/index', [
            'productos' => $productos,
            'categorias' => $categorias,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros', []);
    }
    public static function productos(Router $router)
    {

        $productos = Producto::all();
        $router->render('paginas/productos', [
            'productos' => $productos
        ]);
    }
    public static function categorias(Router $router)
    {

        $categorias = Categorias::all();
        $router->render('paginas/productos', [
            'productos' => $productos
        ]);
    }
    public static function producto(Router $router)
    {
        $id = validarORedireccionar('/productos');

        //buscar la propiedad
        $producto = Producto::find($id);

        // Obtener todas las imágenes auxiliares para un producto específico
        $imagenesProducto = Imagenes::findAuxiliar($id);
        // Obtener todos los videos del producto
        $videosProducto = Videos::findAuxiliar($id);

        foreach ($videosProducto as $videoProducto) {

            $producto->videos[] = $videoProducto->video;
        }
        $primerVideo = array_shift($videosProducto);

        


        foreach ($imagenesProducto as $imagenProducto) {

            $producto->imagenesAuxiliares[] = $imagenProducto->imagen;
        }
        $primeraImagen = array_shift($imagenesProducto);

        $router->render('paginas/producto', [
            'producto' => $producto
        ]);
    }
    public static function blog(Router $router)
    {
        $router->render('paginas/blog', []);
    }
    public static function login(Router $router)
    {

        $router->render('paginas/login', []);
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada', []);
    }
    public static function contacto(Router $router)
    {
        $mensaje = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $respuestas = $_POST['contacto'];

            //Crear una instancia de PHPMailer
            $phpmailer = new PHPMailer();
            //Configurar SMTP
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = '6eddcdc49d442c';
            $phpmailer->Password = '0f728ee04d7619';


            //Configurar el contenido del email
            $phpmailer->setFrom('admin@bienesraices.com');
            $phpmailer->addAddress('admin@bienesraices.com', 'BienesRaices.com');
            $phpmailer->Subject = 'Tienes un nuevo mensaje';

            //Habilitar HTML

            $phpmailer->isHTML(true);
            $phpmailer->CharSet = 'UTF-8';

            //Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: '  . $respuestas['nombre'] . '</p>';
            

            //Enviar de forma condicional respuestas
            if($respuestas['contacto'] === 'telefono'){
                $contenido .= '<p>Eligió ser contactado por Teléfono:</p>';
                $contenido .= '<p>Teléfono: '  . $respuestas['telefono'] . '</p>';
                $contenido .= '<p>Fecha Contacto: '  . $respuestas['fecha'] . '</p>';
                $contenido .= '<p>Hora: '  . $respuestas['hora'] . '</p>';
            }else{
                $contenido .= '<p>Eligió ser contactado por E-mail:</p>';
                $contenido .= '<p>Email: '  . $respuestas['email'] . '</p>';
            }
            
            $contenido .= '<p>Mensaje: '  . $respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o Compra: '  . $respuestas['tipo'] . '</p>';
            $contenido .= '<p>Precio o Presupuesto: $'  . $respuestas['precio'] . '</p>';
            $contenido .= '<p>Prefiere ser contactado por: '  . $respuestas['contacto'] . '</p>';

            $contenido .= '</html>';

            $phpmailer->Body = $contenido;
            $phpmailer->AltBody = 'Esto es texto alternativo sin HTML';

            //Enviar el email
            if ($phpmailer->send()) {
                $mensaje =  "mensaje enviado correctamente.. ";
            } else {
                $mensaje =  "el mensaje no se pudo enviar..";
            }
        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}
