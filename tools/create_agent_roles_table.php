<?php
// Script: create_agent_roles_table.php
// 1) Create table agent_roles (agent_id, role_id)
// 2) Populate from agents.role_id if present

include(__DIR__ . '/../connexion/connexion.php');

try {
    // 1) create table if not exists
    $connexion->exec("CREATE TABLE IF NOT EXISTS agent_roles (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        agent_id INT NOT NULL,
        role_id INT NOT NULL,
        UNIQUE KEY uniq_agent_role (agent_id, role_id),
        INDEX idx_agent (agent_id),
        INDEX idx_role (role_id),
        CONSTRAINT fk_agentroles_agent FOREIGN KEY (agent_id) REFERENCES agents(id) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT fk_agentroles_role FOREIGN KEY (role_id) REFERENCES roles(id_role) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;");

    echo "Table agent_roles créée (ou existait déjà)\n";

    // 2) Populate from agents.role_id OR agents.id_role
    $colRes = $connexion->query("SHOW COLUMNS FROM agents LIKE 'role_id'")->fetch();
    $colName = '';
    if ($colRes) {
        $colName = 'role_id';
    } else {
        $colRes2 = $connexion->query("SHOW COLUMNS FROM agents LIKE 'id_role'")->fetch();
        if ($colRes2) {
            $colName = 'id_role';
        }
    }

    if ($colName) {
        $res = $connexion->query("SELECT id, $colName AS role_id FROM agents WHERE $colName IS NOT NULL");
    } else {
        $res = false;
    }
    $insert = $connexion->prepare("INSERT IGNORE INTO agent_roles (agent_id, role_id) VALUES (?, ?)");
    $count = 0;
    if ($res) {
        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $insert->execute([$row['id'], $row['role_id']]);
        $count += $insert->rowCount();
    }
    }
    echo "Lignes insérées dans agent_roles: $count\n";

} catch (Exception $e) {
    echo 'Erreur: ' . $e->getMessage() . "\n";
}
