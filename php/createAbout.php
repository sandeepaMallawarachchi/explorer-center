<?php
// Include database connection
include('db.php');

// Handle Insert (Create) Action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $topic = $_POST['topic'];
    $details = $_POST['details'];

    $sql = "INSERT INTO about (topic, details) VALUES ('$topic', '$details')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('About topic successfully created!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// Handle Update Action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $aboutId = $_POST['aboutId'];
    $topic = $_POST['topic'];
    $details = $_POST['details'];

    // Ensure aboutId, topic, and details are not empty
    if (!empty($aboutId) && !empty($topic) && !empty($details)) {
        $sql = "UPDATE about SET topic='$topic', details='$details' WHERE aboutId=$aboutId";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('About topic successfully updated!');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Please provide valid topic and details for the update.');</script>";
    }
}

// Handle Delete Action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $aboutId = $_POST['aboutId'];

    if (!empty($aboutId)) {
        $sql = "DELETE FROM about WHERE aboutId=$aboutId";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('About topic successfully deleted!');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid ID for deletion.');</script>";
    }
}

// Fetch all About topics
$sql = "SELECT * FROM about";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Explorer Center-Sri Lanka</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <base href="/explorer-center/">

    <link href="img/favicon.ico" rel="icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Create About Section -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mb-3 pb-3">
            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">About</h6>
            <h1>Create About Entry</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form bg-white" style="padding: 30px;">
                    <form method="POST" action="php/createAbout.php">
                        <div class="control-group">
                            <input type="text" class="form-control p-4" id="topic" name="topic" placeholder="Enter Topic"
                                required="required" data-validation-required-message="Please enter a topic" />
                        </div>
                        <div class="control-group">
                            <textarea class="form-control py-3 px-4" rows="5" id="details" name="details" placeholder="Details"
                                required="required" data-validation-required-message="Please enter details"></textarea>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary py-3 px-4" type="submit" name="create">Create About</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- List All About Topics -->
<div class="container mt-4">
    <h3 class="text-center">All About Topics</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Topic</th>
                <th>Details</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['aboutId']}</td>
                    <td>{$row['topic']}</td>
                    <td>{$row['details']}</td>
                    <td>
                        <form action='php/createAbout.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='aboutId' value='{$row['aboutId']}'>
                            <input type='text' class='form-control' name='topic' value='{$row['topic']}' required>
                            <textarea class='form-control' name='details' required>{$row['details']}</textarea>
                            <button type='submit' name='update' class='btn btn-warning btn-sm'>Update</button>
                        </form>
                        <form action='php/createAbout.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='aboutId' value='{$row['aboutId']}'>
                            <button type='submit' name='delete' class='btn btn-danger btn-sm'>Delete</button>
                        </form>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
