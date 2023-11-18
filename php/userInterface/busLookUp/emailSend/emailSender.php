<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require($_SERVER['DOCUMENT_ROOT'] . '/Proyecto Final/vendor/autoload.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $asunto = "Reserva en ViaUY ";
    $asunto .= $_POST["tiquet"];
    $msg = $_POST["msg"];

    $mail = new PHPMailer(true);

    try {
        // Configura el servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'viauy.snowsouls@gmail.com';
        $mail->Password = 'kouj dzkn knuf eyog';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Configura el remitente y el destinatario
        $mail->setFrom('viauy.snowsouls@gmail.com', 'ViaUY');
        $mail->addAddress($email);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $msg;

        // Adjuntar archivos (opcional)
        // $mail->addAttachment('ruta/al/archivo.pdf');

        // Enviar el correo
        $mail->send();
        $response = array('status' => 'success', 'message' => 'Se le ha enviado un email con la información de su reserva');
    } catch (Exception $e) {
        $response = array('status' => 'error', 'message' => 'Lo sentimos, hubo un error al enviar el email', 'errorMessage' => $mail->ErrorInfo);
    }



    header('Content-Type: application/json');
    echo json_encode($response);

} else {
    echo 'Método no permitido';
}


