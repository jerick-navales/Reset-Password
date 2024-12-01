<?php
if (isset($_POST['verify_token'])) {
    $email = $_POST['email'];
    $token = $_POST['token'];

    try {
        $dsn = 'mysql:host=localhost;dbname=human resource management system';
        $pdo = new PDO($dsn, 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Validate token
        $stmt = $pdo->prepare("SELECT * FROM employees WHERE email = :email AND reset_token = :token AND token_expires_at > NOW() UNION SELECT * FROM recipient WHERE email = :email AND reset_token = :token AND token_expires_at > NOW()");
        $stmt->execute(['email' => $email, 'token' => $token]);
        $user = $stmt->fetch();

        if (!$user) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid or expired token.']);
        } else {
            echo json_encode(['status' => 'success', 'message' => 'Token verified.']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}
?>
