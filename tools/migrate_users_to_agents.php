<?php
// Script de migration: copie les comptes 'Admin' et 'ceo' de la table `users` vers `agents`.
// Usage: php tools/migrate_users_to_agents.php

include(__DIR__ . '/../connexion/connexion.php');

try {
    $select = $connexion->prepare("SELECT * FROM users WHERE foction IN ('Admin','ceo') AND statut=?");
    $select->execute([0]);
    $users = $select->fetchAll(PDO::FETCH_ASSOC);

    $check = $connexion->prepare("SELECT id FROM agents WHERE mail = ? LIMIT 1");
    $insert = $connexion->prepare("INSERT INTO agents (nom, postnom, prenom, genre, telephone, adresse, fonction, telephoneReferant, pwd, mail, profil, statut) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

    $inserted = 0;
    $skipped = 0;

    foreach ($users as $u) {
        $mail = trim($u['mail']);
        if ($mail === '') { $skipped++; continue; }
        $check->execute([$mail]);
        if ($check->fetch()) {
            $skipped++;
            continue;
        }

        $insert->execute([
            $u['nom'],
            $u['postnom'],
            $u['prenom'],
            '', // genre
            $u['telephone'] ?? '',
            '', // adresse
            0, // fonction -> 0 pour comptes admin/ceo (pas de département)
            '', // telephoneReferant
            $u['pwd'], // conserver le hash
            $mail,
            $u['profil'] ?? '',
            $u['statut'] ?? 0
        ]);

        $inserted++;
    }

    echo "Migration terminée. Insérés: $inserted, Ignorés: $skipped\n";
} catch (Exception $e) {
    echo 'Erreur lors de la migration: ' . $e->getMessage() . "\n";
}
