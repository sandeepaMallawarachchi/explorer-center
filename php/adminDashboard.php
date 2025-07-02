<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<title>Explorer Center-Sri Lanka</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="Free HTML Templates" name="keywords">
<meta content="Free HTML Templates" name="description">

<!-- Base URL -->
<base href="/explorer-center/">

<!-- Favicon -->
<link href="img/icon.png" rel="icon">

<!-- Google Web Fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

<!-- Bootstrap CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

<!-- Libraries Stylesheet -->
<link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
<link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

<!-- Customized Bootstrap Stylesheet -->
<link href="css/style.css" rel="stylesheet">

<!-- confirmLogout js -->
<script>
    function confirmLogout() {
        return confirm("Are you sure you want to logout?");
    }
</script>


<style>
    .destination-item {
        height: 300px;
        /* Ensures all cards are of the same height */
        position: relative;
        overflow: hidden;
    }

    .destination-item img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }

    .destination-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Semi-transparent overlay */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .destination-item:hover .destination-overlay {
        opacity: 1;
        /* Show overlay on hover */
    }

    .destination-overlay h5,
    .destination-overlay span {
        margin: 0;
        text-align: center;
    }
</style>


</head>

<body>
    <!-- User Information -->
    <div class="head">
        <a href="php/adminDashboard.php">
            <img class="dashboardImg" src="img/dashboard.png" alt="dashboard Icon">
        </a>
        <div class="user-info">
            <img src="img/user.png" alt="User Icon">
            <div>
                <h5>Hello, <?= htmlspecialchars($_SESSION['username']); ?></h5>
                <a href="php/logout.php" onclick="return confirmLogout()">Logout</a>
            </div>
        </div>
    </div>

    <!-- Dashboard Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Admin</h6>
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="destination-item position-relative overflow-hidden mb-2" style="height: 300px;">
                        <img class="img-fluid" src="img/tour.jpg" alt="" style="object-fit: cover; width: 100%; height: 78%;">
                        <div class="destination-overlay text-white text-decoration-none">
                            <h5 class="text-white">Home Page</h5>
                            <span>Tours & About Us</span>
                            <div class="mt-3">
                                <a href="php/adminIndex.php" class="btn btn-primary btn-sm mx-2">Tours</a>
                                <a href="php/adminAbout.php" class="btn btn-secondary btn-sm mx-2">About Us</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-4 col-md-6 mb-4">
                    <div class="destination-item position-relative overflow-hidden mb-2" style="height: 300px;">
                        <img class="img-fluid" src="img/explo.jpg" alt="" style="object-fit: cover; width: 100%; height: 78%;">
                        <a class="destination-overlay text-white text-decoration-none" href="exploration.html">
                            <h5 class="text-white">Exploration</h5>
                            <span>Biodiverse wonders, thrilling safari adventures.</span>
                        </a>
                    </div>
                </div> -->
                <!-- <div class="col-lg-4 col-md-6 mb-4">

                    <div class="destination-item position-relative overflow-hidden mb-2" style="height: 300px;">
                        <img class="img-fluid" src="img/experience.jpg" alt="" style="object-fit: cover; width: 100%; height: 78%;">
                        <a class="destination-overlay text-white text-decoration-none" href="experience.html">
                            <h5 class="text-white">Experiences</h5>
                            <span>Rich heritage, ancient marvels preserved.</span>
                        </a>
                    </div>
                </div> -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="destination-item position-relative overflow-hidden mb-2" style="height: 300px;">
                        <img class="img-fluid" src="img/blog.jpg" alt="" style="object-fit: cover; width: 100%; height: 78%;">
                        <a class="destination-overlay text-white text-decoration-none" href="php/adminBlogs.php">
                            <h5 class="text-white">Blogs</h5>
                            <span>Grids & Details</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="destination-item position-relative overflow-hidden mb-2" style="height: 300px;">
                        <img class="img-fluid" src="img/review.jpg" alt="" style="object-fit: cover; width: 100%; height: 78%;">
                        <a class="destination-overlay text-white text-decoration-none" href="php/adminTestimonial.php">
                            <h5 class="text-white">Testamonials</h5>
                            <span>Customers and Travel guids</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">

                    <div class="destination-item position-relative overflow-hidden mb-2" style="height: 300px;">
                        <img class="img-fluid" src="img/reg.jpg" alt="" style="object-fit: cover; width: 100%; height: 78%;">
                        <a class="destination-overlay text-white text-decoration-none" href="php/registration.php">
                            <h5 class="text-white">ADMIN</h5>
                            <span>Registration</span>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="destination-item position-relative overflow-hidden mb-2" style="height: 300px;">
                        <img class="img-fluid" src="img/news.jpg" alt="" style="object-fit: cover; width: 100%; height: 78%;">
                        <a class="destination-overlay text-white text-decoration-none" href="php/adminNews.php">
                            <h5 class="text-white">News</h5>
                            <span>News letter</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Dashboard Start -->

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>