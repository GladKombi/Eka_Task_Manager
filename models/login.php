<?php
include('../connexion/connexion.php');

function isPasswordValid($password, $storedPassword) {
    if ($password === '' || $storedPassword === '') {
        return false;
    }

    if (password_verify($password, $storedPassword)) {
        return true;
    }

    $info = password_get_info($storedPassword);
    if ($info['algo'] === 0 && $password === $storedPassword) {
        return true;
    }

    return false;
}

if (isset($_POST['connect'])) {
    $username = trim(htmlspecialchars($_POST['username']));
    $password = trim(htmlspecialchars($_POST['password']));
    # Ferification des champs
    if (isset($_SESSION['User']) && !empty($_SESSION['User'])) {
        if ($_SESSION['User'] === "Admin" || $_SESSION['User'] === "ceo") {
            $statut = 0;
            $fonction=$_SESSION['User'];
            $getUserAdmin = $connexion->prepare("SELECT * FROM `users` WHERE mail=? AND users.statut=? AND users.foction=?");
            $getUserAdmin->execute(array($username, $statut, $fonction));
            if ($_identifiant = $getUserAdmin->fetch()) {
                $pwd = $_identifiant['pwd'];
                $isValid = isPasswordValid($password, $pwd);
                $storedInfo = password_get_info($pwd);
                if ($isValid && $storedInfo['algo'] === 0 && $password === $pwd) {
                    $pwd = password_hash($password, PASSWORD_DEFAULT);
                    $updateHash = $connexion->prepare("UPDATE `users` SET pwd=? WHERE id=?");
                    $updateHash->execute([$pwd, $_identifiant['id']]);
                }
                if ($isValid) {
                    $_SESSION['msg'] = "";
                    $_SESSION['fonction'] = $_identifiant['foction'];
                    $_SESSION['iduser'] = $_identifiant['id'];
                    $_SESSION['image'] = $_identifiant['profil'];
                    $_SESSION['prenom'] = $_identifiant['prenom'];
                    $_SESSION['telephone'] = $_identifiant['telephone'];
                    $_SESSION['noms'] = $_identifiant['nom'] . ' ' . $_identifiant['postnom'];
                    $_SESSION['nom'] = $_identifiant['nom'];
                    $_SESSION['postnom'] = $_identifiant['postnom'];
                    $_SESSION['pwd'] = $pwd;
                    header("location:../views/index.php");
                } else {
                    $_SESSION['msg'] = "username or password incorrect ";
                    header("location:../login.php");
                }
            } else {
                $_SESSION['msg'] = "username or password incorrect !";
                header("location:../login.php?". $fonction);
            }
        } else {
            // Fetch the user based on the username
            $statut = 0;
            $req = $connexion->prepare("SELECT `agents`.*, departement.denomination AS role FROM `agents`, departement WHERE mail=? AND agents.statut=? AND agents.fonction=departement.id;");
            $req->execute(array($username, $statut));
            if ($_identifiant = $req->fetch()) {
                $pwd = $_identifiant['pwd'];
                $isValid = isPasswordValid($password, $pwd);
                $storedInfo = password_get_info($pwd);
                if ($isValid && $storedInfo['algo'] === 0 && $password === $pwd) {
                    $pwd = password_hash($password, PASSWORD_DEFAULT);
                    $updateHash = $connexion->prepare("UPDATE `agents` SET pwd=? WHERE id=?");
                    $updateHash->execute([$pwd, $_identifiant['id']]);
                }
                if ($isValid) {
                    $_SESSION['msg'] = "";
                    $_SESSION['fonction'] = $_identifiant['role'];
                    $_SESSION['iduser'] = $_identifiant['id'];
                    $_SESSION['image'] = $_identifiant['profil'];
                    $_SESSION['prenom'] = $_identifiant['prenom'];
                    $_SESSION['telephone'] = $_identifiant['telephone'];
                    $_SESSION['genre'] = $_identifiant['genre'];
                    $_SESSION['adresse'] = $_identifiant['adresse'];
                    $_SESSION['noms'] = $_identifiant['nom'] . ' ' . $_identifiant['postnom'];
                    $_SESSION['nom'] = $_identifiant['nom'];
                    $_SESSION['postnom'] = $_identifiant['postnom'];
                    $_SESSION['pwd'] = $pwd;
                    header("location:../views/horaire.php");
                } else {
                    $_SESSION['msg'] = "username or password incorrect";
                    header("location:../login.php");
                }
            } else {
                $_SESSION['msg'] = "username or password incorrect";
                header("location:../login.php");
            }
        }
    } else {
        header("location:../ops.php");
    }
} else {
    header("location:../ops.php");
}
