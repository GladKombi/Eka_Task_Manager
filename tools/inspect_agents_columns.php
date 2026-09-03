<?php
include(__DIR__ . '/../connexion/connexion.php');
$res = $connexion->query("SHOW COLUMNS FROM agents");
$cols = $res->fetchAll(PDO::FETCH_ASSOC);
foreach ($cols as $c) {
    echo $c['Field'] . " - " . $c['Type'] . "\n";
}
