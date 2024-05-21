<?php
// Get the form data
$username = $_POST['username'];
$password = $_POST['password'];

// Create a connection to the database
$host = "localhost";
$dbname = "login_raju";
$username_db = "root";
$password_db = "pass@123";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the query to check if the user exists
    $query = "SELECT * FROM login WHERE username = :username AND password = :password";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // User found, redirect to about.html
        header('Location: yuu.html');
        exit;
    } else {
        // User not found, print an error message
        echo "Invalid credentials. Please try again.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
