<?php
# Se connecter à la BD
require_once('../connexion/connexion.php');
require_once('../models/select/select-Production.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Production</title>
    <?php require_once('style.php'); ?>

</head>

<body>

    <!-- Appel de menues  -->
    <?php require_once('aside.php') ?>

    <main id="main" class="main">
        <div class="row">
            <div class="col-12">
                <h4>Post-Production</h4>
            </div>
            <!-- pour afficher les massage  -->

            <?php
            if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) { ?>
                <div class="col-xl-12 mt-3">
                    <div class="alert-info alert text-center"><?= $_SESSION['msg'] ?></div>
                </div>
            <?php }
            #Cette ligne permet de vider la valeur qui se trouve dans la session message
            unset($_SESSION['msg']);

            if (isset($_GET["idTerrain"]) && !empty($_GET["idTerrain"])) {
            ?>
                <!-- Le form qui enregistrer les données  -->
                <div class="col-xl-12 ">
                    <form action="<?= $action ?>" method="POST" class="shadow p-3">
                        <div class="row">                            
                            <h4 class="text-center"><?= $title ?></h4>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Type de Production<span class="text-danger">*</span></label>
                                <input required autocomplete="off" type="text" name="adress" class="form-control" placeholder="Entrez l'adresse" <?php if (isset($_GET['idclient'])) { ?>value="<?= $element['adresse'] ?>" <?php } ?>>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Agent <span class="text-danger">*</span></label>
                                <select required id="" name="fonction" class="form-control select2">
                                    <option value="" desabled>Choisir un agent</option>
                                    <option value="">Exemple</option>
                                    <option value="">Exemple</option>
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Disk de stockage <span class="text-danger">*</span></label>
                                <select required id="" name="fonction" class="form-control select2">
                                    <option value="" desabled>Choisir un disk</option>
                                    <option value="">Exemple</option>
                                    <option value="">Exemple</option>
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                <label for="">Emplacement/nom du dossier <span class="text-danger">*</span></label>
                                <input required autocomplete="off" type="text" name="adress" class="form-control" placeholder="Entrez l'adresse" <?php if (isset($_GET['idclient'])) { ?>value="<?= $element['adresse'] ?>" <?php } ?>>
                            </div>

                            <?php if (isset($_GET['idclient'])) {
                            ?>
                                <div class="col-xl-6 col-lg-6 col-md-6 mt-4 col-sm-6 p-3 ">
                                    <input type="submit" name="valider" class="btn btn-dark w-100" value="Modifier">
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 mt-4 col-sm-6 p-3 ">
                                    <a href="client.php" class="btn btn-danger w-100">Annuler</a>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="col-xl-12 col-lg-12 col-md-12 mt-10 col-sm-12 p-3 aling-center">
                                    <input type="submit" name="valider" class="btn btn-dark w-100" value="<?= $btn ?>">
                                </div>
                            <?php
                            }
                            ?>

                        </div>
                    </form>
                </div>
                <!-- La table qui affiche les données  -->
                <div class="col-xl-12 table-responsive px-3 card mt-4 px-4 pt-3">
                    <h6 class="text-center">Listes des Productions</h6>
                    <table class="table table-borderless datatable ">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Terrain</th>
                                <th>Agent</th>
                                <th>Type de production</th>
                                <th>Disk</th>
                                <th>Emplacement</th>
                                <th>Etat</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Exemple</td>
                                <td>Exemple</td>
                                <td>Exemple</td>
                                <td>Exemple</td>
                                <td>Exemple</td>
                                <td>
                                    <a href="client.php?idclient=" class="btn btn-dark btn-sm">Livée</a>
                                </td>
                                <td>
                                    <a href="client.php?idclient=" class="btn btn-dark btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a onclick=" return confirm('Voulez-vous vraiment supprimer ?')" href="../models/delete/deleteClient.php?idclient=" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>Exemple</td>
                                <td>Exemple</td>
                                <td>Exemple</td>
                                <td>Exemple</td>
                                <td>Exemple</td>
                                <td>
                                    Deja livrée
                                </td>
                                <td>
                                    <a href="client.php?idclient=" class="btn btn-dark btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a onclick=" return confirm('Voulez-vous vraiment supprimer ?')" href="../models/delete/deleteClient.php?idclient=" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php
            } else {
            ?>
                <!-- La table qui affiche les données  -->
            <div class="col-xl-12 table-responsive px-3 card mt-4 px-4 pt-3">
                <h6 class="text-center">Listes des terrains</h6>
                <table class="table table-borderless datatable ">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>lieu</th>
                            <th>Partenaire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Exemple</td>
                            <td>Exemple</td>
                            <td>Exemple</td>
                            <td>Exemple</td>
                            <td>
                                <a href="post-Production.php?idTerrain=1" class="btn btn-dark btn-sm bi bi-plus">Production</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php
            }
            ?>


        </div>
    </main><!-- End #main -->
    <?php require_once('script.php') ?>

</body>

</html>