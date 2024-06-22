<?php
session_start();
if (!isset($_SESSION['username'])) {
// to redirect login page
    header("Location: index.html");
    exit();
}
//username from session
$username = $_SESSION['username'];

include 'db_connection.php';
$conn = OpenCon();
// from 3 to 12 code to connect db and start session 
//user details if available
$sql = "SELECT * FROM student WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$fullname = '';
$email = '';
$sex = '';
$age = '';
$address = '';
$mobile = '';
// If user data exists in  the form fields
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $fullname = $row['name'];
    $email = $row['email'];
    $sex = $row['sex'];
    $age = $row['age'];
    $address = $row['address'];
    $mobile = $row['mobile'];
}
$stmt->close();
CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fill Data</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/update_form_style.css">
    <script src="js/validation.js"></script>

</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="text-uppercase d-flex justify-content-center nowrap">
                            <h1 class="fw-bold mb-4 text-primary">Form</h1>
                        </div>
                        <form action="formSubmit.php" method="post" onsubmit="return validateForm()">
                            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name:</label>
                                <input type="text" id="fullname" class="form-control" name="name"
                                    value="<?php echo htmlspecialchars($fullname); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" class="form-control" name="email"
                                    value="<?php echo htmlspecialchars($email); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="sex" class="form-label">Sex:</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="male" name="sex" value="Male"
                                        <?php echo ($sex === 'Male') ? 'checked' : ''; ?> required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="female" name="sex" value="Female"
                                        <?php echo ($sex === 'Female') ? 'checked' : ''; ?> required>
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="age" class="form-label">Age:</label>
                                <input type="number" id="age" class="form-control" name="age"
                                    value="<?php echo htmlspecialchars($age); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address:</label>
                                <input type="text" id="address" class="form-control" name="address"
                                    value="<?php echo htmlspecialchars($address); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="mobile" class="form-label">Mobile Number:</label>
                                <input type="phone" id="mobile" class="form-control" name="mobile" size="10"
                                    maxlength="10" value="<?php echo htmlspecialchars($mobile); ?>" required>
                            </div>
                            <div class="container mt-5">
                                    <div class="row ">
                                        <div class="col">
                                            <div class="d-flex justify-content-start">
                                                <a href="dashboard.php" class="btn btn-outline-dark fw-bold mt-4"> <i class="fas fa-tachometer-alt"></i> Dash</a>
                                            </div>
                                        </div>
                                        <div class="col ">
                                            <div class="d-flex justify-content-end ">
                                                <button type="submit" class="btn btn-outline-primary fw-bold mt-4"><i class='fas fa-paper-plane'></i> Submit</button>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>