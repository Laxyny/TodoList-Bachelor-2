-- SQLBook: Code
-- Création de la table `utilisateurs`
CREATE TABLE `utilisateurs` (
    `id_utilisateur` INT AUTO_INCREMENT PRIMARY KEY,
    `utilisateur` VARCHAR(255) NOT NULL,
    `mot_de_passe` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'user') DEFAULT 'user'
);

-- Insertion des données dans la table `utilisateurs`
INSERT INTO `utilisateurs` (`id_utilisateur`, `utilisateur`, `mot_de_passe`, `role`) 
VALUES 
(1, 'user', 'qwerty', 'user'),
(2, 'admin', 'azerty', 'admin');

-- Création de la table `statut`
CREATE TABLE `statut` (
    `id_statut` INT AUTO_INCREMENT PRIMARY KEY,
    `libelle` VARCHAR(255) NOT NULL
);

-- Insertion des données dans la table `statut`
INSERT INTO `statut` (`id_statut`, `libelle`) 
VALUES 
(1, 'Créé'),
(2, 'En cours'),
(3, 'Effectué'),
(4, 'Supprimé');

-- Création de la table `priorites`
CREATE TABLE `priorites` (
    `id_priorite` INT AUTO_INCREMENT PRIMARY KEY,
    `libelle` VARCHAR(255) NOT NULL
);

-- Insertion des données dans la table `priorites`
INSERT INTO `priorites` (`id_priorite`, `libelle`) 
VALUES 
(1, 'Basse'),
(2, 'Normale'),
(3, 'Haute');

-- Création de la table `todo`
CREATE TABLE `todo` (
    `id_todo` INT AUTO_INCREMENT PRIMARY KEY,
    `titre` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `date_creation` DATE NOT NULL,
    `date_echeance` DATE NOT NULL,
    `id_statut` INT,
    `id_priorite` INT,
    `id_utilisateur` INT,
    FOREIGN KEY (`id_statut`) REFERENCES `statut`(`id_statut`),
    FOREIGN KEY (`id_priorite`) REFERENCES `priorites`(`id_priorite`),
    FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs`(`id_utilisateur`)
);
-- Insertion des données dans la table `todo`
INSERT INTO `todo` (`id_todo`, `titre`, `description`, `date_creation`, `date_echeance`, `id_statut`, `id_priorite`, `id_utilisateur`) 
VALUES 
(1, 'Acheter du pain', 'Boulangerie', '2024-01-29', '2024-01-30', 1, 1, 1),
(2, 'Réparer la voiture', 'Garagiste', '2024-05-22', '2024-05-22', 2, 2, 1),
(3, 'Réparer la voiture', 'Garagiste', '2024-05-22', '2024-05-22', 2, 2, 2);

-- Création de la table `modifications`
CREATE TABLE `modifications` (
    `id_modifications` INT AUTO_INCREMENT PRIMARY KEY,
    `date_modification` DATE NOT NULL,
    `raison_modification` TEXT NOT NULL,
    `id_todo` INT,
    FOREIGN KEY (`id_todo`) REFERENCES `todo`(`id_todo`)
);

-- Insertion des données dans la table `modifications`
INSERT INTO `modifications` (`id_modifications`, `date_modification`, `raison_modification`, `id_todo`) 
VALUES 
(1, '2024-01-29', 'Modification', 1);

-- Création de la table `categories`
CREATE TABLE `categories` (
    `id_categorie` INT AUTO_INCREMENT PRIMARY KEY,
    `libelle` VARCHAR(255) NOT NULL
);

-- Insertion des données dans la table `categories`
INSERT INTO `categories` (`id_categorie`, `libelle`) 
VALUES 
(1, 'Nourriture'),
(2, 'Loisirs'),
(3, 'Travail');
