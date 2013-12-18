<?php


function vista($ruta = false) {
    global $params;
    $ruta = $ruta ? $ruta : $params->controlador;
    $ruta = ROOT . '/vistas/' . $ruta . '.php';
    return $ruta;
}


// Si quieres usar un layout distinto a "general.php"
// llamar a la función layout desde el controlador
function layout($layout = null) {
    static $file = 'general';
    if ($layout !== null) {
        $file = $layout;
    }
    return $file;
}

// Esta función se llama desde el routeador
// Incluye al controlador
// Luego a la vista
// Y luego al layout, que tiene que hacer un "echo $contenido" en algún lado
// Así imprime la vista
// Todos tienen acceso a las mismas variables
function llamar_controlador($archivo_controlador, $params) {
    
    ob_start();
    
    try {
        $vista = (include $archivo_controlador);
        if ($vista !== false) {
            $vista = $vista != 1 ? $vista : $params->controlador;
            
            $vista = ROOT . '/vistas/' . $vista . '.php';
            if (file_exists($vista)) {
                include($vista);
            }
        }
    } catch(Exception $e) {
        ob_flush();
        throw $e;
    }
    
    
    
    $contenido = ob_get_contents();
    ob_end_clean();
    
    $layout = layout();
    
    if ($vista && $layout) {
        $layout_file = ROOT . '/vistas/layouts/' . layout() . '.php';
        if (file_exists($layout_file)) {
            include $layout_file;
        }
        else {
            echo "El layout " . $layout_file . " no existe";
        }
    }
    else {
        echo $contenido;
    }
}
