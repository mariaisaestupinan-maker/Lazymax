const mysql = require('mysql2/promise');

const connection = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'almacen'
});

async function traerUsuarios() {
    const result = await connection.query('SELECT * FROM usuarios');
    return result[0];
}

async function traerUsuario(usuario) {
    const result = await connection.query('SELECT * FROM usuarios WHERE usuario = ?', [usuario]);
    return result[0];
}

async function validarUsuario(usuario, password) {
    // Usamos columnas específicas para evitar errores
    const result = await connection.query('SELECT * FROM usuarios WHERE usuario = ? AND password = ?', [usuario, password]);
    return result[0];
}

async function crearUsuario(nombre, email, usuario, password) {
    // IMPORTANTE: Definimos las columnas para que el INSERT sea preciso
    const query = 'INSERT INTO usuarios (nombre, email, usuario, password) VALUES (?, ?, ?, ?)';
    const result = await connection.query(query, [nombre, email, usuario, password]);
    return result;
}

module.exports = {
    traerUsuarios, traerUsuario, validarUsuario, crearUsuario
};