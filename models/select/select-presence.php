<?php
# Chargement des présences et absences pour l'agent connecté
if (!isset($_SESSION['iduser']) || empty($_SESSION['iduser'])) {
    header('Location:../ops.php');
    exit;
}

$user = $_SESSION['iduser'];
$today = date('Y-m-d');
$statut = 0;

# Présence du jour (type présence)
$getTodayPresence = $connexion->prepare("SELECT COUNT(*) AS count FROM `presence` WHERE agent=? AND date=? AND statut=?;");
$getTodayPresence->execute([$user, $today, $statut]);
$todayPresence = $getTodayPresence->fetch();
$hasRegisteredToday = ($todayPresence && $todayPresence['count'] > 0);

# Absence du jour (type absence)
$getTodayAbsence = $connexion->prepare("SELECT COUNT(*) AS count FROM `absences` WHERE agent=? AND date=? AND statut=?;");
$getTodayAbsence->execute([$user, $today, $statut]);
$todayAbsence = $getTodayAbsence->fetch();
$hasAbsenceToday = ($todayAbsence && $todayAbsence['count'] > 0);

# Récupérer les présences
$getPresence = $connexion->prepare("SELECT p.*, a.nom, a.postnom, a.prenom FROM `presence` p JOIN `agents` a ON p.agent=a.id WHERE p.agent=? AND p.statut=?");
$getPresence->execute([$user, $statut]);
$pres = $getPresence->fetchAll(PDO::FETCH_ASSOC);

# Récupérer les absences
$getAbsence = $connexion->prepare("SELECT * FROM `absences` WHERE agent=? AND statut=?");
$getAbsence->execute([$user, $statut]);
$abs = $getAbsence->fetchAll(PDO::FETCH_ASSOC);

# Fusionner et normaliser les évènements (présence/absence)
$presenceRecords = [];
foreach ($pres as $p) {
    $presenceRecords[] = [
        'type' => 'present',
        'date' => $p['date'],
        'heure' => $p['heure'],
        'reason' => null,
    ];
}
foreach ($abs as $a) {
    $presenceRecords[] = [
        'type' => 'absent',
        'date' => $a['date'],
        'heure' => $a['heure'] ?? null,
        'reason' => $a['reason'] ?? null,
    ];
}

# Trier par date (desc) puis heure (desc)
usort($presenceRecords, function ($x, $y) {
    if ($x['date'] === $y['date']) {
        $hx = $x['heure'] ?? '00:00:00';
        $hy = $y['heure'] ?? '00:00:00';
        return strcmp($hy, $hx);
    }
    return strcmp($y['date'], $x['date']);
});
