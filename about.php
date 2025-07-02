<?php
// Include database connection (replace with your actual database connection file)
include('db.php');

$about_us_query = "SELECT * FROM about_us LIMIT 1";
$about_us_result = $conn->query($about_us_query);
$about_us = $about_us_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Explorer Center-Sri Lanka</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />

    <!-- Base URL -->
    <!-- <base href="/explorer-center/" /> -->

    <!-- Favicon -->
    <link href="img/icon.webp" rel="icon" />

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

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet" />
  </head>
  <body>
    <!-- Topbar Start -->
    <div id="topbar"></div>
    <script>
      fetch("components/topbar.html")
        .then((response) => response.text())
        .then((data) => {
          const tempDiv = document.createElement("div");
          tempDiv.innerHTML = data;
          const template = tempDiv.querySelector("template");
          document
            .getElementById("topbar")
            .appendChild(template.content.cloneNode(true));
        })
        .catch((error) => console.error("Error loading header:", error));
    </script>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div id="header"></div>
    <script>
      fetch("components/header.html")
        .then((response) => response.text())
        .then((data) => {
          const tempDiv = document.createElement("div");
          tempDiv.innerHTML = data;
          const template = tempDiv.querySelector("template");
          document
            .getElementById("header")
            .appendChild(template.content.cloneNode(true));
        })
        .catch((error) => console.error("Error loading header:", error));
    </script>
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid page-header">
      <div class="container">
        <div
          class="d-flex flex-column align-items-center justify-content-center"
          style="min-height: 400px"
        >
          <h3 class="display-4 text-white text-uppercase">About Us</h3>
          <div class="d-inline-flex text-white">
            <p class="m-0 text-uppercase">
              <a class="text-white" href="">Home</a>
            </p>
            <i class="fa fa-angle-double-right pt-1 px-3"></i>
            <p class="m-0 text-uppercase">About Us</p>
          </div>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container pt-5">
            <div class="row">
                <div class="col-lg-6" style="min-height: 500px">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100" src="<?= $about_us['image_main'] ?>" style="object-fit: cover" />
                    </div>
                </div>
                <div class="col-lg-6 pt-5 pb-lg-5">
                    <div class="about-text bg-white p-4 p-lg-5 my-lg-5">
                        <h6 class="text-primary text-uppercase" style="letter-spacing: 5px"><?= $about_us['subtitle'] ?></h6>
                        <h1 class="mb-3"><?= $about_us['title'] ?></h1>
                        <p><?= nl2br($about_us['description']) ?></p>
                        <div class="row mb-4">
                            <div class="col-6">
                                <img class="img-fluid" src="<?= $about_us['image_1'] ?>" alt="" />
                            </div>
                            <div class="col-6">
                                <img class="img-fluid" src="<?= $about_us['image_2'] ?>" alt="" />
                            </div>
                        </div>
                        <a href="" class="btn btn-primary mt-1">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Feature Start -->
    <div class="container-fluid pb-5">
      <div class="container pb-5">
        <div class="row">
          <div class="col-md-4">
            <div class="d-flex mb-4 mb-lg-0">
              <div
                class="d-flex flex-shrink-0 align-items-center justify-content-center bg-primary mr-3"
                style="height: 100px; width: 100px"
              >
                <i class="fa fa-2x fa-money-check-alt text-white"></i>
              </div>
              <div class="d-flex flex-column">
                <h5 class="">Competitive Pricing</h5>
                <p class="m-0">
                  Experience Sri Lanka's beauty without breaking the bank with
                  our competitive tour pricing
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="d-flex mb-4 mb-lg-0">
              <div
                class="d-flex flex-shrink-0 align-items-center justify-content-center bg-primary mr-3"
                style="height: 100px; width: 100px"
              >
                <i class="fa fa-2x fa-award text-white"></i>
              </div>
              <div class="d-flex flex-column">
                <h5 class="">Best Services</h5>
                <p class="m-0">
                  Unmatched hospitality and personalized experiences for an
                  unforgettable Sri Lankan adventure.
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="d-flex mb-4 mb-lg-0">
              <div
                class="d-flex flex-shrink-0 align-items-center justify-content-center bg-primary mr-3"
                style="height: 100px; width: 100px"
              >
                <i class="fa fa-2x fa-globe text-white"></i>
              </div>
              <div class="d-flex flex-column">
                <h5 class="">Island Coverage</h5>
                <p class="m-0">
                  Discover every corner of the paradise island with our
                  extensive Sri Lanka tour coverage.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Feature End -->

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

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"
      ><i class="fa fa-angle-double-up"></i
    ></a>

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
