<?php
try{
    // Conexion a la base 
    $db = new \PDO('mysql:host=localhost;dbname=bibliotheque;charset=utf8', 'root', '');

    $db-> exec('SET NAMES "UTF8"');
} catch (PDOException $e){
    echo 'Erreur : '. $e->getMessage();
    die();
}

