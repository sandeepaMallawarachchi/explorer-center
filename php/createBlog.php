<?php
// Include database connection
include('db.php');
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $author = $_POST['author'];
    $category = $_POST['category'];
    $topic = $_POST['topic'];
    $description = $_POST['description'];
    $date = $_POST['date'];

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

    // Insert into the blogs table
    $sql = "INSERT INTO blogs (author, category, topic, description, date, image_url) 
            VALUES ('$author', '$category', '$topic', '$description', '$date', '$imageUrl')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Blog successfully created!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
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
    <!-- create blog Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Blog</h6>
                <h1>Create a Blog</h1>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-form bg-white" style="padding: 30px;">
                        <div id="success"></div>
                        <form method="POST" action="php/createBlog.php" enctype="multipart/form-data">
                            <div class="control-group mb-2">
                                <input type="text" class="form-control p-4" id="author" name="author" placeholder="Your Name"
                                    required="required" data-validation-required-message="Please enter your name" />
                            </div>
                            <div class="control-group mb-2">
                                <input type="text" class="form-control p-4" id="category" name="category" placeholder="Enter Category"
                                    required="required" data-validation-required-message="Please enter category" />
                            </div>
                            <div class="control-group mb-2">
                                <input type="text" class="form-control p-4" id="topic" name="topic" placeholder="Topic"
                                    required="required" data-validation-required-message="Please enter a topic" />
                            </div>
                            <div class="control-group mb-2">
                                <textarea class="form-control py-3 px-4" rows="5" id="description" name="description" placeholder="Description"
                                    required="required" data-validation-required-message="Please enter description"></textarea>
                            </div>
                            <div class="control-group mb-2">
                                <input type="date" class="form-control p-4" id="date" name="date" placeholder="Date"
                                    required="required" data-validation-required-message="Please select the date" />
                            </div>
                            <div class="text-center mb-2">
                                <div class="img-upload-container" id="img-upload-container">
                                    <img src="img/upload.png" alt="Upload Image" class="img-upload-bg">
                                    <input type="file" id="img-upload-input" class="img-upload-input" accept="image/*" name="image" onchange="previewImage(event)">
                                    <div class="upload-text">Click or Drag to Upload</div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary py-3 px-4" type="submit">Create Blog</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- create blog End -->

    <!-- JavaScript Libraries -->
    <script src="js/upload.js"></script>

</body>

</html>