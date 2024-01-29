INSERT INTO `utilisateurs` (`id_utilisateur`, `email`, `mot_de_passe`) VALUES (1, 'kevin.gregoire@e-cdp.com', 'OpenIT');

INSERT INTO `todo` (`id_todo`, `titre`, `description`, `date_creation`, `date_echeance`, `id_statut`, `id_priorite`, `id_utilisateur`) VALUES (1, 'Acheter du pain', 'Boulangerie', '2024-01-29', '2014-01-30', 1, 1, 1);

INSERT INTO `statut` (`id_statut`, `libelle`) VALUES (1, 'Créé', 2, 'En cours', 3, 'Effectué', 4, 'Supprimé');

INSERT INTO `priorites` (`id_priorite`, `libelle`) VALUES (1, 'Basse', 2, 'Normale', 3, 'Haute');

INSERT INTO `modifications` (`id_modifications`, `date_modification`, `raison_modification`, `id_todo`) VALUES (1, '2024-01-29', 'Modification', 1);

INSERT INTO `categories` (`id_priorite`, `libelle`) VALUES (1, 'Nourriture', 2, 'Loisirs', 3, 'Travail');