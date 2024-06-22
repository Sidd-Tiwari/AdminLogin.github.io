<?php
function OpenCon() {
    $conn = new mysqli("localhost", "root", "", "portal");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function CloseCon($conn) {
    $conn->close();
}
?>
