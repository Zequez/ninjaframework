<?php 

class FileManager
{
  var $directorio;
  var $_formato;
  var $_extension;

  function __construct($directorio, $temporal = false) 
  {
    $this->directorio = realpath($directorio);
    $this->temporal = $temporal;
  }
  
  /**
   * Guarda el archivo en el directorio
   * especificado. Se usa para mover el archivo
   * temporal al directorio final.
  **/
  public function guardar($directorio) 
  {
    if (file_exists($directorio)) {
      unlink($directorio);
    }
    
    $rename_success = rename($this->directorio, $directorio);
    if ($rename_success) {
      $this->directorio = $directorio;
      $this->temporal = false;
      return true;
    }
    else {
        return false;
    }
  }

  
  /** 
   * Llama a leer_formato() si formato no está definido
   * Luego devuelve el formato del archivo
  **/
  public function formato() 
  {
    if (!$this->_formato) {
      $this->leer_formato();
    }
    
    return $this->_formato;
  }
  
  /** 
   * Llama a leer_formato() si la extensión no está definida
   * Luego devuelve la extensión del archivo basada en el formato real
  **/
  public function extension() 
  {
    if (!$this->_extension) {
      $this->leer_formato();
    }
    
    return $this->_extension;
  }
  
  
  /** 
   * Utilizamos una función del sistema para leer el
   * formato REAL del video, ya que al ser enviado
   * por un usuario, no podemos confiar en la extensión
   * del archivo para determinar el formato.
  **/
  private function leer_formato() 
  {    
    exec("file -bi '{$this->directorio}' 2>&1", $output);
    $this->_formato = $output[0];
    $this->_extension = $this->formato_a_extension($this->_formato);
  }
  
 
  
  /**
   * Ej: mp4 => video/mp4 
  **/
  private function extension_a_formato($extension) 
  {
    $tabla = array_flip($this->tabla_extensiones());
    return isset($tabla[$formato]) ? $tabla[$formato] : false;
  }
  
  /**
   *  Ej: video/mp4 => mp4 
  **/
  private function formato_a_extension($formato) 
  {
    $tabla = $this->tabla_extensiones();
    return isset($tabla[$formato]) ? $tabla[$formato] : false;
  }
  
  /**
   * Tabla para convertir extensiones a formatos
  **/
  private function tabla_extensiones() 
  {
    return Array(
      'video/avi' => 'avi', 
      'video/mp4' => 'mp4', 
      'application/octet-stream' => 'flv',
      'image/jpeg' => 'jpg',
      'image/png' => 'png',
      'video/flv' => 'flv',
      'video/x-flv' => 'flv',
      'application/msword' => 'doc',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
      'application/vnd.ms-excel' => 'xls',
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
      'application/vnd.ms-powerpoint' => 'ppt',
      'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
      'application/x-pdf' => 'pdf',
      'application/pdf' => 'pdf',
    );
  }
  
    
  /**
   * Si estábamos trabajando con un archivo temporal,
   * eliminarlo cuando finalizamos el programa.
  **/
  function __destruct() 
  {
    if ($this->temporal) {
      unlink($this->directorio);
    }
  }
}