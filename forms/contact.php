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
    $mail->Username = 'grupo004sa@gmail.com';
    $mail->Password = 'vyekbhjvptksovik';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Configuración del correo
    $mail->setFrom('grupo004sa@gmail.com', 'Formulario de Contacto');
    $mail->addAddress('grupo004sa@gmail.com'); // Destinatario
    $mail->addReplyTo($_POST['email'], $_POST['name']); // Responder al remitente

    // Contenido del mensaje
    $mail->isHTML(true);
    $mail->Subject = htmlspecialchars($_POST['subject']);
    $mail->Body = "
        <h3>Nuevo mensaje desde el formulario de contacto</h3>
        <p><strong>De:</strong> " . htmlspecialchars($_POST['name']) . " (" . htmlspecialchars($_POST['email']) . ")</p>
        <p><strong>Asunto:</strong> " . htmlspecialchars($_POST['subject']) . "</p>
        <p><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($_POST['message'])) . "</p>
    ";
    $mail->AltBody = "De: " . htmlspecialchars($_POST['name']) . " (" . htmlspecialchars($_POST['email']) . ")\n
    Asunto: " . htmlspecialchars($_POST['subject']) . "\n
    Mensaje: " . htmlspecialchars($_POST['message']);

    // Envía el correo
    $mail->send();
    echo 'Correo enviado exitosamente'; // Muestra un mensaje sencillo al usuario
  } catch (Exception $e) {
    echo 'Hubo un error al enviar el correo. Intenta nuevamente.';
  }
}
