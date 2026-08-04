<?php
$statut=0;
$user=$_SESSION['iduser'];
# Selection des terrains
$getTerrain = $connexion->prepare("SELECT `terrain`.*, participation.terrain, participation.agent, partenaire.Denomination FROM `terrain`,`partenaire`,participation WHERE terrain.partenaire=partenaire.id AND terrain.statut=? AND participation.agent=? ORDER BY `terrain`.`id` DESC;");
$getTerrain->execute([$statut, $user]);