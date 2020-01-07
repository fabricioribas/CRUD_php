<?php
// PDO PDO PDO PDO PDO PDO

/* Credenciais do banco de dados. */
define('DB_SERVER', '127.0.0.1');
define('DB_PORT', '8889');
define('DB_USERNAME', 'db_user');
define('DB_PASSWORD', 'g1g4m0m4s');
define('DB_NAME', 'db_form');
 
/* Conexão ao banco de dados MySQL */
try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    
// Mensagem de Erro PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}