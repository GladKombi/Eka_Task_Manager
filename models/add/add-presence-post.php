<?php
include('../../connexion/connexion.php');

if (!isset($_SESSION['iduser']) || empty($_SESSION['iduser'])) {
    header('Location:../../ops.php');
    exit;
}

if (isset($_POST['register_presence'])) {
    $agent = $_SESSION['iduser'];
    $date = date('Y-m-d');
    $heureInput = trim($_POST['heure'] ?? '');
    $statut = 0;

    $heure = date('H:i:s');
    if ($heureInput !== '') {
        $parsed = DateTime::createFromFormat('H:i', $heureInput);
        if ($parsed && $parsed->format('H:i') === $heureInput) {
            $heure = $parsed->format('H:i:s');
        } elseif ($parsed = DateTime::createFromFormat('H:i:s', $heureInput)) {
            $heure = $parsed->format('H:i:s');
        }
    }

    $check = $connexion->prepare("SELECT id FROM `presence` WHERE agent=? AND date=? AND statut=?;");
    $check->execute([$agent, $date, $statut]);

    if ($check->fetch()) {
        $_SESSION['msg'] = "Votre présence du jour a déjà été enregistrée.";
    } else {
        $req = $connexion->prepare("INSERT INTO `presence` (`agent`,`date`,`heure`,`statut`) VALUES (?,?,?,?);");
        if ($req->execute([$agent, $date, $heure, $statut])) {
            $_SESSION['msg'] = "Présence enregistrée avec succès.";
        } else {
            $_SESSION['msg'] = "Erreur lors de l'enregistrement de la présence.";
        }
    }
}

header('Location:../../views/presence.php');
exit;
