<?php
include('news_helper.php');

// Fetch pagination details
$newsPerPage = 6;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$totalNews = getTotalNewsCount($conn);
$totalPages = getTotalPages($totalNews, $newsPerPage);

// Fetch news
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
$result = getNews($conn, $searchKeyword, $categoryFilter, $page, $newsPerPage);

// Fetch categories and recent news
$categoryResult = getNewsCategories($conn);
$recentNewsResult = getRecentNews($conn);
$tags = getNewsTags($conn);
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
    <div class="container-fluid news-page-header">
        <div class="container">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
                <h3 class="display-4 text-white text-uppercase">News Letter</h3>
                <div class="d-inline-flex text-white">
                    <p class="m-0 text-uppercase"><a class="text-white" href="php/index.php">Home</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                    <p class="m-0 text-uppercase">News Letter</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Get News Start -->
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
                                            <img class='img-fluid w-100' src='$imagePath' alt='News Image' style='max-height: 350px; object-fit: cover;'>
                                            <div class='blog-date'>
                                                <h6 class='font-weight-bold mb-n1'>" . date("d", strtotime($row['date'])) . "</h6>
                                                <small class='text-white text-uppercase'>" . date("M", strtotime($row['date'])) . "</small>
                                            </div>
                                        </div>
                                        <div class='bg-white p-4'>
                                            <div class='d-flex mb-2'>
                                                <a class='text-primary text-uppercase text-decoration-none' href='#'>" . htmlspecialchars($row['category']) . "</a>
                                            </div>
                                            <a class='h5 m-0 text-decoration-none' href='php/news.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['topic']) . "</a>
                                        </div>
                                    </div>
                                </div>";
                            }
                        } else {
                            echo "<p>No news found.</p>";
                        }
                        ?>
                    </div>

                    <!-- Page navigation -->
                    <div class="col-12">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-lg justify-content-center bg-white mb-0" style="padding: 30px;">
                                <!-- Previous Button -->
                                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="php/allnews.php?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>

                                <!-- Page Numbers -->
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                        <a class="page-link" href="php/allnews.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Next Button -->
                                <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="php/allnews.php?page=<?php echo $page + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">

                    <!-- Search Form -->
                    <div class="mb-5">
                        <div class="bg-white" style="padding: 30px;">
                            <form method="GET" action="php/allNews.php">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control p-4" id="searchInput" placeholder="Keyword" value="<?php echo htmlspecialchars($searchKeyword); ?>">
                                    <div class="input-group-append">
                                        <button type="submit" class="input-group-text bg-primary border-primary text-white" id="searchBtn">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Get News End -->

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
</body>

</html>