<?php
require 'includes/config.php';

// Dati dell'utente
$username = 'admin';
$password = 'admin';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Query di inserimento
$sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param('ss', $username, $hashed_password);

    if ($stmt->execute()) {
        echo "Nuovo utente inserito con successo.";
    } else {
        echo "Errore durante l'inserimento dell'utente: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Errore nella preparazione della query: " . $conn->error;
}

$conn->close();
?>
