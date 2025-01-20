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

                $sentNewsIds = ''; // Initially, the new subscriber hasn't received any news
                $unsentBlogs = getUnsentBlogs($conn, $sentNewsIds);

                if (!empty($unsentBlogs)) {
                    foreach ($unsentBlogs as $blog) {
                        $subject = $blog['topic'];
                        $message = $blog['description'];

                        sendEmail($email, $subject, $message);

                        // Update sent_news_ids for this user
                        updateSentNewsIds($conn, $email, $blog['id']);
                    }
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
