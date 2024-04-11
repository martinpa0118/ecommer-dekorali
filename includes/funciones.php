<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES_PRINCIPALES', $_SERVER['DOCUMENT_ROOT'] . '/imagenesPrincipales/');
define('CARPETA_IMAGENES_AUXILIARES', $_SERVER['DOCUMENT_ROOT'] . '/imagenesAuxiliares/');
define('CARPETA_VIDEOS', $_SERVER['DOCUMENT_ROOT'] . '/videos/');

function incluirTemplate($nombre, $inicio = false)
{
    include TEMPLATES_URL . "/$nombre.php";
}

function estaAutenticado(): bool
{
    session_start();

    if (!$_SESSION['login']) {
        header('Location: /');
    }

    return false;
}

function debuguear($variable)
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//Escapa / Sanitizar el HTML

function s($html)
{
    $s = htmlspecialchars($html);
    return $s;
}
//Validar tipo de contenido
function validarTipoContenido($tipo)
{
    $tipos = ['categoria', 'producto'];
    return in_array($tipo, $tipos);
}

//Muestra los mensajes

function mostrarNotificacion($codigo)
{
    $mensaje = '';

    switch ($codigo) {
        case 1:
            $mensaje = 'Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado Correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}

function validarORedireccionar(string $url)
{
    //Validar URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header("Location: $url");
    }
    return $id;
}
