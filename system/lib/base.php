<?php
function conexion_mysql() { 
	
$Base = "test";
$UsuarioBase = "root";
$ClaveBase = "";
$host = "localhost";

	
	if (!($conexion=mysql_connect($host,$UsuarioBase,$ClaveBase))) {  
	
	echo "Error conectando a la base de datos.";
	       exit();  
		   }
	if (!(mysql_select_db($Base,$conexion))) {   
		echo "Error seleccionando la base de datos.";  
		echo mysql_error();
	exit();   }    
	mysql_query('SET NAMES \'utf8\'');
	return $conexion; 
	
	}

function bdd_insertar($texto)
{
	$res = mysql_query($texto);

	return TRUE;
}

function bdd_insertar_report($texto)
{
  echo $texto;
	$res = mysql_query($texto);

	return TRUE;
}

function bdd_consulta($texto)
{
	$res = mysql_query($texto);
	if (mysql_num_rows($res)>0) {
	$arr = array();
	while($row=mysql_fetch_array($res))
	{
	$arr[]=$row;
	}
	return $arr;} else {return false;}
}

function bdd_consulta_assoc($texto)
{
	$res = mysql_query($texto);
	if (mysql_num_rows($res)>0) {
	$arr = array();
	while($row=mysql_fetch_assoc($res))
	{
	$arr[]=$row;
	}
	return $arr;} else {return false;}
}

function bdd_consulta_object($texto)
{
	$res = mysql_query($texto);
	if (mysql_num_rows($res)>0) {
	$arr = array();
	while($row=mysql_fetch_object($res))
	{
	$arr[]=$row;
	}
	return $arr;} else {return false;}
}

function bdd_consulta_report($texto)
{
	echo $texto;
	$res = mysql_query($texto);
	$arr = array();
	while($row=mysql_fetch_array($res))
	{
	$arr[]=$row;
	}
	echo "<pre>";print var_dump($arr);echo "</pre>";
	return $arr;
}



$conexion=conexion_mysql();

?>
