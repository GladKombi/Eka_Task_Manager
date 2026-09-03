<?php
// Script de migration :
// 1) Crée la table `roles` (id_role, nom_role)
// 2) Insère les rôles Admin, ceo, Agent
// 3) Ajoute la colonne `role_id` à `agents` et crée une FK vers roles.id_role
// 4) Remplit role_id en se basant sur la table `users` (si correspondance mail) pour Admin/ceo
//    et met 'Agent' pour les autres agents

include(__DIR__ . '/../connexion/connexion.php');

try {
    // Ne pas utiliser de transaction globale ici (les opérations DDL provoquent des commits implicites en MySQL)

    // 1) Créer la table roles si n'existe pas
    echo "Étape: créer table roles\n";
    $connexion->exec("CREATE TABLE IF NOT EXISTS roles (
        id_role INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nom_role VARCHAR(50) NOT NULL UNIQUE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    // 2) Insérer les rôles sans dupliquer
    $stmtInsertRole = $connexion->prepare("INSERT IGNORE INTO roles (nom_role) VALUES (?)");
    $roles = ['Admin', 'ceo', 'Agent'];
    foreach ($roles as $r) {
        $stmtInsertRole->execute([$r]);
    }
    echo "Étape: rôles insérés\n";

    // 3) Ajouter la colonne role_id si elle n'existe pas
    $row = $connexion->query("SHOW COLUMNS FROM agents LIKE 'role_id'")->fetch();
    if (!$row) {
        $connexion->exec("ALTER TABLE agents ADD COLUMN role_id INT NULL AFTER fonction;");
        echo "Étape: colonne role_id ajoutée\n";
    } else {
        echo "Étape: colonne role_id existe déjà\n";
    }

    // 4) Peupler role_id pour les agents ayant une correspondance dans users
    // Mapping users.foction -> roles.nom_role
    $selectUsers = $connexion->prepare("SELECT mail, foction FROM users WHERE foction IN ('Admin','ceo')");
    $selectUsers->execute();
    $users = $selectUsers->fetchAll(PDO::FETCH_ASSOC);

    $getRoleId = $connexion->prepare("SELECT id_role FROM roles WHERE nom_role = ? LIMIT 1");
    $updateAgentRole = $connexion->prepare("UPDATE agents SET role_id = ? WHERE mail = ? LIMIT 1");

    foreach ($users as $u) {
        $roleName = $u['foction'];
        $mail = trim($u['mail']);
        if ($mail === '') continue;
        $getRoleId->execute([$roleName]);
        $rid = $getRoleId->fetchColumn();
        if ($rid) {
            $updateAgentRole->execute([$rid, $mail]);
        }
    }
    echo "Étape: mise à jour role_id depuis users terminée\n";

    // 5) Pour les agents sans role_id, définir 'Agent'
    $getAgentRoleId = $connexion->prepare("SELECT id_role FROM roles WHERE nom_role = 'Agent' LIMIT 1");
    $getAgentRoleId->execute();
    $agentRid = $getAgentRoleId->fetchColumn();
    if ($agentRid) {
        $connexion->exec("UPDATE agents SET role_id = $agentRid WHERE role_id IS NULL;");
    }
    echo "Étape: valeurs Agent assignées là où nécessaire\n";

    // 6) Ajouter contrainte FK si pas déjà existante
    // Vérifier si la contrainte existe
    $fkExists = false;
    $sql = "SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='agents' AND COLUMN_NAME='role_id' AND REFERENCED_TABLE_NAME='roles'";
    $res = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    if (count($res) > 0) {
        $fkExists = true;
    }
    if (!$fkExists) {
        // Nommer la contrainte fk_agents_role
        $connexion->exec("ALTER TABLE agents ADD CONSTRAINT fk_agents_role FOREIGN KEY (role_id) REFERENCES roles(id_role) ON UPDATE CASCADE ON DELETE RESTRICT;");
    }
    echo "Étape: contrainte FK ajoutée si nécessaire\n";

    // 7) Optionnel: rendre role_id NOT NULL (après remplissage)
    $connexion->exec("ALTER TABLE agents MODIFY role_id INT NOT NULL;");
    echo "Étape: role_id rendu NOT NULL\n";

    echo "Migration roles effectuée avec succès.\n";
} catch (Exception $e) {
    if ($connexion && $connexion->inTransaction()) {
        $connexion->rollBack();
    }
    echo 'Erreur: ' . $e->getMessage() . "\n";
}
