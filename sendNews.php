<?php
include 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendEmail($email, $subject, $message)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sandeepamallawarachchi444@gmail.com';
        $mail->Password = 'qkxx lmnw intx twru';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('sandeepamallawarachchi444@gmail.com', 'Explorer Center');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function getUnsentNews($conn, $sentNewsIds)
{
    $newsQuery = "SELECT id, topic, category, content, image_url FROM news";
    if (!empty($sentNewsIds)) {
        $newsQuery .= " WHERE id NOT IN ($sentNewsIds)";
    }
    $result = $conn->query($newsQuery);
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
    return $sentNewsIds ?: '';
}

function updateSentNewsIds($conn, $email, $newSentIdsString)
{
    $currentSentIdsString = '';
    $stmt = $conn->prepare("SELECT sent_news_ids FROM signup_news WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($currentSentIdsString);
    $stmt->fetch();
    $stmt->close();

    $currentSentIdsArray = !empty($currentSentIdsString) ? explode(',', $currentSentIdsString) : [];
    $newSentIdsArray = explode(',', $newSentIdsString);
    $updatedSentIdsArray = array_unique(array_merge($currentSentIdsArray, $newSentIdsArray));
    $updatedSentIdsString = implode(',', $updatedSentIdsArray);

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
            $unsentNews = getUnsentNews($conn, $sentNewsIds);

            if (!empty($unsentNews)) {
                foreach ($unsentNews as $news) {
                    $subject = $news['topic'];
                    $message = "
                        <html>
                            <head>
                                <style>
                                    body { font-family: Arial, sans-serif; }
                                    .content { margin: 20px; }
                                    .header { font-size: 18px; font-weight: bold; margin-bottom: 10px; }
                                    .category { font-size: 14px; color: #555; margin-bottom: 20px; }
                                    img { max-width: 100%; height: auto; }
                                </style>
                            </head>
                            <body>
                                <div class='content'>
                                    <div class='header'>{$news['topic']}</div>
                                    <div class='category'>Category: {$news['category']}</div>
                                    <div>{$news['content']}</div>
                                    <div><img src='{$news['image_url']}' alt='Image'></div>
                                    <div>Read more: <a href='http://localhost/explorer-center/php/allNews.php'>click here</a></div>
                                </div>
                            </body>
                        </html>
                    ";

                    sendEmail($email, $subject, $message);
                    updateSentNewsIds($conn, $email, $news['id']);
                }
            }
        }
    } catch (Exception $e) {
        echo "<script>alert('An error occurred: " . $e->getMessage() . "');</script>";
    }
}
?>
