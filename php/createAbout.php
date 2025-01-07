<?php
// Include database connection
include('db.php');
require '../vendor/autoload.php';  // Include Composer autoload

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

// Handle Insert (Create) Action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $topic = $_POST['topic'];
    $details = $_POST['details'];

    // Handle image upload to Cloudinary (multiple images)
    $imageUrls = [];
    if (!empty($_FILES['image']['tmp_name'][0])) {
        foreach ($_FILES['image']['tmp_name'] as $key => $image) {
            try {
                $uploadResult = (new UploadApi())->upload($image);
                $imageUrls[] = $uploadResult['secure_url'];
            } catch (Exception $e) {
                echo "<script>alert('Image upload failed: " . $e->getMessage() . "');</script>";
                exit;
            }
        }
    }
    $imageUrls = implode(',', $imageUrls);  // Store all image URLs as a comma-separated string

    $sql = "INSERT INTO about (topic, details, image_url) VALUES ('$topic', '$details', '$imageUrls')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('About topic successfully created!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Handle Update Action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $aboutId = $_POST['aboutId'];
    $topic = $_POST['topic'];
    $details = $_POST['details'];

    // Ensure aboutId, topic, and details are not empty
    if (!empty($aboutId) && !empty($topic) && !empty($details)) {
        // Handle image upload to Cloudinary if a new image is selected
        if (!empty($_FILES['image']['tmp_name'][0])) {
            $imageUrls = [];
            foreach ($_FILES['image']['tmp_name'] as $key => $image) {
                try {
                    $uploadResult = (new UploadApi())->upload($image);
                    $imageUrls[] = $uploadResult['secure_url'];
                } catch (Exception $e) {
                    echo "<script>alert('Image upload failed: " . $e->getMessage() . "');</script>";
                    exit;
                }
            }
            $imageUrls = implode(',', $imageUrls);  // Store all image URLs as a comma-separated string
        } else {
            // If no new images are selected, retain the existing image URL
            $imageUrls = isset($_POST['existing_image_url']) ? $_POST['existing_image_url'] : null;
        }

        $sql = "UPDATE about SET topic='$topic', details='$details', image_url='$imageUrls' WHERE aboutId=$aboutId";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('About topic successfully updated!');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Please provide valid topic and details for the update.');</script>";
    }
}

// Handle Delete Action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $aboutId = $_POST['aboutId'];

    if (!empty($aboutId)) {
        $sql = "DELETE FROM about WHERE aboutId=$aboutId";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('About topic successfully deleted!');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid ID for deletion.');</script>";
    }
}

// Fetch all About topics
$sql = "SELECT * FROM about";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Explorer Center-Sri Lanka</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <base href="/explorer-center/">

    <link href="img/favicon.ico" rel="icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 1200px;
        }

        .about-text {
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .control-group {
            margin-bottom: 15px;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn {
            border-radius: 5px;
        }

        .contact-form {
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .text-primary {
            color: #007bff !important;
        }

        h1, h6 {
            font-family: 'Arial', sans-serif;
        }

        .about-text img {
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .about-text img:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<!-- Create About Section -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">About</h6>
            <h1>Create About Entry</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form bg-white p-4">
                    <form method="POST" action="php/createAbout.php" enctype="multipart/form-data">
                        <div class="control-group">
                            <input type="text" class="form-control p-4" id="topic" name="topic" placeholder="Enter Topic"
                                required="required" />
                        </div>
                        <div class="control-group">
                            <textarea class="form-control py-3 px-4" rows="5" id="details" name="details" placeholder="Details"
                                required="required"></textarea>
                        </div>
                        <div class="control-group mb-3">
                            <!-- Allow multiple images -->
                            <input type="file" id="image" name="image[]" accept="image/*" class="form-control p-4" multiple />
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary py-3 px-4" type="submit" name="create">Create About</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- List All About Topics -->
<div class="container mt-4">
    <h3 class="text-center">All About Topics</h3>
    <div class="row">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $imageUrls = explode(',', $row['image_url']);  // Get individual image URLs
            echo "
            <div class='col-lg-6 mb-4'>
                <div class='about-text bg-white p-4'>
                    <h6 class='text-primary text-uppercase' style='letter-spacing: 5px'>{$row['topic']}</h6>
                    <h1 class='mb-3'>{$row['topic']}</h1>
                    <p>{$row['details']}</p>
                    <div class='row mb-4'>
                        <div class='col-12'>";
                        foreach ($imageUrls as $imageUrl) {
                            echo "<img class='img-fluid' src='$imageUrl' alt='Image' style='width: 100%; height: auto; object-fit: cover;'>";
                        }
            echo "</div>
                    </div>
                    <form action='php/createAbout.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='aboutId' value='{$row['aboutId']}'>
                        <input type='text' class='form-control' name='topic' value='{$row['topic']}' required>
                        <textarea class='form-control' name='details' required>{$row['details']}</textarea>
                        <input type='hidden' name='existing_image_url' value='{$row['image_url']}'>
                        <input type='file' class='form-control' name='image[]' multiple>
                        <button type='submit' name='update' class='btn btn-warning btn-sm'>Update</button>
                    </form>
                    <form action='php/createAbout.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='aboutId' value='{$row['aboutId']}'>
                        <button type='submit' name='delete' class='btn btn-danger btn-sm'>Delete</button>
                    </form>
                </div>
            </div>";
        }
        ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
