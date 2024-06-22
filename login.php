<?php
session_start();

// Include database connection file
include 'db_connection.php';
$conn = OpenCon();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate username and password
    if (preg_match('/^[^\s]{4,}$/', $username) && preg_match('/^[^\s]{4,}$/', $password)) {
        // Fetch user details from the database
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Set session variable
                $_SESSION['username'] = $username;
                // Redirect to the dashboard page
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "Invalid username.";
        }

        // Close statement and connection
        $stmt->close();
    } else {
        echo "Invalid username or password.";
    }
}

CloseCon($conn);
?>
