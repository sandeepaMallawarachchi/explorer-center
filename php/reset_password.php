<?php
session_start();
include('db.php');

// Check if the token is present in the URL
if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);

    // Validate token
    $sql = "SELECT * FROM users WHERE reset_token = '$token'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Token is valid, display password reset form
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
            $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

            // Check if passwords match
            if ($new_password === $confirm_password) {
                // Hash the new password (consider using bcrypt for better security)
                $hashed_password = md5($new_password); // md5 is insecure; consider using password_hash() in production
                
                // Update the password in the database and remove the reset token
                $update_sql = "UPDATE users SET password = '$hashed_password', reset_token = NULL WHERE reset_token = '$token'";
                if ($conn->query($update_sql) === TRUE) {
                    $_SESSION['message'] = "Your password has been successfully reset.";
                    echo "<script type='text/javascript'>alert('Your password has been successfully reset.');</script>";
                    header("Location: login.php"); // Redirect to login page
                    exit;
                } else {
                    $_SESSION['error'] = "Error updating password !";
                    echo "<script type='text/javascript'>alert('Error updating password.');</script>";
                }
                
            } else {
                $_SESSION['error'] = "Passwords do not match.";
            }
        }
    } else {
        $_SESSION['error'] = "Invalid or expired reset token.";
    }
} else {
    $_SESSION['error'] = "No token provided.";
    header("Location: forgot_password.php"); // Redirect to forgot password page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Explorer Center-Sri Lanka - Reset Password</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />

    <!-- Base URL -->
    <base href="/explorer-center/" />

    <!-- Favicon -->
    <link href="img/icon.webp" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
</head>

<body>
    <!-- Topbar Start -->
    <div id="topbar"></div>

    <script>
        fetch("components/topbar.html")
            .then((response) => response.text())
            .then((data) => {
                const tempDiv = document.createElement("div");
                tempDiv.innerHTML = data;
                const template = tempDiv.querySelector("template");
                document
                    .getElementById("topbar")
                    .appendChild(template.content.cloneNode(true));
            })
            .catch((error) => console.error("Error loading header:", error));
    </script>
    <!-- Topbar End -->

    <!-- Password Reset Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-3 pb-3">
                <h1>Reset Your Password</h1>
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px">Enter your new password</h6>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-form bg-white" style="padding: 30px">
                        <?php
                        if (isset($_SESSION['error'])) {
                            echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['message'])) {
                            echo '<p style="color: green;">' . $_SESSION['message'] . '</p>';
                            unset($_SESSION['message']);
                        }
                        ?>
                        <form action="php/reset_password.php?token=<?php echo $token; ?>" method="POST">
                            <div class="control-group">
                                <input type="password" class="form-control p-4" id="new_password" placeholder="New password" name="new_password" required="required" /><br>
                            </div>
                            <div class="control-group">
                                <input type="password" class="form-control p-4" id="confirm_password" placeholder="Confirm password" name="confirm_password" required="required" /><br>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary py-3 px-4" type="submit">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Password Reset End -->

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
