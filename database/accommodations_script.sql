-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS accommodations_db;
USE accommodations_db;

-- Crear tabla de usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);

-- Crear tabla de alojamientos
CREATE TABLE accommodations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255) DEFAULT 'https://res.cloudinary.com/dpo0d4fre/image/upload/v1736783357/casa_luna_ys6dnk.jpg'
);
-- En el caso que no se guarde una imagen ponemos una por defecto

-- Crear tabla para relacionar usuarios y alojamientos
CREATE TABLE user_accommodations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_accommodation INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_accommodation) REFERENCES accommodations(id) ON DELETE CASCADE
);

-- Insertar datos de prueba en usuarios
INSERT INTO users (name, email, password_hash, role) VALUES 
('Administrador', 'admin@example.com', '$2y$10$2ZYYn9IiC.PxQr6GirvaPe0o.YhwNEEg3.uZ.fRVgPKMpHNcMYw.a', 'admin'), -- Contraseña 12345
('Usuario', 'user@example.com', '$2y$10$v/WZrvLmI7cecfU8usg2Ae0BCTT9iFj/9/jkVHB0rvhMxfoJnx1zG', 'user'); -- Contraseña 12345

-- Insertar datos de prueba en alojamientos
INSERT INTO accommodations (name, location, description, price, image_url)
VALUES
('Hotel Sol', 'Calle Sol, 123', 'Un lugar acogedor cerca de la playa.', 150.00, 'https://res.cloudinary.com/dpo0d4fre/image/upload/v1736783357/hotel_sol_plfn3z.jpg'),
('Casa Luna', 'Avenida Luna, 45', 'Perfecto para escapadas románticas.', 200.00, 'https://res.cloudinary.com/dpo0d4fre/image/upload/v1736783357/casa_luna_ys6dnk.jpg'),
('Villa Estrella', 'Colina Estrella, 10', 'Lujo y confort con vistas espectaculares.', 350.00, 'https://res.cloudinary.com/dpo0d4fre/image/upload/v1736783359/villa_estrella_zln63z.jpg');

-- Insertar datos de prueba en la relación entre usuarios y alojamientos
INSERT INTO user_accommodations (id_user, id_accommodation) VALUES 
(2, 1),
(2, 2),
(2, 3);

-- Consultar los datos insertados
SELECT * FROM users;
SELECT * FROM accommodations;
SELECT * FROM user_accommodations;
-- Consultar alojamientos por usuario específico
SELECT a.* FROM accommodations a
INNER JOIN user_accommodations ua ON a.id = ua.id_accommodation
WHERE ua.id_user = 2;