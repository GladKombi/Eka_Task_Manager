<?php
include_once '../connexion/connexion.php';
if (!isset($_SESSION['iduser']) || empty($_SESSION['iduser'])) {
    header("location:ops.php");
}
?>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <img src="../assets/img/logo/EKA_logo.png" alt="">
            <span class="d-none d-lg-block text-dark">Eka_Consulting</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn text-dark"></i>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="<?php if (isset($_SESSION['image'])) {
                                    print '../assets/img/profiles/' . $_SESSION['image'];
                                } ?>" alt="Profile" class="rounded-circle " width="35">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['noms']; ?></span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?= $_SESSION['noms']; ?></h6>
                        <span><?= $_SESSION['fonction'] ?></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="profil.php">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="../models/log-out.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Deconnexion</span>
                        </a>
                    </li>
                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link bg-transparent text-dark " href="index.php">
                <i class="bi bi-grid text-dark"></i>
                <span>Accueil</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <?php if ($_SESSION['User'] === "Admin" && ! empty($_SESSION['User'])) {
        ?>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Flux Financiers</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="entree.php">
                            <i class="bi bi-circle"></i><span>Entrées Caisses</span>
                        </a>
                    </li>
                    <li>
                        <a href="sortie.php">
                            <i class="bi bi-circle"></i><span>Sortie Caisses</span>
                        </a>
                    </li>
                    <li>
                        <a href="cloture.php">
                            <i class="bi bi-circle"></i><span>Clotures</span>
                        </a>
                    </li>

                </ul>
            </li><!-- End Components Nav -->
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="materiels-Details.php">
                    <i class="bi bi-house-fill text-dark"></i>
                    <span>Materiels</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="departement.php">
                    <i class="bi bi-house-fill text-dark"></i>
                    <span>Département</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="partenaire.php">
                    <i class="bi bi-house-fill text-dark"></i>
                    <span>Partenaires</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="agent.php">
                    <i class="bi bi-person-walking text-dark"></i>
                    <span>Agents</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="disk.php">
                    <i class="bi bi-person-walking text-dark"></i>
                    <span>Disk de stackages</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="terrain.php">
                    <i class="bi bi-person-walking text-dark"></i>
                    <span>Terrain</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="post-Production.php">
                    <i class="bi bi-person-walking text-dark"></i>
                    <span>Post-Production</span>
                </a>
            </li><!-- End Dashboard Nav -->
        <?php
        } elseif ($_SESSION['User'] === "ceo" && ! empty($_SESSION['User'])) {
        ?>
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="agent.php">
                    <i class="bi bi-person-walking text-dark"></i>
                    <span>Agents</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Rapports</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>Liste des Agents</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>Liste des partenaires</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>Liste des terrains</span>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>Liste des Productions</span>
                        </a>
                    </li>

                </ul>
            </li><!-- End Components Nav -->
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="departement.php">
                    <i class="bi bi-house-fill text-dark"></i>
                    <span>Département</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="partenaire.php">
                    <i class="bi bi-house-fill text-dark"></i>
                    <span>Partenaires</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="terrain.php">
                    <i class="bi bi-person-walking text-dark"></i>
                    <span>Terrain</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="user.php">
                    <i class="bi bi-people-fill text-dark"></i>
                    <span>Utilisateur</span>
                </a>
            </li> <!--End Dashboard Nav -->

        <?php
        } elseif ($_SESSION['User'] === "Agent" && ! empty($_SESSION['User'])) {
        ?>
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="post-Production.php">
                    <i class="bi bi-person-walking text-dark"></i>
                    <span>Post-Production</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="post-Production.php">
                    <i class="bi bi-person-walking text-dark"></i>
                    <span>Post-Production</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="presence.php">
                    <i class="bi bi-clock-history text-dark"></i>
                    <span>Présence</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link bg-transparent text-dark " href="post-Production.php">
                    <i class="bi bi-person-walking text-dark"></i>
                    <span>Horaire</span>
                </a>
            </li><!-- End Dashboard Nav -->

        <?php
        }
        ?>

    </ul>

</aside><!-- End Sidebar-->