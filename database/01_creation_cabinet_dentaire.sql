-- ============================================================
-- CABINET DENTAIRE Dr. DUPONT
-- Sequence 3 : Creation des tables
-- SGBD : MySQL / MariaDB
-- ============================================================

CREATE DATABASE IF NOT EXISTS cabinet_dentaire
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE cabinet_dentaire;

-- On supprime les tables si elles existent deja (ordre inverse des dependances)
DROP TABLE IF EXISTS rendez_vous;
DROP TABLE IF EXISTS actualites;
DROP TABLE IF EXISTS horaires;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS patients;
DROP TABLE IF EXISTS utilisateurs;


-- ============================================================
-- 1) UTILISATEURS  (Dr. Dupont et son equipe - back office)
-- Aucune cle etrangere : creee en premier
-- ============================================================
CREATE TABLE utilisateurs (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    nom           VARCHAR(100) NOT NULL,
    prenom        VARCHAR(100) NOT NULL,
    email         VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe  VARCHAR(255) NOT NULL,          -- stocke HACHE (password_hash)
    role          ENUM('admin', 'assistant') NOT NULL DEFAULT 'assistant',
    cree_le       DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 255 caracteres : un hash bcrypt fait 60 caracteres,
-- on prevoit large pour les futurs algorithmes de hachage.


-- ============================================================
-- 2) PATIENTS
-- ============================================================
CREATE TABLE patients (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nom             VARCHAR(100) NOT NULL,
    prenom          VARCHAR(100) NOT NULL,
    email           VARCHAR(150) NOT NULL UNIQUE,
    telephone       VARCHAR(20),
    date_naissance  DATE,
    cree_le         DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_patient_nom (nom)                   -- recherche rapide par nom
) ENGINE=InnoDB;


-- ============================================================
-- 3) SERVICES  (les soins proposes par le cabinet)
-- ============================================================
CREATE TABLE services (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nom          VARCHAR(150) NOT NULL,
    description  TEXT,
    duree        INT NOT NULL DEFAULT 30,          -- duree en minutes
    prix         DECIMAL(8,2) NOT NULL DEFAULT 0,  -- ex : 1250.00
    cree_le      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ============================================================
-- 4) HORAIRES  (horaires d'ouverture du cabinet)
-- Table independante : aucune cle etrangere
-- ============================================================
CREATE TABLE horaires (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    jour              ENUM('lundi','mardi','mercredi','jeudi',
                           'vendredi','samedi','dimanche') NOT NULL UNIQUE,
    heure_ouverture   TIME,
    heure_fermeture   TIME,
    ferme             BOOLEAN NOT NULL DEFAULT FALSE   -- TRUE si ferme ce jour-la
) ENGINE=InnoDB;


-- ============================================================
-- 5) ACTUALITES  (articles sante publies sur le site)
-- Depend de : utilisateurs (l'auteur)
-- ============================================================
CREATE TABLE actualites (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    titre             VARCHAR(200) NOT NULL,
    contenu           TEXT NOT NULL,
    image             VARCHAR(255),
    date_publication  DATE NOT NULL,
    utilisateur_id    INT,                         -- NULL autorise : voir SET NULL
    CONSTRAINT fk_actualite_utilisateur
        FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
        ON DELETE SET NULL,
    INDEX idx_actu_date (date_publication)         -- tri par date recente
) ENGINE=InnoDB;

-- ON DELETE SET NULL : si un membre de l'equipe quitte le cabinet,
-- ses articles restent en ligne mais perdent leur auteur.


-- ============================================================
-- 6) RENDEZ-VOUS
-- Depend de : patients ET services
-- Creee en dernier
-- ============================================================
CREATE TABLE rendez_vous (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    date_heure   DATETIME NOT NULL,
    statut       ENUM('en attente','confirme','annule') NOT NULL DEFAULT 'en attente',
    commentaire  TEXT,
    patient_id   INT NOT NULL,
    service_id   INT NOT NULL,
    cree_le      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_rdv_patient
        FOREIGN KEY (patient_id) REFERENCES patients(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_rdv_service
        FOREIGN KEY (service_id) REFERENCES services(id)
        ON DELETE RESTRICT,
    INDEX idx_rdv_date (date_heure),               -- affichage du planning
    INDEX idx_rdv_statut (statut)                  -- filtre par statut
) ENGINE=InnoDB;

-- ON DELETE CASCADE  : supprimer un patient supprime ses rendez-vous.
-- ON DELETE RESTRICT : on ne peut pas supprimer un service
--                      encore utilise par des rendez-vous (securite).


-- ============================================================
-- VERIFICATION
-- ============================================================
SHOW TABLES;
