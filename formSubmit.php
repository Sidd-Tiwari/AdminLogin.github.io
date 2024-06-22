<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $fullname = $_POST['name'];
    $email = $_POST['email'];
    $sex = $_POST['sex'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];

     // Validate required fields
    if (empty($username) || empty($fullname) || empty($email) || empty($sex) || empty($age) || empty($address) || empty($mobile)) {
        die("All fields are required.");
    }

    // Include database connection file
    include 'db_connection.php';
    $conn = OpenCon();

    // Check if user data already exists
    $sql = "SELECT * FROM student WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sql = "UPDATE student SET name = ?, email = ?, sex = ?, age = ?, address = ?, mobile = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $fullname, $email, $sex, $age, $address, $mobile, $email);
    } else {
        $sql = "INSERT INTO student (username, name, email, sex, age, address, mobile) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $username, $fullname, $email, $sex, $age, $address, $mobile);
    }

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    CloseCon($conn);
} else {
    // Redirect if accessed directly without POST method
    header("Location: addNew_form.php");
    exit();
}
?>
