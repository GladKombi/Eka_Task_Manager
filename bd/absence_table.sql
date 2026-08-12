-- Table for absences
CREATE TABLE `absences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent` int(11) NOT NULL,
  `date` date NOT NULL,
  `reason` text,
  `statut` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
