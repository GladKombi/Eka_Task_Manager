<?php
# Se connecter à la BD
require_once('../connexion/connexion.php');
# Selection Querry
require_once('../models/select/select-Home.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Accueil</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <?php
    require_once('style.php');
    ?>
    <style>
        .carte {
            margin-right: 8px;
        }
    </style>

</head>

<body>

    <?php require_once('aside.php') ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Administration & Statistiques</h1>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-8">
                    <div class="row">

                        <!-- Agent Hommes statistiques Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Agents <span>| Hommes</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-standing"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?= $TotalHomme . "/" . $TotalAgent ?></h6>
                                            <span class="text-success small pt-1 fw-bold"><?= $PourcenHome ?>%</span> <span class="text-muted small pt-2 ps-1">Hommes</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Agent Femmes statistiques Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Agents <span>| Femmes</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-standing-dress"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?= $TotalFemme . "/" . $TotalAgent ?></h6>
                                            <span class="text-success small pt-1 fw-bold"><?= $PourcenFeme ?>%</span> <span class="text-muted small pt-2 ps-1">Femmes</span>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Disk statistiques Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Disk de stockage <span>| Actifs</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-server"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?= $TotalDisk ?> Disks</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!--<div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">

                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filtrer</h6>
                                        </li>

                                        <li><a class="dropdown-item" href="index.php?Genre=Masculin">Homme</a></li>
                                        <li><a class="dropdown-item" href="index.php?Genre=Feminin">Femmes</a></li>
                                    </ul>
                                </div>

                                <?php
                                if (isset($_GET["Genre"])) {
                                    $GenreSelect = $_GET["Genre"];
                                    if ($GenreSelect = "Masculin") {
                                ?>
                                        <div class="card-body">
                                            <h5 class="card-title">Agents <span>| Hommes</span></h5>

                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-person-standing"></i>
                                                </div>
                                                <div class="ps-3">
                                                    <h6><?= $GenreSelect["TotalGenreSelect"] ?>/</h6>
                                                    <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">Homme</span>

                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="card-body">
                                            <h5 class="card-title">Agents <span>| Femmes</span></h5>

                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-person-standing-dress"></i>
                                                </div>
                                                <div class="ps-3">
                                                    <h6><?= $GenreSelect["TotalGenreSelect"] ?>/<?= $AgentTotal["TotalAgent"] ?></h6>
                                                    <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">Femmes</span>

                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <div class="card-body">
                                        <h5 class="card-title">Agents <span>| Eka</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6><?= $AgentTotal["TotalAgent"] ?> Agents</h6>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }

                                ?>
                            </div>
                        </div> End Sales Card -->

                        <!-- partenaire statistiques Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Nos partenaires <span>| Actif</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6><?= $TotalPartenaire ?></h6>
                                            <span class="text-muted small pt-2 ps-1">Partenaires</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Revenue Card -->

                        <!-- Materiels Card -->
                        <div class="col-xxl-5 col-xl-12">

                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Materiels <span>| This Year</span></h5>
                                    <?php
                                    while ($materiel = $getMatos->fetch()) {
                                    ?>
                                        <div class="d-flex align-items-center pt-2">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <img src="../assets/img/Matos/<?= $materiel["photo"] ?>" class="card-icon rounded-circle" width="60" height="60" alt="">
                                            </div>
                                            <div class="ps-3">
                                                <h6><?= $materiel["nomcat"] ?></h6>
                                                <span class="text-primary small pt-1 fw-bold">Catégorie</span>
                                            </div>
                                            <div class="ps-3">
                                                <h6><?= $materiel["marque"] . " " . $materiel["nom"] ?></h6>
                                                <span class="text-primary small pt-1 fw-bold">Specialité <?= $materiel["specialite"] ?></span>
                                            </div>

                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <!-- The button -->
                                    <div class="d-flex align-items-center pt-5">
                                        <div class="ps-3">
                                            <a href="materiels-Details.php" class="btn btn-dark btn-sm small pt-1 fw-bold bi bi-eye"> Voir les details</a>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Customers Card -->
                    </div>
                </div><!-- End Left side columns -->

                <!-- Right side columns -->
                <div class="col-lg-4">
                    <!-- Recent Terrain -->
                    <div class="card">
                        <!-- <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div> -->

                        <div class="card-body">
                            <h5 class="card-title">Terrain Recent <span>| Today</span></h5>

                            <div class="activity">
                                <?php
                                while ($Terrain = $getTerrain->fetch()) {
                                ?>
                                    <div class="activity-item d-flex">
                                        <div class="activite-label"><?= $Terrain["date"] ?></div>
                                        <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                        <div class="activity-content">
                                            <?= $Terrain["description"] . " à " . $Terrain["lieu"] ?> avec<a href="#" class="fw-bold text-dark"> <?= $Terrain["Denomination"] ?></a>
                                        </div>
                                    </div><!-- End terrain item-->
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div><!-- End Recent Activity -->

                </div><!-- End Right side columns -->

            </div>
        </section>

    </main><!-- End #main -->

    <?php require_once('script.php') ?>

</body>

</html>