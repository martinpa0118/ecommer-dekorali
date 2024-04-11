<?php

namespace Controllers;

use MVC\Router;
use Model\Categorias;


class CategoriaController
{
    public static function crear(Router $router)
    {

        $errores = Categorias::getErrores();

        $categoria = new Categorias;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Crear una nueva instancia
            $categoria = new Categorias($_POST['categoria']);

            //Validar que no haya campos vacios
            $errores = $categoria->validar();

            //No hay errores
            if (empty($errores)) {
                $categoria->guardar();
            }
        }

        $router->render('categorias/crear', [
            'errores' => $errores,
            'categoria' => $categoria
        ]);
    }
    public static function actualizar(Router $router)
    {

        $errores = Categorias::getErrores();

        $id = validarORedireccionar('/admin');

        $categoria = Categorias::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Asignar los valores
            $args = $_POST['categoria'];

            //Sincronizar el objeto en memoria con lo que el usuario escribio
            $categoria->sincronizar($args);

            //Validacion
            $errores = $categoria->validar();

            if (empty($errores)) {
                $categoria->guardar();
            }
        }

        $router->render('categorias/actualizar', [
            'errores' => $errores,
            'categoria' => $categoria
        ]);
    }
    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Validar el id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                //Valida el tipo a eliminar
                $tipo = $_POST['tipo'];

                if(validarTipoContenido($tipo)){
                    $categoria = Categorias::find($id);
                    $categoria->eliminar();
                }
            }
        }
    }
}
