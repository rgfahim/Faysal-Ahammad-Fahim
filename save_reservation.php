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
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $reservation_date = $conn->real_escape_string($_POST['reservation_date']);
    $reservation_time = $conn->real_escape_string($_POST['reservation_time']);
    $service = $conn->real_escape_string($_POST['service']);

    // Insert data into the database
    $sql = "INSERT INTO reservations (name, email, reservation_date, reservation_time, service) 
            VALUES ('$name', '$email', '$reservation_date', '$reservation_time', '$service')";

    if ($conn->query($sql) === TRUE) {
        echo "<script type='text/javascript'>
                alert('Reservation successfully saved!');
                window.location.href = 'thank_you.html'; // Redirect to a thank you page
              </script>";
    } else {
        echo "<script type='text/javascript'>
                alert('Error: " . $conn->error . "');
              </script>";
    }
}

$conn->close();
?>
