<?php

class Router {
    var $rutas_definidas;
    var $ayudantes_rutas;
    var $rutas_regex;
    
    function __construct($rutas) {
        $this->rutas_definidas = $rutas;
        $this->definir_regex();
        $this->definir_ayudantes();
        $this->definir_funciones_ayudantes();
    }
    
    function definir_regex() {
        $this->rutas_regex = Array();
        
        foreach ($this->rutas_definidas as $ruta => $controlador) {
            // Definimos las expresiones regulares de las rutas
            $regex = "/^" . str_replace('/', '\/', preg_replace("/:([^\/]+)/", "(?P<$1>[^/]+)", $ruta)) . "$/";
            $this->rutas_regex[$regex] = $controlador;
        }
    }
    
    function definir_ayudantes() {
        $this->ayudantes_rutas = Array();
    
        foreach ($this->rutas_definidas as $ruta => $controlador) {        
            // Todos los ayudantes comienzan con "url_" y las barras
            // que separan los directorios de los controladores
            // se convierten en guiones bajos
            $nombre_ayudante = "url_" . str_replace(Array('.', '-', '/'), '_', $controlador);
            
            // En caso de que haya dos rutas que lleven al mismo
            // controlador, las rutas subsiguientes se definen
            // como "url_ruta_2", "url_ruta_3", etc
            $i = 1;
            while (array_key_exists($nombre_ayudante, $this->ayudantes_rutas) || 
                   array_key_exists("_{$nombre_ayudante}", $this->ayudantes_rutas)) {
                ++$i;
                $nombre_ayudante = "{$nombre_ayudante}_{$i}";
            }
            
            // Le agregamos un _ al principio si la función ya existe
            // de esta manera podemos extenderla manualmente si queremos
            // hacerla más simple o más compleja
            if (function_exists($nombre_ayudante)) {
                $nombre_ayudante = "_{$nombre_ayudante}";
            }
            
            // Buscamos todos los parámetros de las rutas
            preg_match_all('/:[^\/]+/', $ruta, $matches);
            $args = $matches[0];
            
            // Guardamos el ayudante en un array, para luego definir una
            // función global ayudante
            $this->ayudantes_rutas[$nombre_ayudante] = Array($args, $ruta);
        }
    }
    
    // Tenemos que hacer un eval() sí o sí
    // Sorry. Es jodida esta función jaja.
    function definir_funciones_ayudantes() {
        $f = '';
        
        foreach ($this->ayudantes_rutas as $nombre => $args_ruta) {
            list($args, $ruta) = $args_ruta;
            $args_vars = str_replace(':', '$', join($args, ', '));
            $params = "array('" . join($args, "','") . "')";
            
            $f .= "function {$nombre}({$args_vars}){" . PHP_EOL;
            $f .= "\$url = '/{$ruta}';" . PHP_EOL;
            foreach ($args as $arg) {
                $var = str_replace(':', '$', $arg);
                $f .= "\$url = str_replace('{$arg}', {$var}, \$url);" . PHP_EOL;
            }
            $f .= 'return $url;' . PHP_EOL;
            $f .= '}' . PHP_EOL;
            
            
        }
        
        eval($f);
    }
    
    function match($ruta) {
        $ruta = preg_replace('/^\/|\/$/', '', $ruta);
        
        
        if (count($this->rutas_regex) > 0) {
            // Matcheamos las rutas definidas con la ruta del usuario
            // Si encontramos una que matchea, entonces cortamos el foreach
            foreach ($this->rutas_regex as $regex => $controlador) {
                if (preg_match($regex, $ruta, $matches) == 1) {
                    break;
                }
            }
            
            // Si la ruta existe, devolver el archivo del controlador
            // y los parámetros nuevos
            if (count($matches) > 0) {

                foreach($matches as $key => $var){ 
                    if(is_numeric($key)){ 
                        unset($matches[$key]); 
                    }
                }
                
                $params = $matches;
                
                // Agregamos el controlador a los parametros
                $params["controlador"] = $controlador;
                
                $archivo = "controladores/{$controlador}.php";
                
                return Array($archivo, $params);
            }
        }
        
        return false;
    }
}