<?php
// delete_user.php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}
// $username = $_SESSION['username'];

include 'db_connection.php';
$conn = OpenCon();

if(isset($_GET['id'])&& is_numeric($_GET['id'])){
    $id = $_GET['id'];
    $username = $_SESSION['username'];

    // Delete user record
    $sql = "DELETE FROM student WHERE id = ? AND username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is",$id, $username);

    if ($stmt->execute()) {
        $_SESSION['message']= "User data delete successfully";
        header("Location: dashboard.html");
        exit();
    } else {
        $_SESSION['message'] = "Failed to delete user data.";
        header("Location: dashboard.php");
        exit();
    }

    $stmt->close();
}else{
    $_SESSION['message'] = " Invalid request";
    header("location:dashboard.php");
    exit();
}

CloseCon($conn);
?>
