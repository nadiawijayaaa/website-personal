<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Debugging: Cek data POST yang diterima
echo "<pre>";
print_r($_POST);
echo "</pre>";

// Database connection details
$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "pengaduan"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $complaint = $_POST['complaint'];
    $category = $_POST['category'];
    $department = $_POST['department'];

    // Prepare and bind SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO complaints (name, email, complaint, category, department) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $complaint, $category, $department);

    // Execute the query
    if ($stmt->execute()) {
        echo "Pengaduan berhasil dikirim!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Form tidak disubmit.";
}
?>
