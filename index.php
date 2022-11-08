<?php
// on démarre une session
session_start();

// connexion a la base
require_once('connect.php');

$sql = 'SELECT manga.*, auteur.nom FROM manga JOIN auteur ON auteur.id=manga.author_id';

//préparation de la requete
$query = $db->prepare($sql);

//éxecution de la requete
$query->execute();

// stockage du résultat dans un tableau
$result = $query->fetchAll(PDO::FETCH_ASSOC);

require_once('close.php');
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
    <main class="container">
        <div classe="row">
            <section class="col-12">
            <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <?php
                    if(!empty($_SESSION['message'])){
                        echo '<div class="alert alert-success" role="alert">
                                '. $_SESSION['message'].'
                            </div>';
                        $_SESSION['message'] = "";
                    }
                ?>
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Date</th>
                        <th>Auteur</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php
                        // On boucle sur la variable result
                        foreach($result as $produit){
                        ?>
                            <tr>
                                <td><?= $produit['id'] ?></td>
                                <td><?= $produit['title'] ?></td>
                                <td><?= $produit['date'] ?></td>
                                <td><?= $produit['nom'] ?></td>
                                <td><a href="details.php?id=<?= $produit ['id'] ?> " class="btn btn-success">Voir</a>  
                                    <a href="edit.php?id=<?= $produit ['id'] ?> " class="btn btn-warning">Modifier</a>
                                    <a href="delete.php?id=<?= $produit ['id'] ?> " class="btn btn-danger">Supprimer</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <a href="add.php" class="btn btn-primary">Ajouter un manga</a>
            </section>
        </div>
    </main>
</body>
</html>