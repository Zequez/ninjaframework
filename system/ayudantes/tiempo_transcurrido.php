<?php

function tiempoTranscurrido($desde, $hasta = false) {
  $desde = strtotime($desde);
  if ($hasta) {
    $hasta = strtotime($hasta);
  }
  else {
    $hasta = time();
  }


  $time = $hasta - $desde; // to get the time since that moment

  $tokens = array (
      31536000 => 'año',
      2592000 => 'mes',
      604800 => 'semana',
      86400 => 'día',
      3600 => 'hora',
      60 => 'minuto',
      1 => 'segundo'
  );

  foreach ($tokens as $unit => $text) {
      if ($time < $unit) continue;
      $numberOfUnits = floor($time / $unit);
      return $numberOfUnits . ' ' . (($numberOfUnits>1) ? pluralizar($text) : $text);
  }
}

function pluralizar($texto) {
  return $texto . ((preg_match("/s$/", $texto) == 1) ? 'es' : 's');
}