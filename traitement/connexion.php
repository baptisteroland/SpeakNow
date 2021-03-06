<?php

$sql = "SELECT * FROM utilisateurs WHERE email=? AND mdp=PASSWORD(?)";

// Etape 1  : preparation
$query = $pdo->prepare($sql);
// Etape 2 : execution : 2 paramètres dans la requêtes !!
$query->execute(array($_POST['email'],$_POST['password']));
// Etape 3 : ici le login est unique, donc on sait que l'on peut avoir zero ou une  seule ligne.

// un seul fetch
$line = $query->fetch();

// Si $line est faux le couple login mdp est mauvais, on retourne au formulaire
if($line == false){
  $_SESSION['erreurlogin'] = 'Identifiant ou mdp invalide !';
  header('Location: index.php?action=accueil#login');
}else{
  if(isset($_POST['checkbox'])){
    $hash = uniqid(true);
    $sqlrem="UPDATE utilisateurs SET remember=? where id=?";
    // Etape 1  : preparation
    $queryrem = $pdo->prepare($sqlrem);
    // Etape 2 : execution : 2 paramètres dans la requêtes !!
    $queryrem->execute(array($hash,$line['id']));
    setcookie('remember', $hash, time()+3600*24*30);
    
  }
  $_SESSION['id'] = $line['id'];
  $_SESSION['nom'] = $line['nom'];
  $_SESSION['prenom'] = $line['prenom'];
  $_SESSION['email'] = $line['email'];
  $_SESSION['avatar'] = $line['avatar'];
  header('Location: index.php?action=mur');
}

// sinon on crée les variables de session $_SESSION['id'] et $_SESSION['login'] et on va à la page d'accueil
