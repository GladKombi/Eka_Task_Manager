<?php
# Se connecter à la BD
include_once('../connexion/connexion.php');
# Selection Querries
require_once("../models/select/select-Terrain.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Terrain</title>
    <?php require_once('style.php'); ?>

</head>

<body>

    <!-- Appel de menues  -->
    <?php require_once('aside.php') ?>

    <main id="main" class="main">
        <?php
        # Confirmation de la suppression
        if (isset($_GET['SupTer'])) {
            $id = $_GET["SupTer"];
        ?>
            <div class="col-xl-12 px-3 card mt-4 px-4 pt-3">
                <h3 class="bi bi-shield-exclamation text-danger text-center"> Zone Dangereuse</h3> <br>
                <p class="text-center">
                    Voule-Vous vraiment supprimer ce terrain ?? c'est dangereux ! <br>
                    Cette action est irreverssible, Assurez-vous que c'est l'action que vous souhaiter
                    réaliser ! Elle permet de supprimer un Terain de la base de données et toutes les données liées à ce terrain .
                </p>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                        <a href="terrain.php" class="btn btn-dark  w-100"> Annuler</a>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                        <a href="../models/delete/delete-terrain.php?SupTer=<?= $id ?>" class="btn btn-danger bi bi-trash w-100"> Supprimer le terrain</a>
                    </div>
                </div>
            </div>
        <?php
        } elseif (isset($_GET['check'])) {
            $idChec = $_GET["check"];
        ?>
            <div class="col-xl-12 px-3 card mt-4 px-4 pt-3">
                <h3 class="bi bi-shield-exclamation text-danger text-center"> Zone Dangereuse</h3> <br>
                <p class="text-center">
                    Confirmez-vous que ce terrain est deja effectuer ?? c'est dangereux ! <br>
                    Cette action est irreverssible, Assurez-vous que c'est l'action que vous souhaiter
                    réaliser ! Elle permet de confirmer qu'un Terain a bien été effectuer.
                </p>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                        <a href="terrain.php" class="btn btn-dark  w-100"> Annuler</a>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                        <a href="../models/updat/Chec-terrain.php?ChecTer=<?= $idChec ?>" class="btn btn-danger bi bi-trash w-100"> Terrain effectué</a>
                    </div>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="row">
                <div class="col-12">
                    <h4>Terrain</h4>
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

                if (isset($_GET["NewTerrain"])) {
                ?>
                    <!-- Le form qui enregistrer les données  -->
                    <div class="col-xl-12 ">
                        <form action="<?= $action ?>" method="POST" class="shadow p-3">
                            <div class="row">
                                <?php
                                if (isset($_GET['idTerrain'])) {
                                ?>
                                    <h4 class="text-center"><?= $title . " " . $partenaire  ?></h4>
                                <?php
                                } else {
                                ?>
                                    <h4 class="text-center"><?= $title ?></h4>
                                <?php
                                }
                                ?>
                                <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                    <label for="">Description <span class="text-danger">*</span></label>
                                    <input required autocomplete="off" type="text" name="description" class="form-control" placeholder="Entrez la description" <?php if (isset($_GET['idTerrain'])) { ?>value="<?= $terMod['description'] ?>" <?php } ?>>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                    <label for="">Lieu <span class="text-danger">*</span></label>
                                    <input required autocomplete="off" type="text" name="lieu" class="form-control" placeholder="EX: Beni" <?php if (isset($_GET['idTerrain'])) { ?>value="<?= $terMod['lieu'] ?>" <?php } ?>>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6  col-sm-6 p-3">
                                    <label for="">Partennaire <span class="text-danger">*</span></label>
                                    <select required id="" name="partenaire" class="form-control select2">
                                        <?php
                                        while ($parte = $getPartenaire->fetch()) {
                                            if (isset($_GET['idTerrain'])) {
                                        ?>
                                                <option <?php if ($idPart == $parte['id']) { ?>Selected <?php } ?> value="<?= $parte['id'] ?>"><?= $parte['Denomination'] ?></option>
                                            <?php
                                            } else {
                                            ?>
                                                <option value="<?= $parte['id'] ?>"><?= $parte['Denomination'] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>


                                <?php if (isset($_GET['idTerrain'])) {
                                ?>
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 mt-4 col-sm-6 p-3 ">
                                            <input type="submit" name="valider" class="btn btn-dark w-100" value="Modifier">
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 mt-4 col-sm-6 p-3 ">
                                            <a href="terrain.php" class="btn btn-danger w-100">Annuler</a>
                                        </div>
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
                <?php
                } else {
                ?>
                    <a href="terrain.php?NewTerrain" class="btn btn-dark w-100">Nouveau Terrain</a>
                <?php
                }
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
                            <?php $num = 0;
                            while ($ress = $req->fetch()) {
                                $num = $num + 1 ?>
                                <tr>
                                    <th scope="row"><?= $num ?></th>
                                    <td><?= $ress["date"] ?></td>
                                    <td><?= $ress["description"] ?></td>
                                    <td><?= $ress["lieu"] ?></td>
                                    <td><?= $ress["Denomination"] ?></td>
                                    <td>
                                        <a href="terrain.php?check=<?= $ress["id"] ?>" class="btn btn-dark btn-sm">
                                            <i class="bi bi-check"></i>
                                        </a>
                                        <a href="participation.php?idTerr=<?= $ress["id"] ?>" class="btn btn-dark btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="terrain.php?NewTerrain&idTerrain=<?= $ress["id"] ?>" class="btn btn-dark btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="terrain.php?SupTer=<?= $ress["id"] ?>" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                        </tbody>
                    <?php
                            }
                    ?>
                    </table>
                </div>
            </div>
        <?php
        }
        ?>
    </main><!-- End #main -->
    <?php require_once('script.php') ?>

</body>

</html>