<?php
// On démarre une session
session_start();

require_once('connect2.php');

if($_POST){
    if(isset($_POST['id']) && !empty($_POST['id'])
    && isset($_POST['title']) && !empty($_POST['title'])
    && isset($_POST['date']) && !empty($_POST['date'])
    && isset($_POST['author_id']) && !empty($_POST['author_id'])){
        // On inclut la connexion à la base.
        require_once('connect.php');

        // On nettoie les données envoyées
        $id = strip_tags($_POST['id']);
        $title = strip_tags($_POST['title']);
        $date = strip_tags($_POST['date']);
        $author_id = strip_tags($_POST['author_id']);

        $sql = 'UPDATE `manga` SET `title`=:title, `date`=:date, `author_id`=:author_id WHERE `id`=:id;';

        $query = $db->prepare($sql);

        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':title', $title, PDO::PARAM_STR);
        $query->bindValue(':date', $date, PDO::PARAM_STR);
        $query->bindValue(':author_id', $author_id, PDO::PARAM_INT);

        $query->execute();

        $_SESSION['message'] = "Manga modifié";
        require_once('close.php');

        header('Location: index.php');
    }else{
        $_SESSION['erreur'] = "Le formulaire est incomplet";
    }
}

// Est-ce que l'id existe et n'est pas vide dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');

    // On nettoie l'id envoyé
    $id = strip_tags($_GET['id']);

    $sql = 'SELECT * FROM `manga` WHERE `id` = :id;';

    // On prépare la requête
    $query = $db->prepare($sql);

    // On "accroche" les paramètre (id)
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // On exécute la requête
    $query->execute();

    // On récupère le produit
    $produit = $query->fetch();

    // On vérifie si le produit existe
    if(!$produit){
        $_SESSION['erreur'] = "Cet id n'existe pas";
        header('Location: index.php');
    }
}else{
    $_SESSION['erreur'] = "URL invalide";
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Manga</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                    if(!empty($_SESSION['erreur'])){
                        echo '<div class="alert alert-danger" role="alert">
                                '. $_SESSION['erreur'].'
                            </div>';
                        $_SESSION['erreur'] = "";
                    }
                ?>
                <h1>Modifier un Manga</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" id="title" name="title" class="form-control" value="<?= $produit['title']?>">
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="number" min="1900" max="2099" step="1" id="date" name="date" class="form-control" value="<?= $produit['date']?>">

                        <br></br>

                        <label for="author-select">Choisi un auteur</label>
                        <select name="author_id" id="nom">
                        <option value="">--choisisez une option--</option>
                    <?php
                        foreach ($auteurs as $auteur) {
                        echo '<option value="' . $auteur['id'] . '">' . $auteur['nom'] . '</option>';
                        }
                    ?> 
                        </select>

                        <br></br>

                    <input type="hidden" value="<?= $produit['id']?>" name="id">
                    <button class="btn btn-primary">Envoyer</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>