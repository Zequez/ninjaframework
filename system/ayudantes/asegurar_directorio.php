<?php

function asegurar_directorio($directorio) {
  if (!is_dir($directorio)) { 
    exec("mkdir -p '{$directorio}'");
  }
  
  return realpath($directorio);
}