<?php
$host="localhost";
$bd = "sitio";
$usuario = "root";
$password = "root";

try {

        $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $password);
       

} catch(Exception $ex) {
           echo $ex->getMessage();   
}
?>