<?php
include 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendEmail($email, $subject, $message)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'sandeepamallawarachchi444@gmail.com';
        $mail->Password = 'qkxx lmnw intx twru';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587; // SMTP port

        //Recipients
        $mail->setFrom('sandeepamallawarachchi444@gmail.com', 'Explorer Center');
        $mail->addAddress($email); // Add the recipient's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function getUnsentBlogs($conn, $sentNewsIds)
{
    // If sentNewsIds is empty, make sure to select all news
    $blogQuery = "SELECT * FROM news";
    if (!empty($sentNewsIds)) {
        $blogQuery .= " WHERE id NOT IN ($sentNewsIds)";
    }
    $result = $conn->query($blogQuery);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getSentNewsIds($conn, $email)
{

    $sentNewsIds = '';

    $stmt = $conn->prepare("SELECT sent_news_ids FROM signup_news WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($sentNewsIds);
    $stmt->fetch();
    $stmt->close();

    // Return an empty string if no sent news ids exist
    return $sentNewsIds ?: '';
}

function updateSentNewsIds($conn, $email, $newSentIdsString)
{
    $currentSentIdsString = '';
    // Fetch current sent IDs
    $stmt = $conn->prepare("SELECT sent_news_ids FROM signup_news WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($currentSentIdsString);
    $stmt->fetch();
    $stmt->close();

    // Convert strings to arrays
    $currentSentIdsArray = !empty($currentSentIdsString) ? explode(',', $currentSentIdsString) : [];
    $newSentIdsArray = explode(',', $newSentIdsString);

    // Merge arrays and remove duplicates
    $updatedSentIdsArray = array_unique(array_merge($currentSentIdsArray, $newSentIdsArray));

    // Convert back to string
    $updatedSentIdsString = implode(',', $updatedSentIdsArray);

    // Update database
    $stmt = $conn->prepare("UPDATE signup_news SET sent_news_ids = ? WHERE email = ?");
    $stmt->bind_param("ss", $updatedSentIdsString, $email);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $emailsQuery = "SELECT email, sent_news_ids FROM signup_news";
        $emailsResult = $conn->query($emailsQuery);

        while ($row = $emailsResult->fetch_assoc()) {
            $email = $row['email'];
            $sentNewsIds = $row['sent_news_ids'];

            // Get unsent news
            $unsentNews = getUnsentBlogs($conn, $sentNewsIds);

            if (!empty($unsentNews)) {
                foreach ($unsentNews as $news) {
                    $subject = $news['topic'];
                    $message = $news['content'];

                    // Send email
                    sendEmail($email, $subject, $message);

                    // Update sent news IDs
                    updateSentNewsIds($conn, $email, $news['id']);
                }
            }
        }
    } catch (Exception $e) {
        // Error alert
        echo "<script>alert('An error occurred: " . $e->getMessage() . "');</script>";
    }
}

?>