USE sgd_principal;
GO

DROP TABLE IF EXISTS FlujoAprobacion;
DROP TABLE IF EXISTS Documentos;
DROP TABLE IF EXISTS Usuarios;
GO

CREATE TABLE Usuarios (
    IdUsuario INT IDENTITY(1,1) PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Apellido VARCHAR(100) NOT NULL,
    Email VARCHAR(150) UNIQUE NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL,
    Rol VARCHAR(50) NOT NULL,
    Activo BIT DEFAULT 1,
    FechaCreacion DATETIME DEFAULT GETDATE()
);
GO

CREATE TABLE Documentos (
    IdDocumento INT IDENTITY(1,1) PRIMARY KEY,
    Titulo VARCHAR(200) NOT NULL,
    Descripcion TEXT,
    TipoArchivo VARCHAR(20) NOT NULL,
    RutaArchivo VARCHAR(500) NOT NULL,
    Estado VARCHAR(20) DEFAULT 'Borrador',
    Version INT DEFAULT 1,
    IdCreador INT FOREIGN KEY REFERENCES Usuarios(IdUsuario),
    FechaCreacion DATETIME DEFAULT GETDATE(),
    FechaActualizacion DATETIME DEFAULT GETDATE()
);
GO

INSERT INTO Usuarios (Nombre, Apellido, Email, PasswordHash, Rol)
VALUES ('Admin', 'Sistema', 'admin@empresa.com', 'hash123', 'Admin');
GO