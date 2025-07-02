<?php
session_start();
include 'db.php'; // Include your database connection

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not authenticated
    exit;
}

// Fetch all records
$query = "SELECT * FROM about_us";
$result = $conn->query($query);

// Handle Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image_main = mysqli_real_escape_string($conn, $_POST['image_main']);
    $image_1 = mysqli_real_escape_string($conn, $_POST['image_1']);
    $image_2 = mysqli_real_escape_string($conn, $_POST['image_2']);
    $button_text = mysqli_real_escape_string($conn, $_POST['button_text']);

    $create_query = "INSERT INTO about_us (title, subtitle, description, image_main, image_1, image_2, button_text) 
                     VALUES ('$title', '$subtitle', '$description', '$image_main', '$image_1', '$image_2', '$button_text')";

    if ($conn->query($create_query)) {
        header('Location: adminAbout.php');
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $subtitle = mysqli_real_escape_string($conn, $_POST['subtitle']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image_main = mysqli_real_escape_string($conn, $_POST['image_main']);
    $image_1 = mysqli_real_escape_string($conn, $_POST['image_1']);
    $image_2 = mysqli_real_escape_string($conn, $_POST['image_2']);
    $button_text = mysqli_real_escape_string($conn, $_POST['button_text']);

    $update_query = "UPDATE about_us SET 
                     title = '$title', 
                     subtitle = '$subtitle', 
                     description = '$description', 
                     image_main = '$image_main', 
                     image_1 = '$image_1', 
                     image_2 = '$image_2', 
                     button_text = '$button_text' 
                     WHERE id = $id";

    if ($conn->query($update_query)) {
        header('Location: adminAbout.php');
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Sanitize the ID
    $id = intval($id);

    $delete_query = "DELETE FROM about_us WHERE id = $id";

    if ($conn->query($delete_query)) {
        header('Location: adminAbout.php');
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Explorer Center-Sri Lanka</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />

    <!-- Base URL -->
    <!-- <base href="/" /> -->

    <!-- Favicon -->
    <link href="img/icon.webp" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Font Awesome -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
        rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link
        href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
    <title>Admin About Us</title>

</head>

<body>


    <body>

        <!-- User Information -->
        <div>
            <a href="/adminDashboard.php">
                <img class="dashboardImg" src="img/dashboard.webp" alt="dashboard Icon">
            </a>
            <div class="user-info">
                <img src="img/user.webp" alt="User Icon">
                <div>
                    <h5>Hello, <?= htmlspecialchars($_SESSION['username']); ?></h5>
                    <a href="/logout.php" onclick="return confirmLogout()">Logout</a>
                </div>
            </div>
        </div>

        <div class="container py-5 mt-5">
            <h1 class="text-center mb-4">Manage About Us Section</h1>

            <form method="POST" class="mb-4 p-4 bg-white rounded shadow-sm">
                <h2 class="h4 mb-3">Create New Entry</h2>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" required>
                </div>
                <div class="mb-3">
                    <label for="subtitle" class="form-label">Subtitle</label>
                    <input type="text" name="subtitle" id="subtitle" class="form-control" placeholder="Subtitle">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" placeholder="Description" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="image_main" class="form-label">Main Image URL</label>
                    <input type="text" name="image_main" id="image_main" class="form-control" placeholder="Main Image URL">
                </div>
                <div class="mb-3">
                    <label for="image_1" class="form-label">Image 1 URL</label>
                    <input type="text" name="image_1" id="image_1" class="form-control" placeholder="Image 1 URL">
                </div>
                <div class="mb-3">
                    <label for="image_2" class="form-label">Image 2 URL</label>
                    <input type="text" name="image_2" id="image_2" class="form-control" placeholder="Image 2 URL">
                </div>
                <div class="mb-3">
                    <label for="button_text" class="form-label">Button Text</label>
                    <input type="text" name="button_text" id="button_text" class="form-control" placeholder="Button Text">
                </div>
                <button type="submit" name="create" class="btn btn-primary">Create</button>
            </form>
            <table class="table table-bordered table-striped bg-white shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Description</th>
                        <th>Main Image</th>
                        <th>Image 1</th>
                        <th>Image 2</th>
                        <th>Button Text</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">

                                <td><input type="text" name="title" class="form-control mb-2" value="<?= htmlspecialchars($row['title']) ?>" placeholder="Enter Title"></td>

                                <td><input type="text" name="subtitle" class="form-control mb-2" value="<?= htmlspecialchars($row['subtitle']) ?>" placeholder="Enter Subtitle"></td>

                                <td><textarea name="description" class="form-control mb-2" rows="3" placeholder="Enter Description"><?= htmlspecialchars($row['description']) ?></textarea></td>

                                <td>
                                    <img src="<?= htmlspecialchars($row['image_main']) ?>" alt="Main Image" class="img-thumbnail mb-2" style="width: 100px; height: auto;">
                                    <input type="text" name="image_main" class="form-control mb-2" value="<?= htmlspecialchars($row['image_main']) ?>" placeholder="Main Image URL">
                                </td>

                                <td>
                                    <img src="<?= htmlspecialchars($row['image_1']) ?>" alt="Image 1" class="img-thumbnail mb-2" style="width: 100px; height: auto;">
                                    <input type="text" name="image_1" class="form-control mb-2" value="<?= htmlspecialchars($row['image_1']) ?>" placeholder="Image 1 URL">
                                </td>

                                <td>
                                    <img src="<?= htmlspecialchars($row['image_2']) ?>" alt="Image 2" class="img-thumbnail mb-2" style="width: 100px; height: auto;">
                                    <input type="text" name="image_2" class="form-control mb-2" value="<?= htmlspecialchars($row['image_2']) ?>" placeholder="Image 2 URL">
                                </td>

                                <td><input type="text" name="button_text" class="form-control mb-2" value="<?= htmlspecialchars($row['button_text']) ?>" placeholder="Button Text"></td>

                                <td>
                                    <button type="submit" name="update" class="btn btn-success btn-sm mb-2">Update</button>
                                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </form>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>