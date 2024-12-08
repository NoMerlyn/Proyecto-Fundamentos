<?php
function Conexion(): PDO{
    $server='localhost';
    $usuario="root";
    $clave="";
    try{
        $con=new PDO("mysql:host=".$server."; dbname=sisedu",$usuario,$clave );
    }catch(PDOException $e){
    }
    return $con;
}
?>