-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS utilisateurs (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom_complet VARCHAR(100) NOT NULL,
    numero_telephone VARCHAR(20) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    solde_compte DECIMAL(10,2) DEFAULT 0.00,
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de transacciones
CREATE TABLE IF NOT EXISTS transactions (
    id_transaction INT AUTO_INCREMENT PRIMARY KEY,
    id_expediteur INT NOT NULL,
    id_destinataire INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    type_transaction ENUM('envoi', 'reception', 'retrait') NOT NULL,
    date_transaction TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    statut ENUM('en_cours', 'completee', 'annulee') DEFAULT 'en_cours',
    FOREIGN KEY (id_expediteur) REFERENCES utilisateurs(id_utilisateur),
    FOREIGN KEY (id_destinataire) REFERENCES utilisateurs(id_utilisateur)
);

-- Tabla de historial de movimientos
CREATE TABLE IF NOT EXISTS historique_mouvements (
    id_mouvement INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    type_mouvement ENUM('depot', 'retrait', 'transfert') NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    solde_avant DECIMAL(10,2) NOT NULL,
    solde_apres DECIMAL(10,2) NOT NULL,
    date_mouvement TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);

-- Tabla de contactos frecuentes
CREATE TABLE IF NOT EXISTS contacts_frequents (
    id_contact INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    numero_contact VARCHAR(20) NOT NULL,
    nom_contact VARCHAR(100) NOT NULL,
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);

-- Tabla de notificaciones
CREATE TABLE IF NOT EXISTS notifications (
    id_notification INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    message TEXT NOT NULL,
    type_notification ENUM('transaction', 'systeme', 'securite') NOT NULL,
    lu BOOLEAN DEFAULT FALSE,
    date_notification TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
); 