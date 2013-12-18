<?php 

function error_404($texto = 'Página no encontrada') {
  header('Status: 404 Not Found');
  echo $texto;
  exit;
}

function error_400($texto = 'Petición inválida') {
  header('Status: 400 Bad Request');
  echo $texto;
  exit;
}