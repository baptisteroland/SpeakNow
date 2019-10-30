<?php
include("config/config.php");
include("config/bd.php"); // commentaire
include("divers/balises.php");
include("config/actions.php");
session_start();
ob_start(); // Je démarre le buffer de sortie : les données à afficher sont stockées
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mini Facebook</title>

    <!-- Bootstrap core CSS 
    <link href="./css/bootstrap.min.css" rel="stylesheet">-->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug 
    <link href="./css/ie10.css" rel="stylesheet">-->
    
    <!-- Ma feuille de style à moi -->
    <link href="./css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <!-- Si jamais un message info est stocké dans une variable de session, on l'affiche -->
    <?php
    if (isset($_SESSION['erreur'])) {
        echo "<div class='alert alert-info alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span></button>
            <strong>Information : </strong> " . $_SESSION['erreur'] . "</div>";
        unset($_SESSION['erreur']);
    }
    ?>
    <!-- Définition du header, commun à toutes les pages-->
    <?php if (!isset($_SESSION['id'])){
        echo '<header>
        <div class="logo"><a href="index.php?action=accueil"><img src="img/logo.png"></a></div>';
        include("vues/login.php");
        echo '</header>';
        }else{
            $avatar=$_SESSION['avatar'];
            $prenom=$_SESSION['prenom'];
            echo "<header class='headerconnecte'>
                <div class='headergauche'>
                    <div class='logo'><a href='index.php?action=accueil'><img src='img/logo.png'></a></div>
                    <div class='recherche'><form action='index.php' method='GET'><input type='hidden' name='action' value='recherche'><input name='texterecherche' type='text' placeholder='Rechercher...' required><input type='submit' value=' '></form></div>
                </div>
                <div class='headercentre'>
                    <a href='index.php?action=mur'><i class='fas fa-home'></i></a>
                    <a href='index.php?action=profil'><i class='fas fa-cog'></i></a>
                    <a href='index.php?action=deconnexion'><i class='fas fa-sign-out-alt'></i></a>
                </div>
                <div class='headerdroite'>
                    <div class='imageprofil'><a href='index.php?action=mur'><img class='avatarmenu' src='avatars/$avatar'></a></div>
                </div>
                
            </header>";
        }
    ?>

<!--<div class="container-fluid">
    <div class="row">
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="main">-->
            <?php
            // Quelle est l'action à faire ?
            if (isset($_GET["action"])) {
                $action = $_GET["action"];
            } else {
                $action = "accueil";
            }

            // Est ce que cette action existe dans la liste des actions
            if (array_key_exists($action, $listeDesActions) == false) {
                include("vues/404.php"); // NON : page 404
            } else {
                include($listeDesActions[$action]); // Oui, on la charge
            }

            ob_end_flush(); // Je ferme le buffer, je vide la mémoire et affiche tout ce qui doit l'être
            ?>

        <!--</div>
    </div>
</div>-->
<!-- <footer></footer>-->
</body>
</html>
