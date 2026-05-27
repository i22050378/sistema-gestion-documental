// ================================================
// SERVICIO DE BÚSQUEDA - NODE.JS + MONGODB
// ================================================
const express = require('express');
const { MongoClient } = require('mongodb');
const cors = require('cors');

const app = express();
app.use(cors());
app.use(express.json());

// Configuración de MongoDB
const MONGO_URL = process.env.MONGO_URL || 'mongodb://admin:Admin1234!@mongodb:27017';
const DB_NAME = 'sgd_metadata';
const PORT = process.env.PORT || 3000;

let db;

// Conectar a MongoDB
async function conectarMongo() {
    try {
        const client = new MongoClient(MONGO_URL);
        await client.connect();
        db = client.db(DB_NAME);
        console.log('✅ Conectado a MongoDB correctamente');
    } catch (error) {
        console.error('❌ Error conectando a MongoDB:', error);
        setTimeout(conectarMongo, 5000);
    }
}

// ================================================
// RUTAS
// ================================================

// Ruta principal
app.get('/', (req, res) => {
    res.json({
        mensaje: '🔍 Servicio de Búsqueda SGD',
        version: '1.0.0',
        endpoints: [
            'GET /buscar?q=termino',
            'GET /documentos',
            'GET /documento/:id'
        ]
    });
});

// Buscar documentos por término
app.get('/buscar', async (req, res) => {
    try {
        const termino = req.query.q || '';
        const coleccion = db.collection('metadatos_archivos');

        const resultados = await coleccion.find({
            $or: [
                { titulo: { $regex: termino, $options: 'i' } },
                { etiquetas: { $regex: termino, $options: 'i' } },
                { palabras_clave: { $regex: termino, $options: 'i' } }
            ]
        }).toArray();

        res.json({
            termino: termino,
            total: resultados.length,
            resultados: resultados
        });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Obtener todos los documentos
app.get('/documentos', async (req, res) => {
    try {
        const coleccion = db.collection('metadatos_archivos');
        const documentos = await coleccion.find({}).toArray();
        res.json({
            total: documentos.length,
            documentos: documentos
        });
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Obtener documento por ID de referencia
app.get('/documento/:id', async (req, res) => {
    try {
        const coleccion = db.collection('metadatos_archivos');
        const documento = await coleccion.findOne({
            id_documento_ref: parseInt(req.params.id)
        });

        if (!documento) {
            return res.status(404).json({ error: 'Documento no encontrado' });
        }

        res.json(documento);
    } catch (error) {
        res.status(500).json({ error: error.message });
    }
});

// Iniciar servidor
conectarMongo().then(() => {
    app.listen(PORT, () => {
        console.log(`🚀 Servidor corriendo en puerto ${PORT}`);
    });
});