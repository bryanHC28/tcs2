const dbName = 'miBaseDeDatos';
const dbVersion = 1;
let db;

const request = indexedDB.open(dbName, dbVersion);

request.onupgradeneeded = function(event) {
    db = event.target.result;
    console.log('Base de datos creada o actualizada.');

    if (!db.objectStoreNames.contains('almacenDeObjetos')) {
        db.createObjectStore('almacenDeObjetos', { keyPath: 'id', autoIncrement: true });
    }
};
 