-- ================================================
-- BASE DE DATOS: SQL SERVER
-- Sistema de Gestión Documental
-- ================================================

CREATE DATABASE sgd_principal;
GO

USE sgd_principal;
GO

-- ================================================
-- TABLA: Usuarios
-- ================================================
CREATE TABLE Usuarios (
    id_usuario INT IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    rol VARCHAR(50) NOT NULL CHECK (rol IN ('Admin', 'Revisor', 'Aprobador', 'Operario')),
    activo BIT DEFAULT 1,
    fecha_creacion DATETIME DEFAULT GETDATE()
);
GO

-- ================================================
-- TABLA: Documentos
-- ================================================
CREATE TABLE Documentos (
    id_documento INT IDENTITY(1,1) PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT,
    tipo_archivo VARCHAR(20) NOT NULL,
    ruta_archivo VARCHAR(500) NOT NULL,
    estado VARCHAR(20) DEFAULT 'Borrador' CHECK (estado IN ('Borrador', 'Revision', 'Aprobado', 'Obsoleto')),
    version INT DEFAULT 1,
    id_creador INT FOREIGN KEY REFERENCES Usuarios(id_usuario),
    fecha_creacion DATETIME DEFAULT GETDATE(),
    fecha_actualizacion DATETIME DEFAULT GETDATE()
);
GO

-- ================================================
-- TABLA: Flujo de Aprobacion
-- ================================================
CREATE TABLE FlujoAprobacion (
    id_flujo INT IDENTITY(1,1) PRIMARY KEY,
    id_documento INT FOREIGN KEY REFERENCES Documentos(id_documento),
    id_usuario INT FOREIGN KEY REFERENCES Usuarios(id_usuario),
    accion VARCHAR(20) NOT NULL CHECK (accion IN ('Enviado', 'Aprobado', 'Rechazado')),
    comentario TEXT,
    fecha_accion DATETIME DEFAULT GETDATE()
);
GO

-- ================================================
-- DATOS DE PRUEBA
-- ================================================
INSERT INTO Usuarios (nombre, apellido, email, password_hash, rol)
VALUES 
('Admin', 'Sistema', 'admin@empresa.com', 'hash123', 'Admin'),
('Juan', 'Perez', 'juan@empresa.com', 'hash456', 'Revisor');
GO