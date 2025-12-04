<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // Update with your MySQL password
$dbname = "catwise";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input
    $email = $conn->real_escape_string($_POST['email']);
    $input_password = $_POST['password']; // Plain text password entered by user

    // Query to get the user by email
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();

        // Compare the entered password with the stored password (plain text)
        if ($input_password === $user['password']) {
            // Password is correct, login successful
            echo "<script type='text/javascript'>
                    alert('Login successful!');
                    window.location.href = 'index.html'; // Redirect to the dashboard or another page
                  </script>";
            exit; // Stop further script execution
        } else {
            // Invalid password
            echo "<script type='text/javascript'>
                    alert('Invalid password. Please try again.');
                  </script>";
        }
    } else {
        // User not found
        echo "<script type='text/javascript'>
                alert('No user found with this email. Please check your email.');
              </script>";
    }
}

// Close the connection
$conn->close();
?>
