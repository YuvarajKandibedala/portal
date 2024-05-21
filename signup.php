<?php
// Database connection settings (update with your actual credentials)
$host = "localhost";
$username = "root";
$password = "pass@123";
$dbname = "login_raju";

// Create a database connection
$connection = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $c_password = $_POST["c_pass"];

    // Verify if passwords match
    if ($password !== $c_password) {
        die("Error: Passwords do not match.");
    }

    // Assuming you have stored the profile images in a folder named "profile_images"
    $profileImageFileName = $_FILES["profile_image"]["name"];
    $profileImageTmpName = $_FILES["profile_image"]["tmp_name"];
    $profileImageFileType = $_FILES["profile_image"]["type"];

    // Move the uploaded profile image to the "profile_images" folder
    $destinationFolderPath = "profile_images/";
    move_uploaded_file($profileImageTmpName, $destinationFolderPath . $profileImageFileName);

    // Insert data into the database
    $sql = "INSERT INTO user_data (name, email, password, profile_image) VALUES (?, ?, ?, ?)";
    $statement = $connection->prepare($sql);
    $statement->bind_param("ssss", $name, $email, $password, $profileImageFileName);

    if ($statement->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error registering user: " . $statement->error;
    }

    // Close the statement and connection
    $statement->close();
    $connection->close();
}
?>
