<?php
    if (isset($_POST['idAmi']) && !empty($_POST['idAmi']) && isset($_SESSION['id'])){
        $idAmi=htmlspecialchars($_POST['idAmi']);
        $monid=htmlspecialchars($_SESSION['id']);

        $sql = "UPDATE lien SET etat = 'ami' WHERE idUtilisateur1=? AND idUtilisateur2=?";
        // Etape 1  : preparation
        $query = $pdo->prepare($sql);
        // Etape 2 : execution : 2 paramètres dans la requêtes !!
        $query->execute(array($idAmi,$monid));
        // Etape 3 : ici le login est unique, donc on sait que l'on peut avoir zero ou une  seule ligne.
        header("Location: index.php?action=mur&id=".$idAmi);
    }else{
        header("Location: index.php?action=mur");
    }


?>