<?php
session_start();
include "connect.php"; //ajoute config


if (isset($_GET['id'])) { //si l'id est déclaré c'est bon

    $user_id = $_GET['id']; // def : var : input[id]

    $sql = "SELECT manga.*, auteur.nom FROM manga JOIN auteur ON auteur.id=manga.author_id 
    WHERE manga.id = '$user_id'";

    $result = $db->query($sql); //def : var : Exécute une requête sur la base de données(* users)

    if ($result == TRUE) { //si la db est faite, sa marche !

        $youpi = "Voici les détails";
    } else { //sa marche pas !

        $youpi = "Error:" . $sql . "<br>" . $db->error;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Liste des manga</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
        <main class="conterner">
            <div class="row">
                <div>
    
                    <?php foreach ($result as $all) { 
    
                    } ?>
                </div>
                <section class="col-12">
                    <h1>Détails du manga <?= $all['title'] ?></h1>
                    <p>ID : <?= $all['id'] ?></p>
                    <p>date : <?= $all['date'] ?></p>
                    <p>Auteur : <?= $all['nom'] ?></p>
                    <p><a href="index.php">Retour</a> <a href="edit.php?id=<?= $all['id'] ?>">Modifier</a></p>
                </section>
            </div>
        </main>

    </body>
</html>
<div>