<?php

ini_set('display_errors', '1');

// Definimos una constante con la raíz de la aplicación
define('ROOT', dirname(dirname(__FILE__)) . '/');

include ROOT . 'config.php';
include ROOT . 'rutas.php';

include ROOT . 'system/ayudantes/general.php';

$router = new Router($rutas);

// Desde acá, hacemos un matching de las rutas
$ruta = $_REQUEST['ruta'];

// Router#match devuelve un array con el archivo y los parámetros nuevos
// si la URL existe, de lo contrario devuelve false
list($archivo, $params) = $router->match($ruta);

if ($archivo) {
    $params = new Params($params);
    llamar_controlador($archivo, $params);
}
else {
    error_404();
}
