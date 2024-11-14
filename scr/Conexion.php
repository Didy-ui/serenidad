<?php
// Configuración de la base de datos
$host = 'localhost';       // Dirección del servidor de base de datos
$dbname = 'spa_serenidad'; // Nombre de la base de datos
$username = 'root';        // Usuario de la base de datos (por defecto 'root' en XAMPP)
$password = '';            // Contraseña de la base de datos (por defecto vacío en XAMPP)

try {
    // Estableciendo la conexión con la base de datos utilizando PDO (PHP Data Objects)
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8"; // Data Source Name
    $pdo = new PDO($dsn, $username, $password);
    
    // Configuración para que se lancen excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si la conexión es exitosa, puedes agregar un mensaje de éxito o simplemente continuar
    // echo "Conexión exitosa a la base de datos $dbname.";

} catch (PDOException $e) {
    // Si ocurre un error en la conexión, se lanza una excepción
    echo "Error de conexión: " . $e->getMessage();
    die(); // Detiene la ejecución del script
}
?>

