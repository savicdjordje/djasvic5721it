CREATE DATABASE IF NOT EXISTS autolak_rezervacije CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE autolak_rezervacije;

CREATE TABLE administratori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ime_prezime VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO administratori (ime_prezime, email, password) VALUES
('Admin Adminović', 'admin@gmail.com', '$2y$10$3.4HbUzt24MmciIoFTdhue2FlTWlbSGpMijrgNbPksWl4QfPCu9li');
-- Lozinka za admin@gmail.com je 'admin123'

CREATE TABLE tip_usluge (
    id INT AUTO_INCREMENT PRIMARY KEY,
    naziv VARCHAR(100) NOT NULL,
    opis TEXT
);

INSERT INTO tip_usluge (naziv, opis) VALUES
('Poliranje', 'Usluge spoljašnjeg i unutrašnjeg poliranja'),
('Lakiranje', 'Lakiranje delova vozila');

CREATE TABLE usluga (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tip_usluge_id INT,
    naziv VARCHAR(100) NOT NULL,
    opis TEXT,
    cena DECIMAL(10,2) NOT NULL,
    slika VARCHAR(255),
    objavljeno BOOLEAN DEFAULT TRUE,
    istaknuto BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (tip_usluge_id) REFERENCES tip_usluge(id)
        ON DELETE SET NULL
);

INSERT INTO usluga (tip_usluge_id, naziv, opis, cena, slika, objavljeno, istaknuto) VALUES
(1, 'Lakiranje haube', 'Temeljno lakiranje haube automobila.', 12000.00, 'images/lakiranje_haube.jpg', TRUE, TRUE),
(2, 'Poliranje farova', 'Profesionalno poliranje prednjih farova.', 4000.00, 'images/poliranje_farova.jpg', TRUE, FALSE),
(2, 'Kompletno lakiranje', 'Lakiranje celog vozila sa izborom boje.', 35000.00, 'images/full_lakiranje.jpg', TRUE, TRUE);

CREATE TABLE rezervacije (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usluga_id INT,
    ime_prezime VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    marka_auta VARCHAR(50),
    model_auta VARCHAR(50),
    registracija_auta VARCHAR(20),
    dodatni_opis TEXT,
    datum_vreme DATETIME,
    odobreno BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (usluga_id) REFERENCES usluga(id)
        ON DELETE SET NULL
);

INSERT INTO rezervacije (usluga_id, ime_prezime, email, marka_auta, model_auta, registracija_auta, dodatni_opis, datum_vreme) VALUES
(1, 'Marko Marković', 'marko@gmail.com', 'Audi', 'A4', 'BG-123-AA', 'Molim vas da se obrati pažnja na zadnji deo haube.', '2025-04-01 10:00:00'),
(2, 'Jelena Jelić', 'jelena@gmail.com', 'Toyota', 'Yaris', 'NS-456-BB', 'Farovi su veoma izgrebani.', '2025-04-03 14:30:00'),
(3, 'Petar Petrović', 'petar@gmail.com', 'BMW', '320d', 'KG-789-CC', 'Kompletno lakiranje, boja: metalik siva.', '2025-04-05 09:00:00');
