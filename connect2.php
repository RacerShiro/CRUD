<?php
$pdo = new \PDO('mysql:host=localhost;dbname=bibliotheque;charset=utf8', 'root', '');
$auteurs = $pdo->query('SELECT * FROM auteur');