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
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $password = $conn->real_escape_string($_POST['password']); // Storing plain text password

    // Check if the user already exists
    $check_user = "SELECT * FROM user WHERE user_id = '$user_id' OR email = '$email'";
    $result = $conn->query($check_user);

    if ($result->num_rows > 0) {
        // User already exists, show popup message
        echo "<script type='text/javascript'>
                    alert('User with this ID or email already exists. Please use a different ID or email.');
                    window.location.href = 'login.html'; // Redirect to login page
                  </script>";
        
    } else {
        // Insert data into the table
        $sql = "INSERT INTO user (user_id, full_name, email, phone_number, password)
                VALUES ('$user_id', '$full_name', '$email', '$phone_number', '$password')";

        if ($conn->query($sql) === TRUE) {
            // After successful registration, show success message and redirect to login.html
            echo "<script type='text/javascript'>
                    alert('Registration successful!');
                    window.location.href = 'login.html'; // Redirect to login page
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
