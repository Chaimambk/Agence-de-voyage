CREATE DATABASE Prog_Web_Php;
USE Prog_Web_Php;

-- Table des villes
CREATE TABLE villes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    latitude DECIMAL(10, 6),
    longitude DECIMAL(10, 6)
);

-- Table des hôtels
CREATE TABLE hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    ville_id INT NOT NULL,
    description TEXT,
    image VARCHAR(255),
    adresse VARCHAR(255),
    latitude DECIMAL(10, 6),
    longitude DECIMAL(10, 6),
    FOREIGN KEY (ville_id) REFERENCES villes(id) ON DELETE CASCADE
);

-- Table des chambres
CREATE TABLE chambres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    capacite INT NOT NULL,
    type ENUM('adulte', 'enfant') NOT NULL,
    prix_par_nuit DECIMAL(10, 2) NOT NULL,
    disponible BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
);

-- Table des utilisateurs
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('utilisateur', 'admin') DEFAULT 'utilisateur'
);

-- Table des réservations (liée aux chambres plutôt qu'aux hôtels)
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    chambre_id INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    prix_total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (chambre_id) REFERENCES chambres(id) ON DELETE CASCADE
);

-- Table des activités (excursions, visites, etc.)
CREATE TABLE activites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ville_id INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    prix DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    FOREIGN KEY (ville_id) REFERENCES villes(id) ON DELETE CASCADE
);

-- Table des avis (liés aux hôtels et activités)
CREATE TABLE avis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    hotel_id INT,
    activite_id INT,
    note INT CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE,
    FOREIGN KEY (activite_id) REFERENCES activites(id) ON DELETE CASCADE
);

-- Table pour gérer l'occupation des chambres
CREATE TABLE occupation_chambres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chambre_id INT NOT NULL,
    date DATE NOT NULL,
    statut ENUM('réservé', 'disponible') NOT NULL,
    FOREIGN KEY (chambre_id) REFERENCES chambres(id) ON DELETE CASCADE
);

-- Table pour qu'un utilisateur puisse réserver plusieurs activités, et qu'une activité peut être réservée par plusieurs utilisateurs
CREATE TABLE reservations_activites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    activite_id INT NOT NULL,
    date_reservation DATE NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (activite_id) REFERENCES activites(id) ON DELETE CASCADE
);
