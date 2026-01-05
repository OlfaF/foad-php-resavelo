CREATE DATABASE IF NOT EXISTS resavelo;
USE resavelo;

-- TABLE VELOS
CREATE TABLE velos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(6,2) NOT NULL,
    quantity INT NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- TABLE RESERVATIONS
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    velo_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_price DECIMAL(8,2),
    status ENUM('en_attente', 'validee', 'refusee', 'annulee') DEFAULT 'en_attente',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (velo_id) REFERENCES velos(id) ON DELETE CASCADE
);

-- DONNÉES DE TEST
INSERT INTO velos (name, price, quantity, description, image_url) VALUES
('Vélo de ville', 12.00, 5, 'Vélo confortable pour la ville', 'velo1.jpg'),
('VTT', 18.00, 3, 'VTT tout terrain', 'velo2.jpg'),
('Vélo électrique', 25.00, 2, 'Assistance électrique', 'velo3.jpg');
