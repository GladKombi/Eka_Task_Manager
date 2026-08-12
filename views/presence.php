<?php
require_once('../connexion/connexion.php');
require_once('../models/select/select-presence.php');

function jourFrancais($date)
{
    $jours = [
        'Monday' => 'Lundi',
        'Tuesday' => 'Mardi',
        'Wednesday' => 'Mercredi',
        'Thursday' => 'Jeudi',
        'Friday' => 'Vendredi',
        'Saturday' => 'Samedi',
        'Sunday' => 'Dimanche',
    ];
    $jourAnglais = date('l', strtotime($date));
    return $jours[$jourAnglais] ?? $jourAnglais;
}


$today_for_check = isset($today) ? $today : date('Y-m-d');
$isSunday = (date('N', strtotime($today_for_check)) == 7);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Présence</title>
    <?php require_once('style.php'); ?>
</head>

<body>

    <!-- Appel de menues  -->
    <?php require_once('aside.php') ?>

    <main id="main" class="main">
        <div class="pagetitle mb-3">
            <h1>Pointage de Présence</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                    <li class="breadcrumb-item active">Présence</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <?php if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])) { ?>
                    <div class="alert alert-info text-center"><?php echo $_SESSION['msg']; ?></div>
                <?php }
                unset($_SESSION['msg']); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Enregistrer la présence</h5>
                        <p class="text-muted">Bonjour <strong><?= $_SESSION['noms'] ?? 'Agent' ?></strong>, enregistrez votre arrivée de travail pour aujourd'hui.</p>

                        <?php
                            if ($isSunday) { ?>
                                <div class="alert alert-warning">Aujourd'hui est dimanche (<?= jourFrancais($today_for_check) ?>). L'enregistrement est désactivé.</div>
                        <?php
                            } elseif ($hasRegisteredToday) { ?>
                                <div class="alert alert-success">Votre présence a déjà été enregistrée aujourd'hui.</div>
                        <?php
                            } elseif ($hasAbsenceToday) { ?>
                                <div class="alert alert-info">Vous avez signalé une absence aujourd'hui.</div>
                        <?php
                            } else { ?>
                                <div class="d-grid gap-2">
                                    <button id="show-form-btn" class="btn btn-dark">Enregistrer ma présence</button>
                                    <button id="show-absence-btn" class="btn btn-outline-danger">Signaler une absence</button>
                                </div>
                        <?php
                            }
                        ?>

                        <?php if (! $isSunday) { ?>
                        <div id="presence-form" style="display:none;">
                            <form action="../models/add/add-presence-post.php" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="text" class="form-control" value="<?= date('d/m/Y') ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jour</label>
                                    <input type="text" class="form-control" value="<?= jourFrancais(date('Y-m-d')) ?>" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Heure</label>
                                    <input type="time" name="heure" class="form-control" value="<?= date('H:i') ?>" required>
                                    <div class="form-text">Vous pouvez personnaliser l'heure avant de valider.</div>
                                </div>

                                <button type="submit" name="register_presence" class="btn btn-dark w-100">Confirmer l'enregistrement</button>
                            </form>
                        </div>
                        <?php } ?>

                        <!-- Absence form -->
                        <div id="absence-form" style="display:none; margin-top:10px;">
                            <form action="../models/add/add-absence-post.php" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Motif de l'absence</label>
                                    <textarea name="reason" class="form-control" rows="3" placeholder="Facultatif: préciser le motif"></textarea>
                                </div>
                                <button type="submit" name="register_absence" class="btn btn-danger w-100">Signaler l'absence</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Historique des pointages</h5>
                        <p class="text-muted">Les 30 derniers enregistrements de présence pour votre compte.</p>
                        <div class="table-responsive">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Jour</th>
                                        <th>Type</th>
                                        <th>Heure</th>
                                        <th>Motif</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($presenceRecords)) {
                                        $count = 0;
                                        foreach ($presenceRecords as $record) {
                                            $count++;
                                            $type = $record['type'] ?? 'present';
                                            $heureDisplay = isset($record['heure']) && $record['heure'] !== null ? date('H:i:s', strtotime($record['heure'])) : '-';
                                            $motif = $record['reason'] ?? '-';
                                            $typeLabel = ($type === 'absent') ? 'Absence' : 'Présent'; ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><?= date('d/m/Y', strtotime($record['date'])) ?></td>
                                                <td><?= jourFrancais($record['date']) ?></td>
                                                <td><?= $typeLabel ?></td>
                                                <td><?= $heureDisplay ?></td>
                                                <td><?= htmlspecialchars($motif) ?></td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Aucun pointage trouvé.</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main><!-- End #main -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var showFormBtn = document.getElementById('show-form-btn');
            var presenceForm = document.getElementById('presence-form');
            var showAbsenceBtn = document.getElementById('show-absence-btn');
            var absenceForm = document.getElementById('absence-form');

            function toggleElement(btn, el) {
                if (!btn || !el) return;
                btn.addEventListener('click', function (event) {
                    event.preventDefault();
                    var isHidden = el.style.display === 'none' || el.style.display === '';
                    // hide other form if showing
                    if (el === presenceForm && absenceForm) absenceForm.style.display = 'none';
                    if (el === absenceForm && presenceForm) presenceForm.style.display = 'none';
                    el.style.display = isHidden ? 'block' : 'none';
                });
            }

            toggleElement(showFormBtn, presenceForm);
            toggleElement(showAbsenceBtn, absenceForm);
        });
    </script>

    <?php require_once('script.php') ?>

</body>

</html>
