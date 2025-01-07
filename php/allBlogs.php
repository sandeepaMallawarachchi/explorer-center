<?php
include('db.php');

// Fetch the search term if any
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch the selected category from the URL if any
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';

// Prepare SQL query based on search and category filter
if ($searchKeyword && $categoryFilter) {
    $searchKeyword = mysqli_real_escape_string($conn, $searchKeyword);
    $categoryFilter = mysqli_real_escape_string($conn, $categoryFilter);
    $sql = "SELECT * FROM blogs WHERE (LOWER(topic) LIKE '%$searchKeyword%' OR LOWER(author) LIKE '%$searchKeyword%' OR LOWER(category) LIKE '%$searchKeyword%' OR LOWER(description) LIKE '%$searchKeyword%') AND category = '$categoryFilter'";
} elseif ($searchKeyword) {
    $searchKeyword = mysqli_real_escape_string($conn, $searchKeyword);
    $sql = "SELECT * FROM blogs WHERE LOWER(topic) LIKE '%$searchKeyword%' OR LOWER(author) LIKE '%$searchKeyword%' OR LOWER(category) LIKE '%$searchKeyword%' OR LOWER(description) LIKE '%$searchKeyword%'";
} elseif ($categoryFilter) {
    $categoryFilter = mysqli_real_escape_string($conn, $categoryFilter);
    $sql = "SELECT * FROM blogs WHERE category = '$categoryFilter'";
} else {
    $sql = "SELECT * FROM blogs";
}

$result = mysqli_query($conn, $sql);

// Fetch categories and blog counts
$sql = "SELECT category, COUNT(*) as count FROM blogs GROUP BY category";
$categoryResult = mysqli_query($conn, $sql);
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
    <div class="container-fluid blog-page-header">
        <div class="container">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
                <h3 class="display-4 text-white text-uppercase">Blog</h3>
                <div class="d-inline-flex text-white">
                    <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                    <p class="m-0 text-uppercase">Blog</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- get blog Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">
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
                                                <a class='text-primary text-uppercase text-decoration-none' href='#'>" . htmlspecialchars($row['category']) . "</a>
                                            </div>
                                            <a class='h5 m-0 text-decoration-none' href='#' data-toggle='modal' data-target='#blogModal' data-id='" . $row['id'] . "'>" . htmlspecialchars($row['topic']) . "</a>
                                        </div>
                                    </div>
                                </div>";
                            }
                        } else {
                            echo "<p>No blogs found.</p>";
                        }
                        ?>
                    </div>
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <!-- Author Bio -->
                    <div class="d-flex flex-column text-center bg-white mb-5 py-5 px-4">
                        <img src="img/user.jpg" class="img-fluid mx-auto mb-3" style="width: 100px;">
                        <h3 class="text-primary mb-3">John Doe</h3>
                        <p>Conset elitr erat vero dolor ipsum et diam, eos dolor lorem, ipsum sit no ut est ipsum erat kasd amet elitr</p>
                        <div class="d-flex justify-content-center">
                            <a class="text-primary px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-primary px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-primary px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-primary px-2" href="">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a class="text-primary px-2" href="">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <div class="mb-5">
                        <div class="bg-white" style="padding: 30px;">
                            <div class="input-group">
                                <input type="text" class="form-control p-4" id="searchInput" placeholder="Keyword" value="<?php echo htmlspecialchars($searchKeyword); ?>">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-primary border-primary text-white" id="searchBtn"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category List -->
                    <div class="mb-5">
                        <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Categories</h4>
                        <div class="bg-white" style="padding: 30px;">
                            <ul class="list-inline m-0">
                                <?php
                                if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                                    while ($row = mysqli_fetch_assoc($categoryResult)) {
                                        $categoryName = htmlspecialchars($row['category']);
                                        $categoryCount = $row['count'];
                                        // Add category link with a query parameter
                                        echo "
                                        <li class='mb-3 d-flex justify-content-between align-items-center'>
                                            <a class='text-dark' href='php/allBlogs.php?category=$categoryName&search=$searchKeyword'><i class='fa fa-angle-right text-primary mr-2'></i>$categoryName</a>
                                            <span class='badge badge-primary badge-pill'>$categoryCount</span>
                                        </li>";
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Recent Post -->
                    <div class="mb-5">
                        <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Recent Post</h4>
                        <a class="d-flex align-items-center text-decoration-none bg-white mb-3" href="">
                            <img class="img-fluid" src="img/blog-100x100.jpg" alt="">
                            <div class="pl-3">
                                <h6 class="m-1">Diam lorem dolore justo eirmod lorem dolore</h6>
                                <small>Jan 01, 2050</small>
                            </div>
                        </a>
                        <a class="d-flex align-items-center text-decoration-none bg-white mb-3" href="">
                            <img class="img-fluid" src="img/blog-100x100.jpg" alt="">
                            <div class="pl-3">
                                <h6 class="m-1">Diam lorem dolore justo eirmod lorem dolore</h6>
                                <small>Jan 01, 2050</small>
                            </div>
                        </a>
                        <a class="d-flex align-items-center text-decoration-none bg-white mb-3" href="">
                            <img class="img-fluid" src="img/blog-100x100.jpg" alt="">
                            <div class="pl-3">
                                <h6 class="m-1">Diam lorem dolore justo eirmod lorem dolore</h6>
                                <small>Jan 01, 2050</small>
                            </div>
                        </a>
                    </div>

                    <!-- Tag Cloud -->
                    <div class="mb-5">
                        <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Tag Cloud</h4>
                        <div class="d-flex flex-wrap m-n1">
                            <a href="" class="btn btn-light m-1">Design</a>
                            <a href="" class="btn btn-light m-1">Development</a>
                            <a href="" class="btn btn-light m-1">Marketing</a>
                            <a href="" class="btn btn-light m-1">SEO</a>
                            <a href="" class="btn btn-light m-1">Writing</a>
                            <a href="" class="btn btn-light m-1">Consulting</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- get blog End -->

    <!-- Modal Structure -->
    <div class="modal fade" id="blogModal" tabindex="-1" role="dialog" aria-labelledby="blogModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="blogModalLabel">Blog Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Blog details will be loaded here -->
                    <div id="modalContent">
                        <p>Loading...</p>
                    </div>
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

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script src="js/blog-modal.js"></script>
    <script src="js/search-blog.js"></script>
</body>

</html>