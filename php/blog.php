<?php
include('blog_helpers.php');

// Check if blog ID is valid
if (isset($_GET['id'])) {
    $blog_id = intval($_GET['id']);
    $sql = "SELECT * FROM blogs WHERE id = $blog_id";
    $result = mysqli_query($conn, $sql);
} else {
    echo "<p>Invalid blog ID.</p>";
    exit;
}

// Handle comment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $comment_date = date("Y-m-d H:i:s");

    $comment_sql = "INSERT INTO blog_comments (blog_id, name, email, message, date) 
                    VALUES ('$blog_id', '$name', '$email', '$message', '$comment_date')";

    if (mysqli_query($conn, $comment_sql)) {
        echo "<script>alert('Comment added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch comments for the blog
$comments_sql = "SELECT * FROM blog_comments WHERE blog_id = $blog_id ORDER BY date DESC";
$comments_result = mysqli_query($conn, $comments_sql);

// Fetch blogs
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch categories and recent posts
$categoryResult = getBlogCategories($conn);
$recentPostsResult = getRecentPosts($conn);
$tags = getBlogTags($conn);
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
    <div class="container-fluid page-header">
        <div class="container">
            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
                <h3 class="display-4 text-white text-uppercase">Blog Detail</h3>
                <div class="d-inline-flex text-white">
                    <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                    <p class="m-0 text-uppercase">Blog Detail</p>
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
                                        <input type="text" class="form-control p-4 datetimepicker-input" placeholder="Depart Date" data-target="#date1" data-toggle="datetimepicker" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3 mb-md-0">
                                    <div class="date" id="date2" data-target-input="nearest">
                                        <input type="text" class="form-control p-4 datetimepicker-input" placeholder="Return Date" data-target="#date2" data-toggle="datetimepicker" />
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
                        <button class="btn btn-primary btn-block" type="submit" style="height: 47px; margin-top: -2px;">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Booking End -->


    <!-- Blog Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Blog Detail Start -->
                    <div class="pb-3">
                        <?php
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $imagePath = !empty($row['image_url']) ? htmlspecialchars($row['image_url']) : 'img/placeholder.jpg';
                                echo "
                                <div class='blog-item'>
                                    <div class='position-relative'>
                                        <img class='img-fluid w-100' src='$imagePath' alt='Blog Image'>
                                        <div class='blog-date'>
                                            <h6 class='font-weight-bold mb-n1'>" . date("d", strtotime($row['date'])) . "</h6>
                                            <small class='text-white text-uppercase'>" . date("M", strtotime($row['date'])) . "</small>
                                        </div>
                                    </div>
                                        <div class='bg-white p-4' style='padding: 30px;'>
                                            <div class='d-flex mb-2'>
                                                <span class='text-primary text-uppercase text-decoration-none'>" . htmlspecialchars($row['author']) . "</span>
                                                <span class='text-primary px-2'>|</span>
                                                <a class='text-primary text-uppercase text-decoration-none' href='#'>" . htmlspecialchars($row['category']) . "</a>
                                            </div>
                                            <h2 class='mb-3'>" . htmlspecialchars($row['topic']) . "</h2>
                                            <p>" . htmlspecialchars($row['description']) . "</p>
                                        </div>
                                </div>";
                            }
                        }
                        ?>
                    </div>
                    <!-- Blog Detail End -->

                    <!-- Comment List Start -->
                    <div class="bg-white" style="padding: 30px; margin-bottom: 30px;">
                        <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Comments</h4>
                        <?php
                        if ($comments_result && mysqli_num_rows($comments_result) > 0) {
                            while ($comment = mysqli_fetch_assoc($comments_result)) {
                                echo "
                                <div class='media mb-4'>
                                    <img src='img/user.png' alt='Image' class='img-fluid mr-3 mt-1' style='width: 45px;'>
                                    <div class='media-body'>
                                        <h6>" . htmlspecialchars($comment['name']) . " <small><i>" . date("d M Y, h:i A", strtotime($comment['date'])) . "</i></small></h6>
                                        <p>" . htmlspecialchars($comment['message']) . "</p>
                                    </div>
                                </div>";
                            }
                        } else {
                            echo "<p>No comments yet. Be the first to leave a comment!</p>";
                        }
                        ?>
                    </div>
                    <!-- Comment List End -->

                    <!-- Comment Form Start -->
                    <div class="bg-white mb-3" style="padding: 30px;">
                        <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Leave a comment</h4>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="name">Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="message">Message *</label>
                                <textarea id="message" cols="30" rows="5" class="form-control" name="message" required></textarea>
                            </div>
                            <div class="form-group mb-0">
                                <input type="submit" value="Leave a comment" class="btn btn-primary font-weight-semi-bold py-2 px-3">
                            </div>
                        </form>
                    </div>
                    <!-- Comment Form End -->
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <!-- Author Bio -->
                    <!-- <div class="d-flex flex-column text-center bg-white mb-5 py-5 px-4">
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
                    </div> -->

                    <!-- Search Form -->
                    <div class="mb-5">
                        <div class="bg-white" style="padding: 30px;">
                            <form method="GET" action="php/allBlogs.php">
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

                    <!-- Category List -->
                    <div class="mb-5">
                        <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Categories</h4>
                        <div class="bg-white" style="padding: 30px;">
                            <ul class="list-inline m-0">
                                <?php if ($categoryResult && mysqli_num_rows($categoryResult) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($categoryResult)): ?>
                                        <?php
                                        $categoryName = htmlspecialchars($row['category']);
                                        $categoryCount = $row['count'];
                                        ?>
                                        <li class='mb-3 d-flex justify-content-between align-items-center'>
                                            <a class='text-dark' href='php/allBlogs.php?category=<?= urlencode($categoryName) ?>&search=<?= urlencode($searchKeyword) ?>'>
                                                <i class='fa fa-angle-right text-primary mr-2'></i><?= $categoryName ?>
                                            </a>
                                            <span class='badge badge-primary badge-pill'><?= $categoryCount ?></span>
                                        </li>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <p>No categories found.</p>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Recent Post -->
                    <div class="mb-5">
                        <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Recent Post</h4>
                        <?php if ($recentPostsResult && mysqli_num_rows($recentPostsResult) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($recentPostsResult)): ?>
                                <?php
                                $imagePath = !empty($row['image_url']) ? htmlspecialchars($row['image_url']) : 'img/placeholder.jpg';
                                $formattedDate = date("M d, Y", strtotime($row['date']));
                                ?>
                                <a class="d-flex align-items-center text-decoration-none bg-white mb-3" href="php/blog.php?id=<?= $row['id'] ?>">
                                    <img class="img-fluid" src="<?= $imagePath ?>" alt="Blog Image" style="width: 120px;">
                                    <div class="pl-3">
                                        <h6 class="m-1"><?= htmlspecialchars($row['topic']) ?></h6>
                                        <small><?= $formattedDate ?></small>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>No recent posts found.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Tag Cloud -->
                    <div class="mb-5">
                        <h4 class="text-uppercase mb-4" style="letter-spacing: 5px;">Tag Cloud</h4>
                        <div class="d-flex flex-wrap m-n1">
                            <?php if (!empty($tags)): ?>
                                <?php foreach ($tags as $tag): ?>
                                    <a href="php/allBlogs.php?search=<?= urlencode($tag) ?>" class="btn btn-light m-1"><?= ucfirst(htmlspecialchars($tag)) ?></a>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No tags available.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog End -->


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
</body>

</html>