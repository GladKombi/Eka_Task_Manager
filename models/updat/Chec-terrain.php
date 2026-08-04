<?php
include("../../connexion/connexion.php");
if (isset($_GET["ChecTer"]) && !empty($_GET["ChecTer"])) {
    $id=$_GET["ChecTer"];
    $statut=1;
    $req = $connexion->prepare("UPDATE `terrain` SET `statut`=? WHERE id=?");
    $test = $req->execute(array($statut, $id));
    if ($test == true) {
        $_SESSION['msg'] = "Votre Terrain est enregistré comme déjà effectuer ! Maintenant les agents ayant participés peuvent enregistrer leurs post-production !";
        header("location:../../views/terrain.php");
    } else {
        $_SESSION['msg'] = "Echec de modification !";
        header("location:../../views/terrain.php");
    }
} else {
    header("location:../../views/terrain.php");
}
