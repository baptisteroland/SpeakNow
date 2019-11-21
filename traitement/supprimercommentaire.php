<?php
if (isset($_POST['idCommentaire']) && isset($_POST['commentaire']) && isset($_SESSION['id'])){
    $idCommentaire=htmlspecialchars($_POST['idCommentaire']);
    $commentaire=htmlspecialchars($_POST['commentaire']);
    $monid=htmlspecialchars($_SESSION['id']);
    $idPost=htmlspecialchars($_POST['idpost']);

    $sql = 'DELETE FROM commentaires WHERE id=? AND commentaire=? AND idAuteur=?';
    // Etape 1  : preparation
    try{
        $query = $pdo->prepare($sql);
        // Etape 2 : execution : 2 paramètres dans la requêtes !!
        $query->execute(array($idCommentaire,$commentaire,$monid));
        if(isset($_POST['murredirection'])){
            $redir=$_POST['murredirection'];
            header("Location: index.php?action=mur&id=".$redir."#post".$idPost);
            }else if(isset($_POST['filredirection'])){
                header("Location: index.php?action=fil#post".$_POST['idpost']);
            }else{
                header("Location: index.php?action=mur");
            }

    } catch (Exception $e) {
        $_SESSION['erreur'] = 'Erreur lors de la suppression du comentaire.';
        }
}else{
    header("Location: index.php?action=mur");
}