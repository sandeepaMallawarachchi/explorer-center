<?php
// Sample data for districts
$districts = [
    1 => [
        "name" => "Galle",
        "description" => "Galle is a beautiful district known for its historic Galle Fort and scenic beaches.",
        "image_url" => "img/calender7.jpg",
    ],
    2 => [
        "name" => "Matara",
        "description" => "Matara is a coastal district famous for its lighthouse and whale watching tours.",
        "image_url" => "img/calender3.jpg",
    ],
    3 => [
        "name" => "Hambantota",
        "description" => "Hambantota boasts rich wildlife sanctuaries, including Yala National Park.",
        "image_url" => "img/hambanthota.jpg",
    ],
];

// Get the district ID from the query parameter
$districtId = $_GET['id'] ?? null;
$district = $districts[$districtId] ?? null;

if ($district) {
    $imagePath = htmlspecialchars($district['image_url']);
    echo "
    <div class='text-center'>
        <img src='$imagePath' alt='{$district['name']} Image' class='img-fluid mb-3' style='max-height: 400px;'>
    </div>
    <h4 style='color: #3b82f6;'>" . htmlspecialchars($district['name']) . "</h4>
    <p><strong>Description:</strong> " . htmlspecialchars($district['description']) . "</p>";
} else {
    echo "<p>Invalid district ID.</p>";
}
