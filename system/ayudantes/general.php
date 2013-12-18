<?php

ini_set('display_errors', '1');

// Estos define estaban de antes, una vez que
// terminemos de migrar todo al router.php
// se puede sacar
if (!defined('ROOT')) {
    define('ROOT', realpath(dirname(__FILE__) . "/../"));
}

if (!defined('TEMP_DIR')) {
    define('TEMP_DIR', ROOT . '/tmp');
}

require ROOT . 'system/ayudantes/http_status.php';
require ROOT . 'system/ayudantes/asegurar_directorio.php';
require ROOT . 'system/ayudantes/random_string.php';
require ROOT . 'system/ayudantes/tiempo_transcurrido.php';
require ROOT . 'system/ayudantes/rutas.php';
require ROOT . 'system/ayudantes/ayudantes_vistas.php';


require ROOT . 'system/lib/file_manager_class.php';
require ROOT . 'system/lib/imagen_manager_class.php';
require ROOT . 'system/lib/simple_image_class.php';

require ROOT . 'system/lib/base.php';

require ROOT . 'system/lib/params_class.php';
require ROOT . 'system/lib/idiorm_class.php';
require ROOT . 'system/lib/paris_class.php';
require ROOT . 'system/lib/router_class.php';

// Configuración del ORM para los modelos
ORM::configure('mysql:host='.$mysql_datos["host"].';dbname='.$mysql_datos["base"].';names=utf8');
ORM::configure('username', $mysql_datos["usuarioBase"]);
ORM::configure('password', $mysql_datos["claveBase"]);
ORM::get_db()->query("SET NAMES 'utf8'");

// TODO: Autocargar modelos.

session_start();

// Esto ahora se hace desde /router.php, pero como antes
// algunos archivos todavía cargan /ayudantes/general.php diréctamente
// por lo que todavía no lo podemos sacar

function e($texto) {
  return mysql_real_escape_string($texto);
}

function comprobarlogin() {
 if (!isset($_SESSION['ok'])) {
   header("Location: /controladm/login");
   exit;
 }
}

function comprobarseguridad($modulo, $chequeo=false) {

if (!$chequeo) {
  if (!strstr($_SESSION['seguridad'], $modulo)) {
   header("Location: /dash");
   exit;
 }
 
 
} else { 
if (strstr($_SESSION['seguridad'], $modulo)) {
   return true;
 }
}

}


?>
