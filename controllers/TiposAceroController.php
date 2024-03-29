<?php

namespace Controllers;

use Model\CategoriaAcero;
use Model\DescripcionAcero;
use Model\TiposAceros;
use MVC\Router;

class TiposAceroController
{
    public static function index(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $nombre = $_GET['nombre'] ?? '';
        $aceros = [];

        if ($nombre) {

            $aceros = TiposAceros::filtrar('nombre', $nombre);
        } else {

            $categoriaFiltrada = $_GET['categoria'] ?? '';

            if ($categoriaFiltrada) {
                $respuesta = CategoriaAcero::find($categoriaFiltrada);
                if (!$respuesta || !filter_var($categoriaFiltrada, FILTER_VALIDATE_INT)) {
                    header('Location:/admin/index');
                }
            }



            $aceros = TiposAceros::belongsToAndOrden('categoriaacero_id', $categoriaFiltrada, 'descripcionacero_id', 'ASC');
        }


        $categorias = CategoriaAcero::ordenar('id', 'ASC');
        $acerosAll = TiposAceros::all();


        //Se eliminan aquellas categorias de acero que no están asociadas a ningún tipo de Acero
        $categoriasMostrar = [];
        foreach ($acerosAll as $acero) {
            $categoriasMostrar[] = $acero->categoriaacero_id;
        }


        foreach ($categorias as $key => $categoria) {
            if (!in_array($categoria->id, $categoriasMostrar)) {
                unset($categorias[$key]);
            }
        }



        //Se agrupan los tipos de acero por categoria de acero en un arreglo asociativo.
        $acerosFormateados = [];
        foreach ($aceros as $acero) {
            $acero->categoria = CategoriaAcero::find($acero->categoriaacero_id);
            $acero->descripcion = DescripcionAcero::find($acero->descripcionacero_id);

            $acerosFormateados[$acero->categoriaacero_id][] = $acero;
        }




        $router->render('admin/aceros/index', [
            'titulo' => 'Tipos de Acero',
            'aceros' => $acerosFormateados,
            'categorias' => $categorias,
            'href' => '/admin/acero/crear',
            'mensaje_boton' => ' Agregar Tipo',
            'mensaje_select' => 'Seleccione una Categoria'
        ]);
    }

    public static function crear(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();

        $alertas = [];
        $acero = new TiposAceros();
        $categorias = CategoriaAcero::all();
        $descripciones = DescripcionAcero::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $_POST['nombre'] = trim(strtoupper($_POST['nombre']));

            $acero->sincronizar($_POST);
            $alertas = $acero->validar();

            if (empty($alertas)) {


                $nombre = TiposAceros::where('nombre', $acero->nombre);

                if ($nombre) {
                    TiposAceros::setAlerta('error', 'Ya Hay Un Producto Con Ese Nombre');
                } else {
                    $aceroBase = TiposAceros::find('1');

                    if ($acero->prolamsa >= $acero->arcoMetal) {
                        $acero->slp = $aceroBase->slp + $acero->prolamsa;
                    } else if ($acero->prolamsa < $acero->arcoMetal) {
                        $acero->slp = $aceroBase->slp + $acero->arcoMetal;
                    }

                    $resultado = $acero->guardar();
                    if ($resultado) {
                        header('Location:/admin/acero');
                    }
                }
            }
        }

        $alertas = TiposAceros::getAlertas();
        $router->render('admin/aceros/crear', [
            'titulo' => 'Tipos de Acero',
            'alertas' => $alertas,
            'acero' => $acero,
            'categorias' => $categorias,
            'descripciones' => $descripciones
        ]);
    }

    public static function actualizar(Router $router)
    {

        session_start();
        isAuth();
        isAdmin();

        if (filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
            $id = $_GET['id'];
        }

        $acero = TiposAceros::find($id);
        $nombreActual = $acero->nombre;

        if (!$acero) {
            header('Location:/admin/acero');
        }

        $categorias = CategoriaAcero::all();
        $descripciones = DescripcionAcero::all();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $_POST['nombre'] = trim(strtoupper($_POST['nombre']));
            $acero->sincronizar($_POST);

            $alertas = $acero->validar();
            if (empty($alertas)) {

                $nombre = TiposAceros::where('nombre', $acero->nombre);

                if ($nombre && $nombre->nombre != $nombreActual) {
                    TiposAceros::setAlerta('error', 'Ya Hay Un Producto Con Ese Nombre');
                } else {
                    $resultado = $acero->guardar();
                    if ($resultado) {
                        header('Location:/admin/acero');
                    }
                }
            }
        }

        $alertas = TiposAceros::getAlertas();
        $router->render('admin/aceros/actualizar', [
            'titulo' => 'Actualizar Registro',
            'acero' => $acero,
            'alertas' => $alertas,
            'categorias' => $categorias,
            'descripciones' => $descripciones
        ]);
    }

    public static function eliminar(Router $router)
    {
        session_start();
        isAuth();
        isAdmin();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            if (empty($id)) {
                echo json_encode([
                    'tipo' => 'error',
                    'mensaje' => 'Ha Ocurrido Un Error!'
                ]);
                exit;
            }

            $acero = TiposAceros::find($id);
            $resultado = $acero->eliminar();

            if ($resultado) {
                echo json_encode([
                    'tipo' => 'exito',
                    'mensaje' => 'Registro Eliminado Correctamente!'

                ]);
            }
        }
    }
}
