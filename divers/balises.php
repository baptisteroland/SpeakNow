<?php

function gras($v) {
    return "<b>$v</b>";

}

function options($attributes) {
    $o = "";
    foreach ($attributes as $attr => $v) {
        $o = $o . "$attr='$v'";
    }
    return $o;
}

function lien($link, $texte, $attributes = array()) {
    $o = "";
    foreach ($attributes as $attr => $v) {
        $o = $o . "$attr='$v'";
    }
    return "<a href='$link' $o>$texte</a>";
}

function item($contenu, $attributes = array()) {
    $o = options($attributes);
    return "<li $o>$contenu</li>";
}

function table($table2Dim) {
    $tmp = "";
    foreach ($table2Dim as $table1Dim) {  // Je parcours ma table à 2 Dim, chaque entréee est
        // une table à 1 dim
        $tmp = $tmp . "<tr>"; // J'ai donc une nouvelle ligne
        foreach ($table1Dim as $cellule) { // Chaque entrée de la table à 1 dim est une donnée
            $tmp = $tmp . "<td>$cellule</td>"; // Je la met entre td!
        }

        $tmp = $tmp . "</tr>"; // Je dois fermer la ligne

    }

    return $tmp;
}

function message($msg) {
    $_SESSION['info'] = $msg;
}

//Affichage du bouton like
function formlike($idpost,$typebouton,$nblike){
    echo "<form>
            <label id='labellike$idpost' for='like$idpost'><i class='fas fa-thumbs-up $typebouton'>$nblike</i></label>
            <input id='like$idpost' type='submit' class='inputlike' data-like='$idpost'>
            </form><br><br>";
}

//Ajout commentaire
function formajoutcommentaire($idpost,$idredirection){
    echo '<form method="post" class="formcomm" data-idpost="'.$idpost.'">
         <img class="imgpost" src="avatars/'.$_SESSION['avatar'].'">
        <textarea name="comm" placeholder="Votre commentaire..." class="autoExpand" rows="1" data-min-rows="1"></textarea>
        <input type="hidden" name="idpost" value="'.$idpost.'">
        <input type="submit" value="" name="submit" id="submit'.$idpost.'"><label for="submit'.$idpost.'"><i class="fas fa-paper-plane"></i></label>
    </form>';
}
//Suppression commentaire
function formsupprimercommentaire($idpost,$idcomm){
    echo '<form>
        <label for="supprimercomm'.$idcomm.'"><i class="fas fa-times"></i></label>
        <input type="submit" value="" id="supprimercomm'.$idcomm.'" class="inputsupprimercomm" data-idpost="'.$idpost.'" data-idcomm="'.$idcomm.'">                                
        </form>';
}
//Affichage erreurs liees aux commentaires
function alertecomm($lineid){
    if(isset($_SESSION['alertecomm'.$lineid])){
        echo $_SESSION['alertecomm'.$lineid];
        unset($_SESSION['alertecomm'.$lineid]);
    }
}
//Suppression post
function formsupprimerpost($id,$titre,$lieuredirection,$idredirection,$contenu,$image,$date){
    echo '<form method="post" action="index.php?action=supprimerpost">
                    <input type="hidden" name="id" value="'.$id.'">
                    <input type="hidden" name="titre" value="'.$titre.'">
                    <input type="hidden" name='.$lieuredirection.' value="'.$idredirection.'">
                    <input type="hidden" name="message" value="'.$contenu.'">';
                    if(isset($image) && !empty($image)){
                        echo '<input type="hidden" name="image" value="'.$image.'">';
                    }
                echo '<input type="hidden" name="date" value="'.$date.'">
                    <label for="supprimer'.$id.'"><i class="fas fa-times"></i></label>
                    <input type="submit" value="" id="supprimer'.$id.'">
                    </form>';
}

//Ajout post
function formajoutpost($idpers,$prenompers){
    echo "<div class='poster'><form enctype='multipart/form-data' class='formposter' action='index.php?action=poster' method='post'>";
    if(!empty($prenompers)){
        echo "<h3>Ecrire un message à $prenompers</h3>";
    }else{
        echo "<h3>Nouveau speak</h3>";
    }
    echo "<input type='text' name='titre' placeholder='Titre...'";
    if(isset($_SESSION['titre'])){
        echo "value='".$_SESSION['titre']."'";
        unset($_SESSION['titre']);
    } 
    echo ">
    <input type='hidden' name='idpers' value='$idpers'>
    <textarea name='message' placeholder='Message...'>";
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    } 
    echo "</textarea>
    <div class='uploadimage'>
        <label class='uploadfile' for='image'><i class='fas fa-image'></i></label>
        <div class='cacherbtnfile'>
            <input type='file' name='photo' id='image' class='inputfile' onchange='loadFile(event)'>
        </div>
    </div>
    <div class='apercuimage'><img src='' alt='Aperçu de l'image sélectionnée' id='apercuimg'></div>
    <input type='submit' value='Speaker'>
</form></div>";
}

