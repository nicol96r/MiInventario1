-- Crear la base de datos unificada
DROP DATABASE IF EXISTS inventario;
CREATE DATABASE inventario;
USE inventario;

-- Tabla de categorías
CREATE TABLE Categoria (
                           id_categoria INT PRIMARY KEY AUTO_INCREMENT,
                           nombre_categoria VARCHAR(50) NOT NULL,
                           descripcion_categoria VARCHAR(50) NOT NULL
);

-- Tabla de proveedores
CREATE TABLE Proveedor (
                           id_proveedor INT PRIMARY KEY AUTO_INCREMENT,
                           nombre_proveedor VARCHAR(100) NOT NULL,
                           direccion_proveedor VARCHAR(200),
                           telefono_proveedor VARCHAR(20)
);

-- Tabla de productos
CREATE TABLE Producto (
                          id_producto INT PRIMARY KEY AUTO_INCREMENT,
                          nombre_pro    ducto VARCHAR(100) NOT NULL,
                          imagen_producto LONGBLOB,
                          descripcion_producto TEXT,
                          precio_producto DECIMAL(10, 2) NOT NULL,
                          cantidad_producto INT,
                          estado_producto VARCHAR(30) NOT NULL,
                          fecha_ingreso DATE,
                          id_categoria INT NOT NULL,
                          id_proveedor INT NOT NULL,
                          FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria),
                          FOREIGN KEY (id_proveedor) REFERENCES Proveedor(id_proveedor)
);

-- Tabla de roles de usuario
CREATE TABLE rol_usuario (
                             id_rol INT AUTO_INCREMENT PRIMARY KEY,
                             nombre VARCHAR(50) UNIQUE NOT NULL
);

-- Insertar roles iniciales
INSERT INTO rol_usuario (nombre) VALUES ('Administrador'), ('Comprador'), ('Proveedor');

-- Tabla de usuarios
CREATE TABLE Usuario (
                         id_usuario INT AUTO_INCREMENT PRIMARY KEY,
                         tipo_documento ENUM('Cédula', 'Tarjeta de Identidad', 'Pasaporte') NOT NULL,
                         documento VARCHAR(20) UNIQUE NOT NULL,
                         nombre VARCHAR(50) NOT NULL,
                         apellido VARCHAR(50) NOT NULL,
                         fecha_nacimiento DATE NOT NULL,
                         genero ENUM('Masculino', 'Femenino', 'Otro') NOT NULL,
                         email VARCHAR(100) UNIQUE NOT NULL,
                         password VARCHAR(255) NOT NULL
);

-- Tabla de relación usuario - rol (muchos a muchos)
CREATE TABLE usuario_rol (
                             id_usuario_rol INT AUTO_INCREMENT PRIMARY KEY,
                             id_usuario INT NOT NULL,
                             id_rol INT NOT NULL,
                             FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
                             FOREIGN KEY (id_rol) REFERENCES rol_usuario(id_rol)
);
