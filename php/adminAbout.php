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
    <title>Admin About Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #f8f9fa;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input, textarea {
            width: 95%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button, a {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px 0;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            text-align: center;
        }
        button:hover, a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<h1>Manage About Us Section</h1>
<form method="POST" style="margin-bottom: 20px; background: #fff; padding: 15px; border-radius: 5px;">
    <h2>Create New Entry</h2>
    <input type="text" name="title" placeholder="Title" required>
    <input type="text" name="subtitle" placeholder="Subtitle">
    <textarea name="description" placeholder="Description" rows="5" required></textarea>
    <input type="text" name="image_main" placeholder="Main Image URL">
    <input type="text" name="image_1" placeholder="Image 1 URL">
    <input type="text" name="image_2" placeholder="Image 2 URL">
    <input type="text" name="button_text" placeholder="Button Text">
    <button type="submit" name="create">Create</button>
</form>
<table>
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
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <td><input type="text" name="title" value="<?= $row['title'] ?>"></td>
                <td><input type="text" name="subtitle" value="<?= $row['subtitle'] ?>"></td>
                <td><textarea name="description" rows="3"><?= $row['description'] ?></textarea></td>
                <td><input type="text" name="image_main" value="<?= $row['image_main'] ?>"></td>
                <td><input type="text" name="image_1" value="<?= $row['image_1'] ?>"></td>
                <td><input type="text" name="image_2" value="<?= $row['image_2'] ?>"></td>
                <td><input type="text" name="button_text" value="<?= $row['button_text'] ?>"></td>
                <td>
                    <button type="submit" name="update">Update</button>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </form>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
