<?php
if (isset($_POST['update_password'])) {
    $email = $_POST['email'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    try {
        $dsn = 'mysql:host=localhost;dbname=human resource management system';
        $pdo = new PDO($dsn, 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Update password
        $stmt = $pdo->prepare("UPDATE employees SET password = :password, reset_token = NULL, token_expires_at = NULL WHERE email = :email");
        if ($_POST['user_type'] == 'recipient') {
            $stmt = $pdo->prepare("UPDATE recipient SET password = :password, reset_token = NULL, token_expires_at = NULL WHERE email = :email");
        }
        $stmt->execute(['password' => $new_password, 'email' => $email]);

        echo json_encode(['status' => 'success', 'message' => 'Password has been updated successfully.']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}
?>
