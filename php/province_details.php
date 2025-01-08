<?php
$province = isset($_GET['province']) ? htmlspecialchars($_GET['province']) : 'Unknown Province';

// Define details for each province
$provinces = [
    "province1" => [
        "name" => "Southern Province",
        "image" => "img/destination-1.jpg",
        "description" => "Southern Province is known for its beautiful beaches, historical landmarks like Galle Fort, and rich biodiversity. Enjoy whale watching in Mirissa, visit the iconic stilt fishermen, and explore the dense rainforest of Sinharaja."
    ],
    "province2" => [
        "name" => "Western Province",
        "image" => "img/destination-2.jpg",
        "description" => "Western Province is the economic hub of Sri Lanka, home to Colombo, vibrant nightlife, and modern infrastructure. Discover the bustling Pettah Market, iconic Colombo Lotus Tower, and sandy beaches like Negombo."
    ],
    "province3" => [
        "name" => "Central Province",
        "image" => "img/destination-3.jpg",
        "description" => "Central Province is famous for tea plantations, breathtaking landscapes, and ancient cities like Kandy. Visit the Sacred Tooth Relic Temple, explore Horton Plains, and climb the majestic Sigiriya Rock Fortress."
    ],
    "province4" => [
        "name" => "Eastern Province",
        "image" => "img/destination-4.jpg",
        "description" => "Eastern Province features pristine beaches, diverse culture, and ancient temples. Relax at Arugam Bay, visit the serene Kumana National Park, and enjoy the cultural richness of Batticaloa and Trincomalee."
    ],
    "province5" => [
        "name" => "Northern Province",
        "image" => "img/destination-5.jpg",
        "description" => "Northern Province boasts unique Tamil culture, ancient ruins, and stunning lagoons. Explore the Jaffna Peninsula, visit the sacred Nallur Kovil, and relax at Casuarina Beach."
    ],
    "province6" => [
        "name" => "North Western Province",
        "image" => "img/destination-6.jpg",
        "description" => "North Western Province offers ancient cities and serene landscapes. Discover Wilpattu National Park, explore Yapahuwa rock fortress, and visit the historic Panduwasnuwara ruins."
    ],
    "province7" => [
        "name" => "North Central Province",
        "image" => "img/destination-7.jpg",
        "description" => "North Central Province is the cultural heart of Sri Lanka, home to ancient cities. Visit the ruins of Anuradhapura and Polonnaruwa, and explore the Minneriya National Park, known for the 'Gathering' of elephants."
    ],
    "province8" => [
        "name" => "Uva Province",
        "image" => "img/destination-8.jpg",
        "description" => "Uva Province is renowned for its scenic beauty and cool climate. Discover Ella's Nine Arches Bridge, trek Little Adam's Peak, and visit the historic Rawana Falls and Lipton's Seat."
    ],
    "province9" => [
        "name" => "Sabaragamuwa Province",
        "image" => "img/destination-9.jpg",
        "description" => "Sabaragamuwa Province is famous for its gem mines, wildlife, and waterfalls. Explore the gem city of Ratnapura, visit Udawalawe National Park, and hike through the lush greenery of Kitulgala."
    ]
];


// Get the province ID from the query parameter
$province_id = $_GET['province'] ?? "province1";
$province_details = $provinces[$province_id] ?? null;
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

    <!-- Province details Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5">
            <div class="row">
                <!-- Left Column for Image -->
                <div class="col-lg-6 position-relative">
                    <img src="img/map3.png" alt="Sri Lanka Map" style="width: 100%; max-height: 800px;">

                    <!-- Dynamic Location Links -->
                    <?php
                    // Define positions for each district marker (these positions are placeholders and may need adjustment)
                    $districtPositions = [
                        1 => ["top" => "80%", "left" => "35%"], // Galle
                        2 => ["top" => "82%", "left" => "43%"], // Matara
                        3 => ["top" => "80%", "left" => "55%"], // Hambantota
                        4 => ["top" => "67%", "left" => "30%"], // Colombo
                        5 => ["top" => "62%", "left" => "30%"], // Gampaha
                        6 => ["top" => "72%", "left" => "32%"], // Kalutara
                        7 => ["top" => "58%", "left" => "45%"], // Kandy
                        8 => ["top" => "50%", "left" => "47%"], // Matale
                        9 => ["top" => "65%", "left" => "47%"], // Nuwara Eliya
                        10 => ["top" => "10%", "left" => "30%"], // Jaffna
                        11 => ["top" => "17%", "left" => "35%"], // Kilinochchi
                        12 => ["top" => "27%", "left" => "30%"], // Mannar
                        13 => ["top" => "27%", "left" => "42%"], // Vavuniya
                        14 => ["top" => "20%", "left" => "42%"], // Mullaitivu
                        15 => ["top" => "35%", "left" => "42%"], // Anuradhapura
                        16 => ["top" => "45%", "left" => "55%"], // Polonnaruwa
                        17 => ["top" => "35%", "left" => "57%"], // Trincomalee
                        18 => ["top" => "47%", "left" => "65%"], // Batticaloa
                        19 => ["top" => "60%", "left" => "72%"], // Ampara
                        20 => ["top" => "43%", "left" => "27%"], // Puttalam
                        21 => ["top" => "50%", "left" => "35%"], // Kurunegala
                        22 => ["top" => "72%", "left" => "45%"], // Ratnapura
                        23 => ["top" => "62%", "left" => "37%"], // Kegalle
                        24 => ["top" => "63%", "left" => "55%"], // Badulla
                        25 => ["top" => "68%", "left" => "62%"], // Monaragala
                    ];

                    foreach ($districtPositions as $id => $position) {
                        echo "<a href='#' class='location-link' data-id='{$id}' style='position: absolute; top: {$position['top']}; left: {$position['left']}; text-decoration: none;'>
                                <i class='fas fa-map-marker-alt text-primary' style='font-size: 1.5rem;'></i>
                            </a>";
                    }
                    ?>
                </div>

                <!-- Right Column for Content -->
                <div class="col-lg-6 pb-lg-5">
                    <div class="bg-white p-4 p-lg-5 my-lg-5" id="provinceDetails">
                        <h1 class="text-primary mb-3" id="provinceName"><?= $province_details['name'] ?></h1>
                        <div class="position-relative h-100 mb-3">
                            <img src="<?= $province_details['image'] ?>" id="provinceImage" alt="<?= $province_details['name'] ?>"
                                style="width: 100%; height: 250px; object-fit: cover;">
                        </div>
                        <p id="provinceDescription"><?= $province_details['description'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Province details End -->

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
    <script src="js/district-details.js"></script>

</body>

</html>