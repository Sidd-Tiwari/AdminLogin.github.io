<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}
$username = $_SESSION['username'];
include 'db_connection.php';
$conn = OpenCon();
//fetch details of student from student table
$sql = "SELECT * FROM student WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fullname = $row['username'];
} else {
    $fullname = "No data found";
}

$stmt->close();

?>

<!-- html code start  -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    body {
        background-color: rgb(225, 251, 187);
    }
    table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: rgba(255, 255, 255, 0.7);
        
        /* Transparent white background */
    }

    td {
        font-family: 'Times New Roman', Times, serif;
        border: 2px dashed black;
    }
    th,
    td {
        padding: 10px;
        text-align: center;
    }
    tr{
        border: 2px dashed black;
    }
    td:hover{
        background-color:grey;
    }
    @media (max-width: 768px) {
        table {
            width: 100%;
        }
    }

    </style>
</head>

<body class="bg-light">
    <div class="mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class=" text-uppercase d-flex justify-content-center nowrap">
                    <h1 class="fw-bold mb-4 text-primary ">Student Record</h1>
                    <h1 class="fw-bold mb-4 text-dark ms-2">
                                <?php echo htmlspecialchars($username); ?> !</h1>
                </div>
                <!-- ---------------------- -->
                <?php
                function displayStudent($conn) {
                    $sql = "SELECT * FROM student";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        echo "<table class='table table-bordered table-striped'>";
                        echo "<thead class='table-dark'>";
                        echo "<tr>";
                        echo "<th>ID</th>";
                        
                        echo "<th>Name</th>";
                        echo "<th>Email</th>";
                        echo "<th>Sex</th>";
                        echo "<th>Age</th>";
                        echo "<th>Address</th>";
                        echo "<th>Mobile</th>";
                        echo "<th>To Update</th>";
                        echo "<th>To Delete</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>".$row['id']."</td>";
                            
                            
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['email']."</td>";
                            echo "<td>".$row['sex']."</td>";
                            echo "<td>".$row['age']."</td>";
                            echo "<td>".$row['address']."</td>";
                            echo "<td>".$row['mobile']."</td>";
                            echo "<td><a href='update_form.php?email=".$row['email']."' class='btn btn-outline-success fw-bold btn-fixed-width mt-2'>Update Data</a></td>";
                            echo "<td><a href='delete_data.php?id=".$row['id']."' class='btn btn-outline-danger fw-bold btn-fixed-width mt-2'>Delete Data</a></td>";
                            echo "</tr>";
                            

                        }
                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo "No enquiries found.";
                    }
                }
                displayStudent($conn);
                    ?>
                <!-- ---------------------- -->
                <div class="text-end">
                    <a href="addNew_form.php" class="btn btn-outline-primary fw-bold btn-fixed-width mt-2 ">+ Add
                        New</a>
                    <a href="logout.php" class="btn btn-outline-warning fw-bold btn-fixed-width mt-2">Logout</a>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
<?php
CloseCon($conn);
?>