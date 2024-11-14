<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Asumiendo que ya tienes PHPMailer instalado via Composer

$data = json_decode(file_get_contents("php://input"), true);

// Configuración del servidor de correo
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.mailtrap.io'; // Cambiar por el servidor SMTP que uses
    $mail->SMTPAuth = true;
    $mail->Username = 'your_username';
    $mail->Password = 'your_password';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Receptor y remitente
    $mail->setFrom('noreply@spa-serenidad.com', 'Spa Serenidad');
    $mail->addAddress($data['email']); // Cliente

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Confirmación de Reserva en Spa Serenidad';
    $mail->Body    = "<h1>Hola, {$data['name']}</h1>
                      <p>Tu reserva ha sido confirmada para el tratamiento <strong>{$data['treatment']}</strong> el {$data['date']} a las {$data['time']}.</p>
                      <p>Te esperamos en Spa Serenidad.</p>";

    $mail->send();
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $mail->ErrorInfo]);
}
?>
