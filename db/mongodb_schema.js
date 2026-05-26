// ================================================
// BASE DE DATOS: MONGODB
// Módulo de Metadatos y Búsqueda Rápida
// ================================================

db = db.getSiblingDB('sgd_metadata');

// Colección de metadatos de archivos
db.createCollection('metadatos_archivos');

db.metadatos_archivos.insertMany([
    {
        id_documento_ref: 1,
        titulo: "Manual de Calidad ISO 9001",
        etiquetas: ["calidad", "ISO", "manual", "norma"],
        tipo_archivo: "PDF",
        tamanio_kb: 2048,
        palabras_clave: ["procedimiento", "calidad", "certificacion"],
        fecha_indexado: new Date()
    },
    {
        id_documento_ref: 2,
        titulo: "Procedimiento de Auditoría",
        etiquetas: ["auditoria", "revision", "control"],
        tipo_archivo: "DOCX",
        tamanio_kb: 512,
        palabras_clave: ["auditoria", "interna", "externa"],
        fecha_indexado: new Date()
    }
]);

print("MongoDB: colecciones y datos creados correctamente");