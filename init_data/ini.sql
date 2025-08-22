-- init_data/init.sql
CREATE DATABASE IF NOT EXISTS cachina;
USE cachina;

-- Aquí puedes agregar tus tablas y datos iniciales
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email) VALUES
('Usuario Ejemplo', 'ejemplo@email.com');