//Afficher boutons accepter/refuser pour les demandes recues
function demandesrecues($idpers,$avatarpers,$prenompers,$nompers){
    echo '<div class="ami"><a href="index.php?action=mur&id='.$idpers.'"><img class="imgami" src="avatars/'.$avatarpers.'"></a><a href="index.php?action=mur&id='.$idpers.'"><p>'.$prenompers.' '.$nompers.'</p></a>';
            echo '<div class="recuesetenv"><form method="post" action="index.php?action=ajoutami">
                        <input type="hidden" name="idAmi" value="'.$idpers.'">
                        <input type="submit" value="Accepter">
                        </form>
                        <form method="post" action="index.php?action=refusami">
                        <input type="hidden" name="idAmi" value="'.$idpers.'">
                        <input type="submit" value="Refuser">
                        </form></div></div>';
}

//Afficher bouton annuler ajout pour les demandes envoyees
function demandeenvoyees($idpers,$avatarpers,$prenompers,$nompers,$dp){
    echo '<div class="ami"><a href="index.php?action=mur&id='.$idpers.'"><img class="imgami" src="avatars/'.$avatarpers.'"></a><a href="index.php?action=mur&id='.$idpers.'"><p>'.$prenompers.' '.$nompers.'</p></a>';
            echo '<form method="post" action="index.php?action=annulerajout">
                        <input type="hidden" name="idAmi" value="'.$idpers.'">
                        <input type="hidden" name="a" value="'.$dp.'">
                        <input type="submit" value="Annuler">
                        </form></div>';
}

//Afficher un post
function afficherpost($idpost,$idauteur,$avatarauteur,$prenomauteur,$nomauteur,$dateecrit,$idsession,$titre,$contenu,$image,$date,$idredirection){
    echo '<div class="postmur" id="post'.$idpost.'">
    <div class="auteur"><div><a href="index.php?action=mur&id='.$idauteur.'"><img class="imgpost" src="avatars/'.$avatarauteur.'">
    <div><p>'.$prenomauteur.' '.$nomauteur.'</p></a><p>'.$dateecrit.'</p></div></div>
    <div>';
    if($idauteur == $idsession){
        formsupprimerpost($idpost,$titre,"murredirection",$idredirection,$contenu,$image,$date);
    }
    echo '</div></div>
    <p class="titrepost">'.$titre.'</p><br>
    <p>'.$contenu.'</p>';
}

//Afficher les posts écrits par moi ou mes amis sur notre propre mur
function afficherpostfil($idpost,$idauteur,$avatarauteur,$prenomauteur,$nomauteur,$dateecrit,$idsession,$titre,$contenu,$image,$date,$idredirection){
    echo '<div class="postmur" id="post'.$idpost.'">
    <div class="auteur"><div><a href="index.php?action=mur&id='.$idauteur.'"><img class="imgpost" src="avatars/'.$avatarauteur.'">
    <div><p>'.$prenomauteur.' '.$nomauteur.'</p></a><p>'.$dateecrit.'</p></div></div>
    <div>';
    if($idauteur == $idsession){
        formsupprimerpost($idpost,$titre,"filredirection",$idredirection,$contenu,$image,$date);
    }
    echo '</div></div>
    <p class="titrepost">'.$titre.'</p><br>
    <p>'.$contenu.'</p>';
}

//Afficher les posts écrits par une autre personne sur mon mur ou celui de mes amis
function afficherpostfil2($idpost,$idauteur,$avatarauteur,$prenomauteur,$nomauteur,$dateecrit,$idsession,$titre,$contenu,$image,$date,$idredirection,$iddest,$prenomdest,$nomdest){
    echo '<div class="postmur" id="post'.$idpost.'">
    <div class="auteur"><div><a href="index.php?action=mur&id='.$idauteur.'"><img class="imgpost" src="avatars/'.$avatarauteur.'">
    <div>';
    if($idauteur == $idsession){
        echo '<p class="infosbold">'.$prenomauteur.' '.$nomauteur.'</p>';
    }else{
        echo'<p>'.$prenomauteur.' '.$nomauteur.'</p>';
    }
    echo '</a><a href="index.php?action=mur&id='.$iddest.'">';
    if ($iddest==$idsession){
        echo '<p class="infosbold">> '.$prenomdest.' '.$nomdest.'</p></a><p>'.$dateecrit.'</p></div></div>
    <div>';
    }else{
        echo '<p>> '.$prenomdest.' '.$nomdest.'</p></a><p>'.$dateecrit.'</p></div></div>
    <div>';
    }
    if($idauteur == $idsession){
        formsupprimerpost($idpost,$titre,"filredirection",$idredirection,$contenu,$image,$date);
    }
    echo '</div></div>
    <p class="titrepost">'.$titre.'</p><br>
    <p>'.$contenu.'</p>';
}

//Entrée pour envoyer un MP
function formMP($idPers){
    echo '<form onsubmit="envoi();return false;" id="formMP">
                <input type="text" id="messageMP" name="message" placeholder="Votre message...">
                <input type="hidden" id="idAmiMP" name="idAmiMP" value="'.$idPers.'">
                <i class="fas fa-paper-plane" onclick="envoi();"></i>
                </form>';
}

//Formulaire de recherche
function formrecherche(){
    echo "<div class='recherche'>
        <form id='formrecherche' action='index.php' method='GET'>
            <input type='hidden' name='action' value='recherche'>
            <input name='texterecherche' type='text' placeholder='Rechercher...' required>
            <input type='submit' value='Rechercher'>
        </form>
    </div>";
}

?>















