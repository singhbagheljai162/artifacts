<?php
require_once "../includes/config.php";

$email = "admin@artifact.com";
$password = "admin123";   // Change to the password you're testing

$stmt = $conn->prepare("SELECT password FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $user = $result->fetch_assoc();

    echo "<strong>Database Hash:</strong><br>";
    echo $user['password'];
    echo "<br><br>";

    if (password_verify($password, $user['password'])) {
        echo "<h2 style='color:green'>✅ Password Matched</h2>";
    } else {
        echo "<h2 style='color:red'>❌ Password Not Matched</h2>";
    }

} else {
    echo "User not found.";
}