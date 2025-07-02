<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: registration.php");
        exit;
    }

    $hashed_password = md5($password);

    $sql = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $_SESSION['error'] = "Username or email already exists.";
        header("Location: registration.php");
        exit;
    }

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "Registration successful. Please login.";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
        header("Location: registration.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Explorer Center-Sri Lanka</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />

    <!-- Base URL -->
    <!-- <base href="/" /> -->

    <!-- Favicon -->
    <link href="img/icon.webp" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Font Awesome -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
        rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link
        href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css"
        rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
</head>

<body>
    <!-- User Information -->
    <div>
        <a href="/adminDashboard.php">
            <img class="dashboardImg" src="img/dashboard.png" alt="dashboard Icon">
        </a>
        <div class="user-info">
            <img src="img/user.png" alt="User Icon">
            <div>
                <h5>Hello, <?= htmlspecialchars($_SESSION['username']); ?></h5>
                <a href="/logout.php" onclick="return confirmLogout()">Logout</a>
            </div>
        </div>
    </div>

    <!-- Registration Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-3 pb-3">
                <h1>Registration</h1>
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px">
                    Create your account
                </h6>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-form bg-white" style="padding: 30px">
                        <div id="success"></div>
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['success'])) {
                            echo '<p style="color: green;">' . $_SESSION['success'] . '</p>';
                            unset($_SESSION['success']);
                        }
                        ?>
                        <form action="/registration.php" method="POST">
                            <div class="control-group">
                                <input type="text" class="form-control p-4" id="username" placeholder="Your username" name="username"
                                    required="required" data-validation-required-message="Please enter your username" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <input type="email" class="form-control p-4" id="email" placeholder="Your email" name="email"
                                    required="required" data-validation-required-message="Please enter your email" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <input type="password" class="form-control p-4" id="password" placeholder="Your password" name="password"
                                    required="required" data-validation-required-message="Please enter your password" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <input type="password" class="form-control p-4" id="confirm_password" placeholder="Confirm your password" name="confirm_password"
                                    required="required" data-validation-required-message="Please confirm your password" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary py-3 px-4" type="submit" id="sendMessageButton">Register</button>
                                <br><br>
                                <a href="/login.php" style="color: rgb(91, 197, 232); text-decoration: none;">Already have an account? Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Registration End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
