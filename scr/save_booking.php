<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents("php://input"), true);

// Conexión a la base de datos (asegúrate de tener la configuración correcta)
$host = 'localhost';
$dbname = 'spa_serenidad';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Guardar datos en la base de datos
    $stmt = $pdo->prepare("INSERT INTO bookings (nombre, apellidos, correo_electronico, num_telefono, id_tratamiento) VALUES (?, ?, ?, ?, ? )");
    $stmt->execute([
        $data['nombre'], 
        $data['apellidos'], 
        $data['correo_electronico'], 
        $data['num_telefono'], 
        $data['id_tratamiento']
    ]);

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
