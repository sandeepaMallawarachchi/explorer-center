<?php
include('blog_helpers.php');
include 'sendNews.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include database connection
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

//fetch all blogs
// $sql = "SELECT * FROM blogs ORDER BY date DESC";
// $result = mysqli_query($conn, $sql);

// Fetch pagination details
$blogsPerPage = 6;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$totalBlogs = getTotalBlogsCount($conn);
$totalPages = getTotalPages($totalBlogs, $blogsPerPage);

// Fetch blogs
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
$result = getBlogs($conn, $searchKeyword, $categoryFilter, $page, $blogsPerPage);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blogId = $_POST['blogId'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $topic = $_POST['topic'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    $imageUrl = null; // Initialize image URL as null

    if (!empty($_FILES['image']['tmp_name'])) {
        $image = $_FILES['image']['tmp_name'];
        try {
            $uploadResult = (new UploadApi())->upload($image);
            $imageUrl = $uploadResult['secure_url'];
        } catch (Exception $e) {
            echo "<script>alert('Image upload failed: " . $e->getMessage() . "');</script>";
            exit;
        }
    }

    if ($blogId) {
        $sql = "UPDATE blogs SET 
                author = '$author', 
                category = '$category', 
                topic = '$topic', 
                description = '$description', 
                date = '$date'";

        if ($imageUrl !== null) {
            $sql .= ", image_url = '$imageUrl'";
        }

        $sql .= " WHERE id = $blogId";
    } else {
        // Insert new blog
        $sql = "INSERT INTO blogs (author, category, topic, description, date, image_url) 
                VALUES ('$author', '$category', '$topic', '$description', '$date', " . ($imageUrl !== null ? "'$imageUrl'" : "NULL") . ")";
    }

    if (mysqli_query($conn, $sql)) {

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

        echo "<script>alert('Blog successfully saved!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }

    // Redirect to prevent form resubmission
    header("Location: adminBlogs.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $blogId = intval($_GET['id']);
    $sql = "DELETE FROM blogs WHERE id = $blogId";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Blog deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }

    // Redirect back to the blog management page
    header('Location: adminBlogs.php');
    exit;
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
    <link href="img/icon.png" rel="icon">

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

    <!-- confirmLogout js -->
    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to logout?");
        }
    </script>

</head>

<body>

    <!-- User Information -->
    <div>
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

    <!-- Blog Management Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Blog</h6>
                <h1>Manage Blogs</h1>
            </div>
            <div class="text-center mb-3 pb-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#blogModal">Add New Blog</button>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="row pb-3">
                        <?php
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $imagePath = !empty($row['image_url']) ? htmlspecialchars($row['image_url']) : 'img/placeholder.jpg';
                                echo "
                                    <div class='col-md-6 mb-4 pb-2'>
                                        <div class='blog-item'>
                                            <div class='position-relative'>
                                                <img class='img-fluid w-100' src='$imagePath' alt='Blog Image'>
                                                <div class='blog-date'>
                                                    <h6 class='font-weight-bold mb-n1'>" . date("d", strtotime($row['date'])) . "</h6>
                                                    <small class='text-white text-uppercase'>" . date("M", strtotime($row['date'])) . "</small>
                                                </div>
                                            </div>
                                            <div class='bg-white p-4'>
                                                <div class='d-flex mb-2'>
                                                    <span class='text-primary text-uppercase text-decoration-none'>" . htmlspecialchars($row['author']) . "</span>
                                                    <span class='text-primary px-2'>|</span>
                                                    <span class='text-primary text-uppercase text-decoration-none'>" . htmlspecialchars($row['category']) . "</span>
                                                </div>
                                                <h5 class='m-0'>" . htmlspecialchars($row['topic']) . "</h5>
                                                <div class='mt-2'>
                                                    <button class='btn btn-sm btn-info' 
                                                        onclick='editBlog(" . json_encode($row) . ")'>Edit</button>
                                                    <button class='btn btn-sm btn-danger' 
                                                        onclick='deleteBlog(" . $row['id'] . ")'>Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                            }
                        } else {
                            echo "<p>No blogs found.</p>";
                        }
                        ?>
                    </div>
                    <!-- page navigation -->
                    <div class="col-12">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-lg justify-content-center bg-white mb-0" style="padding: 30px;">
                                <!-- Previous Button -->
                                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="php/adminBlogs.php?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>

                                <!-- Page Numbers -->
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                        <a class="page-link" href="php/adminBlogs.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Next Button -->
                                <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="php/adminBlogs.php?page=<?php echo $page + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Management End -->

    <!-- Blog Modal Start -->
    <div class="modal fade" id="blogModal" tabindex="-1" role="dialog" aria-labelledby="blogModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="blogModalLabel">Create/Update Blog</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="blogForm" method="POST" action="php/adminBlogs.php" enctype="multipart/form-data">
                        <input type="hidden" id="blogId" name="blogId">
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
                                <input type="file" id="image_url" class="img-upload-input" accept="image/*" name="image" onchange="previewImage(event)">
                                <div class="upload-text">Click or Drag to Upload</div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary py-3 px-4" type="submit">Save Blog</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Modal End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="js/upload.js"></script>
    <script src="js/blog-manage.js"></script>
</body>

</html>