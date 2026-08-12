<?php
include('../../connexion/connexion.php');

if (!isset($_SESSION['iduser']) || empty($_SESSION['iduser'])) {
    header('Location:../../ops.php');
    exit;
}

if (isset($_POST['register_absence'])) {
    $agent = $_SESSION['iduser'];
    $date = date('Y-m-d');
    $reason = trim(htmlspecialchars($_POST['reason'] ?? ''));
    $statut = 0;

    // Vérifier s'il y a déjà une présence ou une absence pour aujourd'hui
    $checkPres = $connexion->prepare("SELECT id FROM `presence` WHERE agent=? AND date=? AND statut=?;");
    $checkPres->execute([$agent, $date, $statut]);
    $checkAbs = $connexion->prepare("SELECT id FROM `absences` WHERE agent=? AND date=? AND statut=?;");
    $checkAbs->execute([$agent, $date, $statut]);

    if ($checkPres->fetch()) {
        $_SESSION['msg'] = "Impossible : une présence a déjà été enregistrée aujourd'hui.";
    } elseif ($checkAbs->fetch()) {
        $_SESSION['msg'] = "Vous avez déjà signalé une absence pour aujourd'hui.";
    } else {
        $req = $connexion->prepare("INSERT INTO `absences` (`agent`,`date`,`reason`,`statut`) VALUES (?,?,?,?);");
        if ($req->execute([$agent, $date, $reason, $statut])) {
            $_SESSION['msg'] = "Absence signalée avec succès.";
        } else {
            $_SESSION['msg'] = "Erreur lors de la déclaration d'absence.";
        }
    }
}

header('Location:../../views/presence.php');
exit;