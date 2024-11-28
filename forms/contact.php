<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluye la librería PHPMailer
require '../vendor/autoload.php'; // Cambia la ruta si no usas Composer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if (!$name || !$email || !$subject || !$message) {
        die('Por favor, completa todos los campos.');
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'grupo004sa@gmail.com'; // Tu correo de Gmail
        $mail->Password = 'vyekbhjvptksovik';  // Contraseña de aplicación
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('grupo004sa@gmail.com', 'Formulario de Contacto'); // Desde
        $mail->addAddress('grupo004sa@gmail.com'); // Destinatario principal
        $mail->addReplyTo($email, $name); // Responder al remitente

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "
            <h3>Nuevo mensaje desde el formulario de contacto</h3>
            <p><strong>De:</strong> $name ($email)</p>
            <p><strong>Asunto:</strong> $subject</p>
            <p><strong>Mensaje:</strong><br>$message</p>
        ";
        $mail->AltBody = "De: $name ($email)\nAsunto: $subject\nMensaje:\n$message";

        // Enviar correo
        $mail->send();
        echo 'OK'; // Respuesta que detecta validate.js como éxito
    } catch (Exception $e) {
        echo 'Error: ' . $mail->ErrorInfo;
    }
} else {
    echo 'Método de solicitud no válido.';
}
