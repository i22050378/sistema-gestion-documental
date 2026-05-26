-- ================================================
-- BASE DE DATOS: POSTGRESQL
-- Módulo de Consulta y Reportes (PHP)
-- ================================================

CREATE TABLE documentos_vigentes (
    id SERIAL PRIMARY KEY,
    id_documento_ref INT NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    tipo_archivo VARCHAR(20) NOT NULL,
    estado VARCHAR(20) NOT NULL,
    version INT NOT NULL,
    fecha_aprobacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    aprobado_por VARCHAR(100)
);

CREATE TABLE reportes_cumplimiento (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT,
    fecha_generacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    generado_por VARCHAR(100),
    total_documentos INT DEFAULT 0,
    total_aprobados INT DEFAULT 0,
    total_pendientes INT DEFAULT 0
);

-- Datos de prueba
INSERT INTO documentos_vigentes 
(id_documento_ref, titulo, tipo_archivo, estado, version, aprobado_por)
VALUES 
(1, 'Manual de Calidad ISO 9001', 'PDF', 'Aprobado', 1, 'Admin Sistema'),
(2, 'Procedimiento de Auditoría', 'DOCX', 'Aprobado', 2, 'Admin Sistema');