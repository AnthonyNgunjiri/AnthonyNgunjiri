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
        $course = $_POST['course'];

        // Check if username already exists
        $checkUsername = $conn->prepare("SELECT * FROM admission WHERE username = :username");
        $checkUsername->bindParam(':username', $username);
        $checkUsername->execute();

        if ($checkUsername->rowCount() > 0) {
            echo "Username already exists. Please choose a different username.";
        } else {
            // Insert data into the database
            $stmt = $conn->prepare("INSERT INTO admission (username, email, password, course) VALUES (:username, :email, :password, :course)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password); // Remember, for real applications, hash the password
            $stmt->bindParam(':course', $course);
            $stmt->execute();

            echo "Form submitted successfully!";
        }
    } else {
        echo "Form submission failed!";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
