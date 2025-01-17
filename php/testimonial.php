<?php
include('blog_helpers.php');

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    // Insert into the blogs table
    $sql = "INSERT INTO reviews (name, photo_url, review_date, review_text) 
            VALUES ('$name', '$imageUrl', '$review_date', '$review_text')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Review successfully created!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
    // Redirect to prevent form resubmission
    header("Location: testimonial.php");
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


    <!-- Booking Start -->
    <div class="container-fluid booking mt-5 pb-5">
        <div class="container pb-5">
            <div class="bg-light shadow" style="padding: 30px;">
                <div class="row align-items-center" style="min-height: 60px;">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3 mb-md-0">
                                    <select class="custom-select px-4" style="height: 47px;">
                                        <option selected>Destination</option>
                                        <option value="1">Destination 1</option>
                                        <option value="2">Destination 1</option>
                                        <option value="3">Destination 1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 mb-md-0">
                                    <div class="date" id="date1" data-target-input="nearest">
                                        <input type="text" class="form-control p-4 datetimepicker-input"
                                            placeholder="Depart Date" data-target="#date1"
                                            data-toggle="datetimepicker" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 mb-md-0">
                                    <div class="date" id="date2" data-target-input="nearest">
                                        <input type="text" class="form-control p-4 datetimepicker-input"
                                            placeholder="Return Date" data-target="#date2"
                                            data-toggle="datetimepicker" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 mb-md-0">
                                    <select class="custom-select px-4" style="height: 47px;">
                                        <option selected>Duration</option>
                                        <option value="1">Duration 1</option>
                                        <option value="2">Duration 1</option>
                                        <option value="3">Duration 1</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary btn-block" type="submit"
                            style="height: 47px; margin-top: -2px;">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Booking End -->


    <!-- Testimonial Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Testimonial</h6>
                <h1>What Say Our Clients</h1>
            </div>
            <div class="text-center mb-3 pb-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#reviewModal">Add New Review</button>
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


    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Add Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="reviewForm" method="POST" action="php/testimonial.php" enctype="multipart/form-data">
                        <div class="text-center mb-2">
                            <div class="img-upload-container" id="img-upload-container">
                                <img src="img/profilepic.jpg" alt="Upload Image" class="img-upload-bg">
                                <input type="file" id="image_url" class="img-upload-input" accept="image/*" name="image" onchange="previewImage(event)">
                                <div class="upload-text">Click or Drag to Upload</div>
                            </div>
                        </div>
                        <div class="control-group mb-2">
                            <input type="text" class="form-control p-4" id="name" name="name" placeholder="Your Name"
                                required="required" data-validation-required-message="Please enter your name" />
                        </div>
                        <div class="control-group mb-2">
                            <textarea type="text" class="form-control p-4" id="review_text" name="review_text" placeholder="Enter review text"
                                required="required" data-validation-required-message="Please enter review text"></textarea>
                        </div>
                        <div class="control-group mb-2">
                            <input type="text" class="form-control p-4" id="review_date" name="review_date"
                                value="<?php echo date('Y-m-d'); ?>" readonly placeholder="Current Date" />
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="saveReviewBtn">Save Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


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