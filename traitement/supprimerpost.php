<?php
if (isset($_POST['id']) && isset($_POST['titre']) && isset($_POST['message']) && isset($_POST['date'])){
    $id=htmlspecialchars($_POST['id']);
    $idconnecte=htmlspecialchars($_SESSION['id']);
    $titre=htmlspecialchars($_POST['titre']);
    $contenu=htmlspecialchars($_POST['message']);
    $date=htmlspecialchars($_POST['date']);

    $sql = 'DELETE FROM ecrit WHERE id=? AND titre=? AND contenu=? AND dateEcrit=? AND idAuteur=?';
    $sql1 = 'DELETE FROM commentaires WHERE idPost=?';
    $sql2 = 'DELETE FROM aime WHERE idEcrit=?';
    // Etape 1  : preparation
    try{
        $query = $pdo->prepare($sql);
        $query1 = $pdo->prepare($sql1);
        $query2 = $pdo->prepare($sql2);
        // Etape 2 : execution : 2 paramètres dans la requêtes !!
        $query->execute(array($id,$titre,$contenu,$date,$idconnecte));
        $query1->execute(array($id));
        $query2->execute(array($id));

        if(isset($_POST['image']) && !empty($_POST['image'])){
            $fichier = './imagesposts/'.$_POST['image'];
            if( file_exists ($fichier)){
            unlink( $fichier ) ;
            }
        }
        if (isset($_POST['murredirection'])){
            header("Location: index.php?action=mur&id=".$_POST['murredirection']);
        }else{
            header("Location: index.php?action=mur");
        }

    } catch (Exception $e) {
        $_SESSION['erreur'] = 'Erreur lors de la suppression du message.';
        }



}

?>