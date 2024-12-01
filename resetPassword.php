<?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    try {
        // Database connection
        $dsn = 'mysql:host=localhost;dbname=human resource management system';
        $pdo = new PDO($dsn, 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Check in employees table
        $stmt = $pdo->prepare("SELECT * FROM employees WHERE reset_token = :token AND token_expires_at > NOW()");
        $stmt->execute(['token' => $token]);
        $user = $stmt->fetch();

        if (!$user) {
            // Check in recipient table
            $stmt = $pdo->prepare("SELECT * FROM recipient WHERE reset_token = :token AND token_expires_at > NOW()");
            $stmt->execute(['token' => $token]);
            $user = $stmt->fetch();
        }

        if (!$user) {
            echo "Invalid or expired token.";
            exit;
        }

        // Token is valid; proceed to reset password form
        echo "Token is valid. Proceed to reset password form.";
    } catch (Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
} else {
    echo "No token provided.";
}

?>
