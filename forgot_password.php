<?php

session_start();
include 'db.php'; // Include your database connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $conn->query("UPDATE users SET reset_token = '$token', reset_expiry = '$expiry' WHERE email = '$email'");

        $reset_link = "http://localhost/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $reset_link";

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'sandeepamallawarachchi444@gmail.com';  // Your Gmail address
            $mail->Password = 'qkxx lmnw intx twru';  // App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('sandeepamallawarachchi444@gmail.com', 'Explorer Center');
            $mail->addAddress($email); // Add recipient email address

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            $mail->send();
            $_SESSION['success'] = "Password reset link sent to your email.";

            // Add JavaScript alert and redirect
            echo "<script type='text/javascript'>
                                window.location.href = 'login.php';

                    alert('Password reset link sent to your email.');
                  </script>";
            exit; // Ensure the rest of the code doesn't execute after the redirect
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed to send email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $_SESSION['error'] = "Email not found.";
    }

    // Redirect to the forgot password page after a short delay
    header("Location: forgot_password.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password - Explorer Center</title>
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

    <!-- Forgot Password Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-3 pb-3">
                <h1>Forgot Password</h1>
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px">
                    Reset your password
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
                        <form method="POST" action="/forgot_password.php">
                            <div class="control-group">
                                <input type="email" class="form-control p-4" id="email" placeholder="Your Email Address" name="email"
                                    required="required" data-validation-required-message="Please enter your email" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary py-3 px-4" type="submit">Send Reset Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Forgot Password End -->

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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>