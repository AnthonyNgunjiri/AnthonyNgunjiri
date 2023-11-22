<?php
// Establish a database connection (example using PDO)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "register-db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Remember to hash this for security

        // Validate login credentials against the 'admission' table
        $stmt = $conn->prepare("SELECT * FROM admission WHERE username = :username AND email = :email AND password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Check if a matching user is found in 'admission' table
        if ($stmt->rowCount() > 0) {
            // Insert user details into the 'login' table
            $stmt_insert = $conn->prepare("INSERT INTO login (username, email, password) VALUES (:username, :email, :password)");
            $stmt_insert->bindParam(':username', $username);
            $stmt_insert->bindParam(':email', $email);
            $stmt_insert->bindParam(':password', $password);
            $stmt_insert->execute();

            echo "Login successful. User details inserted into the login table.";
            // Redirect or perform further actions after successful login and insertion
        } else {
            echo "Invalid username, email, or password";
        }
    } else {
        echo "Form submission failed!";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
