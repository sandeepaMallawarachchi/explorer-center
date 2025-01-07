<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM blogs WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = !empty($row['image_url']) ? htmlspecialchars($row['image_url']) : 'img/placeholder.jpg';
        echo "
        <div class='text-center'>
            <img src='$imagePath' alt='Blog Image' class='img-fluid mb-3'>
            <p class='text-end'>" . date('F d, Y', strtotime($row['date'])) . "</p>
        </div>
        <h4 class='text-blue-500'>" . htmlspecialchars($row['topic']) . "</h4>
        <p><strong>Author:</strong> " . htmlspecialchars($row['author']) . "</p>
        <p><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</p>
        <p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
    } else {
        echo "<p>Blog not found.</p>";
    }
} else {
    echo "<p>Invalid blog ID.</p>";
}
