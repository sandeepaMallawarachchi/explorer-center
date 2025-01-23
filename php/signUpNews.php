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
                window.location.href = '/explorer-center/php/allBlogs.php';
            </script>";
        } else {
            $checkStmt->close();

            $stmt = $conn->prepare("INSERT INTO signup_news (email) VALUES (?)");
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {

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
                                    <div><img src='{$news['image_url']}' alt='News Image'></div>
                                </div>
                            </body>
                        </html>
                    ";

                    sendEmail($email, $subject, $message);

                    updateSentNewsIds($conn, $email, $news['id']);
                }

                echo "<script>
                    alert('Thank you for signing up!');
                    window.location.href = '/explorer-center/php/allBlogs.php';
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
