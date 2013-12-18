<?php
class ImagenManager extends FileManager {
  public function convertir($max_ancho = 680, $max_alto = 520, $formato = 'jpg') 
  {
    $archivo_temporal = tempnam(TEMP_DIR, "UNIVERSIU");
  
    $si = new SimpleImage();
    $si->load($this->directorio);
    
    $ancho = $si->getWidth();
    $alto  = $si->getHeight();

    if ($ancho / $max_ancho > $alto / $max_alto) {
      $si->resizeToWidth($max_ancho);
    }
    else {
      $si->resizeToHeight($max_alto);
    }
    
    $si->save($archivo_temporal);
    
    return new ImagenManager($archivo_temporal, true);
  }
}