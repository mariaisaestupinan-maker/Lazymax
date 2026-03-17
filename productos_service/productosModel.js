const mysql = require('mysql2/promise');

const connection = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'almacen'
});

async function traerProductos() {
    // Especificamos las columnas para mayor claridad
    const [rows] = await connection.query('SELECT id, nombre, precio, inventario FROM productos');
    return rows;
}

async function traerProducto(id) {
    // IMPORTANTE: Los parámetros siempre deben ir entre corchetes [id]
    const [rows] = await connection.query('SELECT id, nombre, precio, inventario FROM productos WHERE id = ?', [id]);
    return rows[0];
}

async function actualizarProducto(id, inventario) {
    // Esta función sirve para actualizar el stock manualmente desde el panel de admin
    const [rows] = await connection.query('UPDATE productos SET inventario = ? WHERE id = ?', [inventario, id]);
    return rows;
}

async function crearProducto(nombre, precio, inventario) {
    // Usamos el INSERT con columnas específicas, así evitamos problemas si el ID es autoincremental
    const query = 'INSERT INTO productos (nombre, precio, inventario) VALUES (?, ?, ?)';
    const [rows] = await connection.query(query, [nombre, precio, inventario]);
    return rows;
}

// Función adicional recomendada para el punto 5 del taller:
async function restarStock(id, cantidadAComprar) {
    const query = 'UPDATE productos SET inventario = inventario - ? WHERE id = ?';
    const [rows] = await connection.query(query, [cantidadAComprar, id]);
    return rows;
}

module.exports = {
    traerProductos, 
    traerProducto, 
    actualizarProducto, 
    crearProducto,
    restarStock // Agrégalo aquí también
};
