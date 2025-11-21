<?php
# Se connecter à la BD
include_once('../connexion/connexion.php');
# Selection Querries
require_once("../models/select/select-participation.php");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Participations</title>
    <?php require_once('style.php'); ?>

</head>

<body>

    <!-- Appel de menues  -->
    <?php require_once('aside.php') ?>

    <main id="main" class="main">
        <div class="row">
            <div class="col-12">
                <h4>Participations</h4>
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


            ?>
            <!-- Le form qui enregistrer les données  -->
            <div class="col-xl-12 ">
                <form action="<?= $action ?>" method="POST" class="shadow p-3">
                    <div class="row">
                        <h4 class="text-center"><?= $title . " Au terrain de " . $denomination . " à " . $lieu ?> </h4>
                        <div class="col-xl-12 col-lg-12 col-md-12  col-sm-12 p-3">
                            <label for="">Agent <span class="text-danger">*</span></label>
                            <select required id="" name="agent" class="form-control select2">
                                <?php
                                while ($Agent = $getAgent->fetch()) {
                                    if (isset($_GET['idProd'])) {
                                ?>
                                        <option <?php if ($AgentModif == $Agent['id']) { ?>Selected <?php } ?> value="<?= $Agent['id'] ?>"><?= $Agent['nom'] . " " . $Agent['postnom'] . " " . $Agent['prenom'] . " " . $Agent['denomination'] ?></option>
                                    <?php
                                    } else {
                                    ?>
                                        <option value="<?= $Agent['id'] ?>"><?= $Agent['nom'] . " " . $Agent['postnom'] . " " . $Agent['prenom'] . " " . $Agent['denomination'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 mt-10 col-sm-12 p-3 aling-center">
                            <input type="submit" name="save" class="btn btn-dark w-100" value="<?= $btn ?>">
                        </div>
                    </div>
                </form>
            </div>

            <!-- La table qui affiche les données  -->
            <div class="col-xl-12 table-responsive px-3 card mt-4 px-4 pt-3">
                <a href="terrain.php">
                    <h6 class="bi bi-eye btn btn-dark btn-sm"> Liste de terrain</h6>
                </a>
                <h5 class="text-center">Listes des des participants au terrain de <?= $denomination . " à " . $lieu ?> </h5>
                <h6 class="text-center">Du <?= $date ?></h6>
                <table class="table table-borderless datatable ">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Agent</th>
                            <th>Terrain</th>
                            <th>lieu</th>
                            <th>Partenaire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $num = 0;
                        while ($partication = $getData->fetch()) {
                            $num = $num + 1 ?>
                            <tr>
                                <th scope="row"><?= $num ?></th>
                                <td><?= $partication["nom"] . " " . $partication["postnom"] . " " . $partication["prenom"] ?></td>
                                <td><?= $partication["description"] . " du " . $partication["date"] ?></td>
                                <td><?= $partication["lieu"] ?></td>
                                <td><?= $partication["Denomination"] ?></td>
                                <td>
                                    <a onclick=" return confirm('Voulez-vous vraiment supprimer ?')" href="../models/delete/deleteParticipation.php?id=<?= $partication["id"] ?>&&ter=<?= $id?>" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash3-fill"></i> Retirer
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
    </main><!-- End #main -->
    <?php require_once('script.php') ?>

</body>

</html>