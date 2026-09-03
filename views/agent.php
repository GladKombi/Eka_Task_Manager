<?php
# Se connecter à la BD
require_once('../connexion/connexion.php');
require_once('../models/select/select-Agent.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Agent</title>
    <?php require_once('style.php'); ?>

</head>

<body>

    <!-- Appel de menues  -->
    <?php require_once('aside.php') ?>

    <main id="main" class="main">
        <div class="row">
            <div class="col-12">
                <h4>Agent</h4>
            </div>
            <!-- pour afficher les massage  -->

            <?php
            if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) { ?>
                <div class="col-xl-12 mt-3">
                    <div class="alert-info alert text-center"><?= $_SESSION['msg'] ?></div>
                </div>
                =======
                <!-- pour afficher les massage  -->

            <?php }

            if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) { ?>
                <div class="col-xl-12 mt-3">
                    <div class="alert-info alert text-center"><?= $_SESSION['msg'] ?></div>
                </div>
            <?php }
            #Cette ligne permet de vider la valeur qui se trouve dans la session message
            unset($_SESSION['msg']);

            if (isset($_GET["NewAgent"])) {
            ?>
                <!-- Le form qui enregistrer les données  -->
                <div class="col-xl-12 ">
                    <form action="<?= $action ?>" method="POST" class="shadow p-3" enctype="multipart/form-data">
                        <div class="row">
                            <h4 class="text-center"><?= $title ?></h4>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Nom <span class="text-danger">*</span></label>
                                <input required autocomplete="off" type="text" name="nom" class="form-control" placeholder="Entrez le nom" <?php if (isset($_GET['idAgent'])) { ?>value="<?= $tab['nom'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Postnom <span class="text-danger">*</span></label>
                                <input required autocomplete="off" type="text" name="postnom" class="form-control" placeholder="Entrez le postnom" <?php if (isset($_GET['idAgent'])) { ?>value="<?= $tab['postnom'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Prenom <span class="text-danger">*</span></label>
                                <input required autocomplete="off" type="text" name="prenom" class="form-control" placeholder="Entrez le prenom" <?php if (isset($_GET['idAgent'])) { ?>value="<?= $tab['prenom'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Genre <span class="text-danger">*</span></label>
                                <select required id="" name="genre" class="form-control select2">
                                    <?php
                                    if (isset($_GET['idAgent'])) {
                                    ?>

                                        <?php if ($tab['genre'] == 'Masculin') { ?>
                                            <option value="Masculin" Selected>Masculin</option>
                                            <option value="Feminin">Feminin</option>

                                        <?php } else {
                                        ?>
                                            <option value="Masculin">Masculin</option>
                                            <option value="Feminin" Selected>Feminin</option>

                                        <?php }
                                    } else {
                                        ?>
                                        <option value="" desabled>Choisir un genre</option>
                                        <option value="Masculin">Masculin</option>
                                        <option value="Feminin">Feminin</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Adresse <span class="text-danger">*</span></label>
                                <input required autocomplete="off" type="text" name="adresse" class="form-control" placeholder="Entrez l'adresse" <?php if (isset($_GET['idAgent'])) { ?>value="<?= $tab['adresse'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Telephone <span class="text-danger">*</span></label>
                                <input required autocomplete="off" type="text" name="telephone" class="form-control" placeholder="Entrez le N° Tel" <?php if (isset($_GET['idAgent'])) { ?>value="<?= $tab['telephone'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Telephone parents ou Referant <span class="text-danger">*</span></label>
                                <input required autocomplete="off" type="text" name="telephoneParent" class="form-control" placeholder="Entrez le N° Tel" <?php if (isset($_GET['idAgent'])) { ?>value="<?= $tab['telephoneReferant'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Département <span class="text-danger">*</span></label>
                                <select required id="" name="fonction" class="form-control select2">
                                    <?php
                                    while ($departement = $getDepartement->fetch()) {
                                        if (isset($_GET['idAgent'])) {
                                    ?>
                                            <option <?php if ($departementModif == $departement['id']) { ?>Selected <?php } ?> value="<?= $departement['id'] ?>"><?= $departement['nom_Departement'] ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?= $departement['id'] ?>"><?= $departement['nom_Departement'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Rôles <span class="text-danger">*</span></label>
                                <select required id="roles" name="roles[]" class="form-control select2" multiple>
                                    <?php
                                    // Affiche les rôles depuis la base
                                    while ($role = $getRoles->fetch()) {
                                        $selected = '';
                                        if (isset($assignedRoles) && in_array($role['id_role'], $assignedRoles)) {
                                            $selected = 'selected';
                                        }
                                    ?>
                                        <option value="<?= $role['id_role'] ?>" <?= $selected ?>><?= $role['nom_role'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <small class="text-muted">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs rôles.</small>
                            </div>

                            <?php if (isset($_GET['idAgent'])) {
                            ?>
                                <div class="col-xl-6 col-lg-6 col-md-6 mt-4 col-sm-6 p-3 ">
                                    <input type="submit" name="valider" class="btn btn-dark w-100" value="Modifier">
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 mt-4 col-sm-6 p-3 ">
                                    <a href="agent.php" class="btn btn-danger w-100">Annuler</a>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                    <label for="">Mot de passe <span class="text-danger">*</span></label>
                                    <input required autocomplete="off" type="password" name="pwd" class="form-control" placeholder="Ex:..." <?php if (isset($_GET['idAgent'])) { ?>value="<?= $element['telephone'] ?>" <?php } ?>>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                    <label for="">Adresse mail <span class="text-danger">*</span></label>
                                    <input required autocomplete="off" type="email" name="mail" class="form-control" placeholder="EX: Exemple@gmail.com" <?php if (isset($_GET['idAgent'])) { ?>value="<?= $element['telephone'] ?>" <?php } ?>>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4  col-sm-6 p-3">
                                    <label for="">Photo de profil<span class="text-danger">*</span></label>
                                    <input autocomplete="off" value="" name="picture" class="img-fluid" type="file" class="form-control" placeholder="Aucun fichier">
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 mt-10 col-sm-12 p-3 aling-center">
                                    <input type="submit" name="valider" class="btn btn-dark w-100" value="<?= $btn ?>">
                                </div>
                            <?php
                            }
                            ?>


                        <?php
                    } else {
                        ?>
                            <a href="agent.php?NewAgent" class="btn btn-dark w-100">Nouvel Agent</a>
                        <?php
                    }
                        ?>

                        <!-- La table qui affiche les données  -->
                        <div class="col-xl-12 table-responsive px-3 card mt-4 px-4 pt-3">
                            <h6 class="text-center">Listes des agents</h6>
                            <table class="table table-borderless datatable ">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Noms</th>
                                        <th>Genre</th>
                                        <th>Adresse</th>
                                        <th>Telephone</th>
                                        <th>Telephone Referant</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $n = 0;
                                    while ($Agent = $getData->fetch()) {
                                        $n++;
                                    ?>
                                        <tr>
                                            <th scope="row"><?= $n ?></th>
                                            <td><?= $Agent["nom"] . " " . $Agent["postnom"] . " " . $Agent["prenom"] ?></td>
                                            <td><?= $Agent["adresse"] ?></td>
                                            <td><?= $Agent["denomination"] ?></td>
                                            <td><?= $Agent["telephone"] ?></td>
                                            <td><?= $Agent["telephoneReferant"] ?></td>
                                            <td><img src="../assets/img/profiles/<?= $Agent["profil"] ?>" alt="" class="rounded-circle mt-2" width="65px" height="60px"></td>
                                            <td>
                                                <a href="agent.php?NewAgent&idAgent=<?= $Agent["id"] ?>" class="btn btn-dark btn-sm mb-2">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a onclick="return confirm('Voulez-vous vraiment supprimer cet agent ?')" href="../models/delete/delete-Agent.php?idSupAgent=<?= $Agent["id"] ?>" class="btn btn-danger btn-sm mb-2">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
    </main><!-- End #main -->
    <?php require_once('script.php') ?>

</body>

</html>