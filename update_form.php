<!-- update_form.php -->
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.html");
    exit();
}
$username = $_SESSION['username'];
$email = $_GET['email'];

include 'db_connection.php';
$conn = OpenCon();

// Fetch user details
$sql = "SELECT * FROM student WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$fullname = $row['name'] ?? '';
$email = $row['email'] ?? '';
$sex = $row['sex'] ?? '';
$age = $row['age'] ?? '';
$address = $row['address'] ?? '';
$mobile = $row['mobile'] ?? '';

$stmt->close();
CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data</title>
    <link rel="stylesheet" href="css/update_form_style.css">
    <script src="js/validation.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class=" text-uppercase d-flex justify-content-center nowrap">
                            <h1 class="fw-bold mb-4 text-primary ">Update Data </h1>
                        </div>
                        <form action="formSubmit.php" method="post" onsubmit="return validateForm()">
                            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
                            <div class="form-group">
                                <label for="name" class="form-label">Full Name:</label>
                                <input type="text" id="fullname" class="form-control" name="name"
                                    value="<?php echo htmlspecialchars($fullname); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo htmlspecialchars($email); ?>" required>
                            </div>
                            <div class="form-group">
                            <label for="sex" class="form-label">Sex:</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="male" name="sex" value="Male" <?php echo ($sex === 'Male') ? 'checked' : ''; ?> required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="female" name="sex" value="Female" <?php echo ($sex === 'Female') ? 'checked' : ''; ?> required>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="age" class="form-label">Age:</label>
                                <input type="number" class="form-control" id="age" name="age"
                                    value="<?php echo htmlspecialchars($age); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="address" class="form-label">Address:</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="<?php echo htmlspecialchars($address); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="mobile" class="form-label">Mobile Number:</label>
                                <input type="phone" class="form-control" id="mobile" name="mobile" size="10" maxlength="10"
                                    value="<?php echo htmlspecialchars($mobile); ?>" required>
                            </div>
                            
                            <div class="container mt-5">
                                    <div class="row ">
                                        <div class="col">
                                            <div class="d-flex justify-content-start">
                                                <a href="dashboard.php" class="btn btn-outline-dark fw-bold mt-4">Dash</a>
                                            </div>
                                        </div>
                                        <div class="col ">
                                            <div class="d-flex justify-content-end ">
                                                <button type="submit" class="btn btn-outline-primary fw-bold mt-4">Update</button>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>