<?php
include 'db.php'; // Include your database connection

// Fetch all records
$query = "SELECT * FROM about_us";
$result = $conn->query($query);

// Handle Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $description = $_POST['description'];
    $image_main = $_POST['image_main'];
    $image_1 = $_POST['image_1'];
    $image_2 = $_POST['image_2'];
    $button_text = $_POST['button_text'];

    $create_query = "INSERT INTO about_us (title, subtitle, description, image_main, image_1, image_2, button_text) VALUES ('$title', '$subtitle', '$description', '$image_main', '$image_1', '$image_2', '$button_text')";
    $conn->query($create_query);
    header('Location: adminAbout.php');
}

// Handle Update
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
    $delete_query = "DELETE FROM about_us WHERE id = $id";
    $conn->query($delete_query);
    header('Location: adminAbout.php');
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
    <base href="/explorer-center/" />

    <!-- Favicon -->
    <link href="img/icon.png" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link
      href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
    <title>Admin About Us</title>
    
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

<body style="background-image: url('https://images.unsplash.com/photo-1736153515676-aa499c1dc936?q=80&w=1770&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center; background-repeat: no-repeat;" class="bg-light">
    <div class="container py-5">
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
                            <td><input type="text" name="title" class="form-control" value="<?= $row['title'] ?>"></td>
                            <td><input type="text" name="subtitle" class="form-control" value="<?= $row['subtitle'] ?>"></td>
                            <td><textarea name="description" class="form-control" rows="3"><?= $row['description'] ?></textarea></td>
                            <td>
                                <img src="<?= $row['image_main'] ?>" alt="Main Image" class="img-thumbnail mb-2" style="width: 100px;">
                                <input type="text" name="image_main" class="form-control" value="<?= $row['image_main'] ?>">
                            </td>
                            <td>
                                <img src="<?= $row['image_1'] ?>" alt="Image 1" class="img-thumbnail mb-2" style="width: 100px;">
                                <input type="text" name="image_1" class="form-control" value="<?= $row['image_1'] ?>">
                            </td>
                            <td>
                                <img src="<?= $row['image_2'] ?>" alt="Image 2" class="img-thumbnail mb-2" style="width: 100px;">
                                <input type="text" name="image_2" class="form-control" value="<?= $row['image_2'] ?>">
                            </td>
                            <td><input type="text" name="button_text" class="form-control" value="<?= $row['button_text'] ?>"></td>
                            <td>
                                <button type="submit" name="update" class="btn btn-success btn-sm">Update</button>
                                <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </form>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
