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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Tours</title>
    <link rel="stylesheet" href="your-stylesheet.css">
</head>
<body>
    <div class="container-fluid py-5">
        <div class="container pt-5 pb-3">
            <div class="text-center mb-3 pb-3">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Tours</h6>
                <h1>Manage Tours</h1>
            </div>

            <!-- Create New Tour Form -->
            <form method="POST" style="margin-bottom: 20px; background: #fff; padding: 15px; border-radius: 5px;">
                <h2>Create New Tour</h2>
                <input type="text" name="title" placeholder="Title" required>
                <textarea name="description" placeholder="Description" rows="5" required></textarea>
                <input type="text" name="image_main" placeholder="Main Image URL" required>
                <button type="submit" name="create">Create</button>
            </form>

            <!-- Tours List -->
            <table>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Main Image</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <td><input type="text" name="title" value="<?= $row['title'] ?>"></td>
                            <td><textarea name="description" rows="3"><?= $row['description'] ?></textarea></td>
                            <td><input type="text" name="image_main" value="<?= $row['image_main'] ?>"></td>
                            <td>
                                <button type="submit" name="update">Update</button>
                                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </form>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
