<?php
session_start();
include 'db.php'; // Include your database connection

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not authenticated
    exit;
}


$sql = "SELECT * FROM reviews";
$result = mysqli_query($conn, $sql);

require '../vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

// Configure Cloudinary
Configuration::instance([
    'cloud' => [
        'cloud_name' => 'dfssg1dxr',
        'api_key' => '521587614913943',
        'api_secret' => 'VRClcvauG_qw2tKOn16RIpgzp3Q'
    ],
    'url' => [
        'secure' => true
    ]
]);

// Handle deletion of a review
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_review'])) {
    $reviewId = $_POST['review_id'];
    $deleteSql = "DELETE FROM reviews WHERE id = ?";
    $stmt = mysqli_prepare($conn, $deleteSql);
    mysqli_stmt_bind_param($stmt, 'i', $reviewId);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Review deleted successfully');</script>";
    } else {
        echo "<script>alert('Failed to delete review');</script>";
    }
    mysqli_stmt_close($stmt);
}

// Handle new review submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_review'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $review_date = $_POST['review_date'];
    $review_text = $_POST['review_text'];

    // Handle image upload to Cloudinary
    if (!empty($_FILES['image']['tmp_name'])) {
        $image = $_FILES['image']['tmp_name'];

        try {
            $uploadResult = (new UploadApi())->upload($image);
            $imageUrl = $uploadResult['secure_url'];
        } catch (Exception $e) {
            echo "<script>alert('Image upload failed: " . $e->getMessage() . "');</script>";
            exit;
        }
    } else {
        $imageUrl = null;
    }

    // Insert review into database
    $insertSql = "INSERT INTO reviews (name, review_date, review_text, photo_url) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertSql);
    mysqli_stmt_bind_param($stmt, 'ssss', $name, $review_date, $review_text, $imageUrl);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Review added successfully');</script>";
    } else {
        echo "<script>alert('Failed to add review');</script>";
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Explorer Center-Sri Lanka</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Base URL -->
    <base href="/explorer-center/">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/upload.css" rel="stylesheet">

</head>

<body>
    <!-- Topbar Start -->
    <div id="topbar"></div>

    <script>
        fetch('components/topbar.html')
            .then(response => response.text())
            .then(data => {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data;
                const template = tempDiv.querySelector('template');
                document.getElementById('topbar').appendChild(template.content.cloneNode(true));
            })
            .catch(error => console.error('Error loading header:', error));
    </script>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div id="header"></div>
    <script>
        fetch('components/header.html')
            .then(response => response.text())
            .then(data => {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data;
                const template = tempDiv.querySelector('template');
                document.getElementById('header').appendChild(template.content.cloneNode(true));
            })
            .catch(error => console.error('Error loading header:', error));
    </script>
    <!-- Navbar End -->


    <!-- Header Start -->
    <div class="container-fluid page-header">
        <div class="container">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
                <h3 class="display-4 text-white text-uppercase">Testimonial</h3>
                <div class="d-inline-flex text-white">
                    <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                    <p class="m-0 text-uppercase">Testimonial</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->





    <!-- Testimonial Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Testimonial</h6>
                <h1>What Say Our Clients</h1>
            </div>
           
            <div class="owl-carousel testimonial-carousel">
    <?php
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $imagePath = !empty($row['photo_url']) ? htmlspecialchars($row['photo_url']) : 'img/placeholder.jpg';
            echo "
            <div class='text-center pb-4'>
                <img class='img-fluid mx-auto' src='$imagePath' style='width: 100px; height: 100px;'>
                <div class='testimonial-text bg-white p-4 mt-n5'>
                    <p class='mt-5'>" . htmlspecialchars($row['review_text']) . "</p>
                    <h5 class='text-truncate'>" . htmlspecialchars($row['name']) . "</h5>
                    <span>" . date("d F Y", strtotime($row['review_date'])) . "</span>
                    <form method='POST' onsubmit='return confirm(\"Are you sure you want to delete this review?\");'>
                        <input type='hidden' name='review_id' value='" . $row['id'] . "'>
                        <button type='submit' name='delete_review' class='btn btn-danger mt-3'>Delete</button>
                    </form>
                </div>
            </div>";
        }
    } else {
        echo "<p>No reviews found.</p>";
    }
    ?>
</div>


        </div>
    </div>
    <!-- Testimonial End -->


 

    <!-- Footer Start -->
    <div id="footer"></div>

    <script>
        fetch('components/footer.html')
            .then(response => response.text())
            .then(data => {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data;
                const template = tempDiv.querySelector('template');
                document.getElementById('footer').appendChild(template.content.cloneNode(true));
            })
            .catch(error => console.error('Error loading footer:', error));
    </script>
    <!-- Footer End -->


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
    <script src="js/upload.js"></script>
</body>

</html>