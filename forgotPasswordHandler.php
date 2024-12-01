<?php

require __DIR__ . '/vendor/autoload.php'; 
require __DIR__ . '/Database/database.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['check_email'])) {
    $email = $_POST['email'];

    try {
        // Use the Database class to connect
        $database = new Database();
        $pdo = $database->connect();

        // Check if the email exists in employees
        $stmt = $pdo->prepare("SELECT * FROM employees WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        $table = 'employees';
        if (!$user) {
            // Check if the email exists in recipient
            $stmt = $pdo->prepare("SELECT * FROM recipient WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
            $table = 'recipient';
        }

        if (!$user) {
            echo json_encode(['status' => 'error', 'message' => 'Email not found in our records.']);
            exit;
        }
        

        // Generate token
        $token = bin2hex(random_bytes(16));
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Update database with token
        $updateStmt = $pdo->prepare("UPDATE $table SET reset_token = :token, token_expires_at = :expires_at WHERE email = :email");
        $updateStmt->execute(['token' => $token, 'expires_at' => $expires_at, 'email' => $email]);

        // Send token via email
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USERNAME'); 
        $mail->Password = getenv('SMTP_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('jedevv@gmail.com', 'SEDP HRMS');
        $mail->addAddress($email);
        $mail->Subject = 'Password Reset Token';
        $mail->Body = "Your password reset token is: $token";

        $mail->send();

        echo json_encode(['status' => 'success', 'message' => 'A reset token has been sent to your email.']);
    } catch (Exception $e) {
        // Log the error instead of exposing it
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'An internal error occurred. Please try again later.']);
    }
}
?>
