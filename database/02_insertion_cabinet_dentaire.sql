-- ============================================================
-- CABINET DENTAIRE Dr. DUPONT
-- Sequence 3 : Insertion des donnees de test
-- ============================================================

USE cabinet_dentaire;


-- ============================================================
-- 1) UTILISATEURS  (acces au back office)
-- ============================================================
-- ATTENTION : remplace les hash ci-dessous par les tiens.
-- Genere-les avec cette commande dans le terminal :
--   php -r "echo password_hash('Admin2026', PASSWORD_DEFAULT);"
-- Puis colle le resultat (il commence par \$2y\$) a la place du hash.

INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role) VALUES
('Dupont',  'Jean',   'jean.dupont@cabinet-dentaire.fr',   '$2y$10$7Atk9XWD2HNYcd ~ExSNsOciCzi1MwSR/g2Z4Gk.chEZ32gZZGbTW', 'admin'),
('Leroy',   'Sophie', 'sophie.leroy@cabinet-dentaire.fr',  '$2y$10$7Atk9XWD2HNYcd ~ExSNsOciCzi1MwSR/g2Z4Gk.chEZ32gZZGbTW', 'assistant');


-- ============================================================
-- 2) PATIENTS
-- ============================================================
INSERT INTO patients (nom, prenom, email, telephone, date_naissance) VALUES
('Martin',  'Julie',  'julie.martin@email.com',   '0612345678', '1990-04-12'),
('Dubois',  'Thomas', 'thomas.dubois@email.com',  '0623456789', '1985-11-03'),
('Petit',   'Sophie', 'sophie.petit@email.com',   '0634567890', '2001-07-25'),
('Bernard', 'Lucas',  'lucas.bernard@email.com',  '0645678901', '1978-01-30');


-- ============================================================
-- 3) SERVICES  (les soins du cabinet)
-- ============================================================
INSERT INTO services (nom, description, duree, prix) VALUES
('Consultation de controle', 'Examen complet de la sante bucco-dentaire.',      30,   30.00),
('Detartrage',               'Nettoyage professionnel et elimination du tartre.', 45,   60.00),
('Soin de carie',            'Traitement d une carie et pose d un composite.',   45,   90.00),
('Orthodontie',              'Pose et suivi d un appareil dentaire.',            60,  850.00),
('Implantologie',            'Pose d un implant dentaire en titane.',           120, 1200.00),
('Blanchiment dentaire',     'Eclaircissement de l email par gouttiere.',        60,  350.00);


-- ============================================================
-- 4) HORAIRES D'OUVERTURE
-- ============================================================
INSERT INTO horaires (jour, heure_ouverture, heure_fermeture, ferme) VALUES
('lundi',    '09:00:00', '18:00:00', FALSE),
('mardi',    '09:00:00', '18:00:00', FALSE),
('mercredi', '09:00:00', '12:30:00', FALSE),
('jeudi',    '09:00:00', '18:00:00', FALSE),
('vendredi', '09:00:00', '17:00:00', FALSE),
('samedi',   '09:00:00', '12:00:00', FALSE),
('dimanche', NULL,       NULL,       TRUE);


-- ============================================================
-- 5) ACTUALITES  (utilisateur_id : 1 = Dr. Dupont, 2 = Sophie Leroy)
-- ============================================================
INSERT INTO actualites (titre, contenu, image, date_publication, utilisateur_id) VALUES
('Bien se brosser les dents : les 3 erreurs frequentes',
 'Un brossage efficace dure deux minutes, matin et soir. Nous revenons ici sur les gestes a adopter au quotidien.',
 'brossage.jpg', '2026-06-10', 1),
('Le detartrage : a quelle frequence ?',
 'Un detartrage annuel est recommande pour la plupart des patients. Certains profils necessitent un suivi rapproche.',
 'detartrage.jpg', '2026-06-28', 1),
('Nouveaux horaires du cabinet cet ete',
 'Le cabinet adapte ses horaires pendant la periode estivale. Pensez a anticiper vos prises de rendez-vous.',
 NULL, '2026-07-15', 2);


-- ============================================================
-- 6) RENDEZ-VOUS
-- patient_id : 1=Julie, 2=Thomas, 3=Sophie, 4=Lucas
-- service_id : 1=Controle, 2=Detartrage, 3=Carie, 4=Ortho, 5=Implant, 6=Blanchiment
-- ============================================================
INSERT INTO rendez_vous (date_heure, statut, commentaire, patient_id, service_id) VALUES
('2026-08-05 09:30:00', 'confirme',    'Premiere visite.',              1, 1),
('2026-08-05 14:00:00', 'confirme',    NULL,                            2, 2),
('2026-08-12 10:00:00', 'en attente',  'Douleur molaire inferieure.',   1, 3),
('2026-08-18 11:00:00', 'en attente',  NULL,                            3, 4),
('2026-08-20 15:30:00', 'annule',      'Annule par le patient.',        4, 2),
('2026-09-02 09:00:00', 'confirme',    'Suivi post-operatoire.',        4, 5),
('2026-09-10 16:00:00', 'en attente',  NULL,                            3, 6);


-- ============================================================
-- VERIFICATIONS DES RELATIONS
-- ============================================================

-- Les rendez-vous avec le nom du patient et le soin concerne
SELECT rv.date_heure,
       CONCAT(p.prenom, ' ', p.nom) AS patient,
       s.nom AS service,
       rv.statut
FROM rendez_vous rv
JOIN patients p ON rv.patient_id = p.id
JOIN services s ON rv.service_id = s.id
ORDER BY rv.date_heure;

-- Les actualites avec leur auteur
SELECT a.titre, a.date_publication,
       CONCAT(u.prenom, ' ', u.nom) AS auteur
FROM actualites a
LEFT JOIN utilisateurs u ON a.utilisateur_id = u.id
ORDER BY a.date_publication DESC;

-- Nombre de rendez-vous par patient
SELECT CONCAT(p.prenom, ' ', p.nom) AS patient,
       COUNT(rv.id) AS nb_rendez_vous
FROM patients p
LEFT JOIN rendez_vous rv ON p.id = rv.patient_id
GROUP BY p.id;
