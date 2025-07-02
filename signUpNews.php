<?php
include 'db.php';
include 'sendNews.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $checkStmt = $conn->prepare("SELECT id FROM signup_news WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            echo "<script>
                alert('You are already signed up!');
                window.location.href = '//allNews.php';
            </script>";
        } else {
            $checkStmt->close();

            $stmt = $conn->prepare("INSERT INTO signup_news (email) VALUES (?)");
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {

                $newsQuery = "SELECT * FROM news";
                $newsResult = $conn->query($newsQuery);

                while ($news = $newsResult->fetch_assoc()) {
                    $topic = $news['topic'];
                    $category = $news['category'];
                    $content = $news['content'];
                    $date = $news['date'];
                    $imageUrl = $news['image_url'];

                    $subject = "Latest News Update: $topic";
                    $message = "
                        <html>
                            <head>
                                <style>
                                    body { font-family: Arial, sans-serif; line-height: 1.6; }
                                    .container { margin: 20px; padding: 10px; }
                                    .header { font-size: 22px; font-weight: bold; color: #333; }
                                    .category { font-size: 14px; color: #777; margin-bottom: 10px; }
                                    img { max-width: 100%; height: auto; margin-top: 15px; }
                                </style>
                            </head>
                            <body>
                                <div class='container'>
                                    <div class='header'>$topic</div>
                                    <div class='category'>Category: $category | Date: $date</div>
                                    <div>$content</div>";

                    if (!empty($imageUrl)) {
                        $message .= "<div><img src='$imageUrl' alt='News Image'></div>";
                    }

                    $message .= "
                                <div>Read more: <a href='http://localhost//allNews.php'>click here</a></div>
                                </div>
                            </body>
                        </html>
                    ";

                    sendEmail($email, $subject, $message);
                    updateSentNewsIds($conn, $email, $news['id']);
                }

                echo "<script>
                    alert('Thank you for signing up! All news has been sent to your email.');
                    window.location.href = '//allNews.php';
                </script>";
            } else {
                echo "<script>
                    alert('An error occurred. Please try again.');
                    window.history.back();
                </script>";
            }

            $stmt->close();
        }
    } else {
        echo "<script>
            alert('Invalid email format. Please try again.');
            window.history.back();
        </script>";
    }
}

$conn->close();
