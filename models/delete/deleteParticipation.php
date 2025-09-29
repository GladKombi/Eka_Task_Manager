<?php
include("../../connexion/connexion.php");
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id=$_GET["id"];
    $ter=$_GET["ter"];
    $statut=1;
    $req = $connexion->prepare("UPDATE `participation` SET `statut`=? WHERE id=?");
    $test = $req->execute(array($statut, $id));
    if ($test == true) {
        $_SESSION['msg'] = "Annulation de la participation reussi !";
        header("location:../../views/participation.php?idTerr=".$ter);
    } else {
        $_SESSION['msg'] = "Echec de modification !";
        header("location:../../views/participation.php?idTerr=".$ter);
    }
} else {
    header("location:../../views/participation.php?idTerr=".$ter);
}
