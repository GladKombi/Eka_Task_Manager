<?php
#inclusion de la page de connexion
include('../../connexion/connexion.php');
# Modification de données d'un Agent
if (isset($_POST['valider']) && !empty($_GET['idAgent'])) {
    $id = $_GET["idAgent"];
    $nom = htmlspecialchars($_POST['nom']);
    $postnom = htmlspecialchars($_POST['postnom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $genre = htmlspecialchars($_POST['genre']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $telephoneParent = htmlspecialchars($_POST['telephoneParent']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $Fonction = htmlspecialchars($_POST['fonction']);
    $statut = 0;
    if (is_numeric($telephone)) {
        #verifier si le client existe ou pas dans la bd
        $statut = 0;
        $getUserDeplicant = $connexion->prepare("SELECT * FROM `agents` WHERE telephone=? AND statut=? AND id!=$id");
        $getUserDeplicant->execute([$telephone, $statut]);
        $tab = $getUserDeplicant->fetch();
        if ($tab > 0) {
            $_SESSION['msg'] = "Cet Agent existe deja dans la Base de Données!";
            header("location:../../views/agent.php");
        } else {
            //Insertion data from database
            $req = $connexion->prepare("UPDATE `agents` SET `nom`=?,`postnom`=?,`prenom`=?,`genre`=?,`telephone`=?,`adresse`=?,`fonction`=?,`telephoneReferant`=?,`statut`=? WHERE id=?");
            $resultat = $req->execute([$nom, $postnom, $prenom, $genre, $telephone, $adresse, $Fonction, $telephoneParent, $statut, $id]);
            if ($resultat == true) {
                // Mettre à jour les rôles si fournis
                if (isset($_POST['roles']) && is_array($_POST['roles'])) {
                    $del = $connexion->prepare("DELETE FROM agent_roles WHERE agent_id = ?");
                    $del->execute([$id]);
                    $ins = $connexion->prepare("INSERT IGNORE INTO agent_roles (agent_id, role_id) VALUES (?, ?)");
                    foreach ($_POST['roles'] as $r) {
                        $ins->execute([$id, intval($r)]);
                    }
                }

                $_SESSION['msg'] = "Modification reussi !";
                header("location:../../views/agent.php");
            } else {
                $_SESSION['msg'] = "Echec d'enregistrement !";
                header("location:../../views/agent.php");
            }
        }
    } else {
        $_SESSION['msg'] = "Le numero de telephone ne doit pas contenir des caracteres Alphanumerique";
        header("location:../../views/agent.php");
    }
} else {
    header("location:../../views/agent.php");
}
