<?php
include 'db.php';
// Fetch all records
$query = "SELECT * FROM tours";
$result = $conn->query($query);

// Handle Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image_main = mysqli_real_escape_string($conn, $_POST['image_main']);

    $create_query = "INSERT INTO tours (title, description, image_main) VALUES ('$title', '$description', '$image_main')";
    $conn->query($create_query);
    header('Location: adminIndex.php');
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image_main = mysqli_real_escape_string($conn, $_POST['image_main']);

    $update_query = "UPDATE tours SET title = '$title', description = '$description', image_main = '$image_main' WHERE id = $id";
    $conn->query($update_query);
    header('Location: adminIndex.php');
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM tours WHERE id = $id";
    $conn->query($delete_query);
    header('Location: adminIndex.php');
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
</head>

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
        .catch(error => console.error('Error loading topbar:', error));
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

<body style="background-image: url('https://images.unsplash.com/photo-1504309092620-4d0ec726efa4?q=80&w=1770&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">




    <div class="container py-5" style="background-color: rgba(255, 255, 255, 0.9); border-radius: 10px;">
        <div class="text-center mb-4">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Tours</h6>
            <h1>Manage Tours</h1>
        </div>

        <!-- Create New Tour Form -->
        <form method="POST" class="bg-white p-4 rounded shadow-sm mb-5">
            <h2>Create New Tour</h2>
            <div class="mb-3">
                <input type="text" name="title" class="form-control" placeholder="Title" required>
            </div>
            <div class="mb-3">
                <textarea name="description" class="form-control" placeholder="Description" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <input type="text" name="image_main" class="form-control" placeholder="Main Image URL" required>
            </div>
            <button type="submit" name="create" class="btn btn-primary">Create</button>
        </form>

        <!-- Tours List -->
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Main Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <td><input type="text" name="title" class="form-control" value="<?= $row['title'] ?>"></td>
                            <td><textarea name="description" class="form-control" rows="3"><?= $row['description'] ?></textarea></td>
                            <td>
    <img src="<?= $row['image_main'] ?>" alt="Image" style="width: 100px; height: auto; object-fit: cover; border-radius: 5px;">
    <input type="text" name="image_main" class="form-control mt-2" value="<?= $row['image_main'] ?>">
</td>
                            <td>
                                <button type="submit" name="update" class="btn btn-success">Update</button>
                                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</a>
                            </td>
                        </form>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

     <!-- Footer Start -->
 <div id="footer"></div>
 <script>
   fetch("components/footer.html")
     .then((response) => response.text())
     .then((data) => {
       const tempDiv = document.createElement("div");
       tempDiv.innerHTML = data;
       const template = tempDiv.querySelector("template");
       document
         .getElementById("footer")
         .appendChild(template.content.cloneNode(true));
     })
     .catch((error) => console.error("Error loading footer:", error));
 </script>
 <!-- Footer End -->
</body>
</html>
