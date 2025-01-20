<?php
session_start();
include('db.php');  // Database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if (isset($_POST['submit_news'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Fetch the latest 5 news items
    $sql = "SELECT * FROM news ORDER BY date DESC LIMIT 5";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Compose the email content
        $emailContent = "Here are the latest news:\n\n";
        while ($row = mysqli_fetch_assoc($result)) {
            $emailContent .= "Title: " . htmlspecialchars($row['News Title']) . "\n";
            $emailContent .= "Category: " . htmlspecialchars($row['category']) . "\n";
            $emailContent .= "Date: " . date("F j, Y", strtotime($row['date'])) . "\n";
            $emailContent .= "Link: http://localhost/explorer-center/php/allNews.php?id=" . $row['id'] . "\n\n";
        }

        // Set up PHPMailer to send the email
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@gmail.com';  // Your Gmail address
            $mail->Password = 'your_app_password';  // Gmail App password (if 2FA is enabled)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('hansaneet@gmail.com', 'Explorer Center');
            $mail->addAddress($email); // Add recipient email address

            // Content
            $mail->isHTML(false);  // Sending plain text email
            $mail->Subject = "Latest News from Explorer Center";
            $mail->Body    = $emailContent;

            // Send the email
            $mail->send();

            // After sending the email, notify the user
            $_SESSION['success'] = "The latest news has been sent to your email.";
            echo "<script>
                    alert('The latest news has been sent to your email.');
                    window.location.href = 'your-previous-page-url'; // Redirect to the previous page or wherever you'd like
                  </script>";
        } catch (Exception $e) {
            $_SESSION['error'] = "Failed to send email. Mailer Error: {$mail->ErrorInfo}";
            echo "<script>
                    alert('There was an issue sending the email. Please try again later.');
                    window.location.href = 'your-previous-page-url';
                  </script>";
        }
    } else {
        $_SESSION['error'] = "No news found to send.";
        echo "<script>
                alert('No news found to send.');
                window.location.href = 'your-previous-page-url';
              </script>";
    }
}
?>
