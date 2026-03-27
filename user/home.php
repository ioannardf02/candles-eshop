<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JoJoScent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../styles/home.css">
</head>

<body>
    <header>
        <div style="background-color: #edede9">
            <a href="home.php" class="link">
                <h1><img src="../pics/logo3.png" height="80"> JoJoScent </h1>
            </a>
        </div>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php" style="color: #212529">Αρχική Σελίδα</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="aboutUs.php">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="allProducts.php">Όλα τα Προϊόντα</a>
                            </li>
                        </ul>
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Αναζήτηση"
                                aria-label="Αναζήτηση">
                            <button class="btn btn-dark me-3" type="submit" data-bs-theme="dark">Αναζήτηση</button>
                            <?php
                                if (session_status() === PHP_SESSION_NONE) {
                                    session_start();
                                }
                                //If the user is logged in display the user profile link too
                                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                                    echo '<a href="shoppingBasket.php" class="me-3"> <img src="../pics/shopping-basket.png" height="25"> </a>';
                                    echo '<a href="favourite.php" class="me-3"> <img src="../pics/hearts.png" height="25"> </a>';
                                    echo '<a href="myAccount.php" class="btn btn-dark me-2" >Λογαριασμός</a>';
                                    echo ' <a class="btn btn-dark " href="logout.php" > Logout</a>';
                                } else {
                                    echo '<a href="login.php" class="btn btn-dark " >Login/Register</a>';
                                }
                                ?>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <section class="container-fluid">
            <div>
                <img src="https://i.ebayimg.com/images/g/0kQAAOSwD6plPnX6/s-l1200.webp" class="img-fluid" alt="..."
                    style=" width: 100%; height: 700px; background-size: 100%;">
                <a href="allProducts.php" class="btn btn-dark" id="btn_img">Όλα τα προϊόντα</a>
            </div>
        </section>

        <section id="aboutUs" class="container-fluid">
            <div class="row align-items-center px-0 py-3">
                <div class="col-md-6 order-2 order-md-1">
                    <img src="https://www.marthastewart.com/thmb/ABj72kSmB360FxboyXKXe33Y520=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/ways-to-make-your-candles-last-longer-0922-2000-52bf20185e7f485fa2557e9c446194c3.jpg"
                        alt="" class="img-fluid">
                </div>

                <div class="col-md-6 text-center order-1 order-md-2" style="color: black">
                    <div class="row justify-content-center">
                        <div class="col-10 col-lg-8 blurb mb-5 mb-md-0">
                            <a href="aboutUs.php" class="link">
                                <h2>About Us</h2>
                            </a>
                            <p class="lead">Στην JoJoScent, πιστεύουμε ότι τα αρώματα έχουν τη δύναμη να
                                δημιουργήσουν συναισθηματικές συνδέσεις και να μεταμορφώσουν τον τρόπο με τον οποίο
                                αισθανόμαστε και ζούμε. Έχουμε αφιερώσει τον εαυτό μας στο
                                να φέρνουμε στον καθημερινό σας χώρο τα πιο εξαιρετικά κεριά και αρωματικά προϊόντα.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        </section>
        <section class="container-fluid text-center mb-3">
    <div class="row my-3 text-center gx-3 gy-2">
        <h3 class="mb-4">Κορυφαία Προϊόντα</h3>

        <?php
        require '../vendor/autoload.php';

        // Σύνδεση στη MongoDB
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $database = $client->candlesDB;
        $collection = $database->products;

        // Ανάκτηση των κορυφαίων προϊόντων (μπορείς να προσθέσεις κριτήρια όπως βαθμολογία ή πωλήσεις)
        $topProducts = $collection->find([], ['limit' => 3]); // περιορισμός στα 3 κορυφαία προϊόντα

        // Εμφάνιση προϊόντων
        foreach ($topProducts as $product) {
            echo '<div class="col-lg-4 col-md-6">';
            echo '<div class="p-1">';
            echo '<a aria-expanded="true" href="product.php?id=' . $product->_id . '">';
            echo '<img src="' . htmlspecialchars($product['image']) . '" class="img-fluid">';
            echo '</a>';
            echo '<h4>' . htmlspecialchars($product['name']) . '</h4>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</section>

        <!-- <section class="container-fluid text-center mb-3">
            <div class="row my-3 text-center gx-3 gy-2">
                <h3 class="mb-4">Κορυφαία Προϊόντα</h3>
                <div class="col-lg-4 col-md-6">
                    <div class="p-1 ">
                        <a aria-expanded="true" href="product.php">
                            <img src="https://www.happycloud.gr/wp-content/uploads/2022/09/almond-croissant.jpg"
                                class="img-fluid">
                        </a>
                        <h4>Κερί με άρωμα Κρουασάν</h4>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="p-1 ">
                        <a aria-expanded="true" href="product.php">
                            <img src="https://ergastirioskiwnkouzaros.com/wp-content/uploads/2023/10/%CE%91%CF%81%CF%89%CE%BC%CE%B1%CF%84%CE%B9%CE%BA%CF%8C-%CE%9A%CE%B5%CF%81%CE%AF-%CE%A3%CF%8C%CE%B3%CE%B9%CE%B1%CF%82-Raspberry-Dream.jpeg"
                                class="img-fluid">
                        </a>
                        <h4>Κερί με άρωμα Ράσμπερι</h4>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="p-1">
                        <a aria-expanded="true" href="product.php">
                            <img src="https://i.ebayimg.com/images/g/3McAAOSw6XljwzCG/s-l1200.jpg" class="img-fluid">
                        </a>
                        <h4>Κερί με άρωμα Βανίλια</h4>
                    </div>
                </div>
            </div>
        </section> -->
    </main>
    <footer class="text-center text-lg-start text-muted bg-dark" data-bs-theme="dark">
        <!-- Section: Social media -->
        <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
            <!-- Left -->
            <div class="me-5 d-none d-lg-block">
                <span>Βρείτε μας στα social networks:</span>
            </div>
            <!-- Left -->

            <!-- Right -->
            <div>
                <a href="#" class="me-4 text-reset" style="text-decoration: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-facebook" viewBox="0 0 16 16">
                        <path
                            d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                    </svg>
                </a>
                <a href="" class="me-4 text-reset" style="text-decoration: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-google" viewBox="0 0 16 16">
                        <path
                            d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z" />
                    </svg>
                </a>
                <a href="" class="me-4 text-reset" style="text-decoration: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-instagram" viewBox="0 0 16 16">
                        <path
                            d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                    </svg>
                </a>
                <a href="" class="me-4 text-reset" style="text-decoration: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-tiktok" viewBox="0 0 16 16">
                        <path
                            d="M9 0h1.98c.144.715.54 1.617 1.235 2.512C12.895 3.389 13.797 4 15 4v2c-1.753 0-3.07-.814-4-1.829V11a5 5 0 1 1-5-5v2a3 3 0 1 0 3 3z" />
                    </svg>
                </a>
            </div>
            <!-- Right -->
        </section>
        <!-- Section: Social media -->

        <!-- Section: Links  -->
        <section class="">
            <div class="container text-center text-md-start mt-5 justify-content-center">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->

                    <div class="col-md-3 col-lg-1 col-xl-3 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Χρήσιμα Links:
                        </h6>
                        <p>
                            <a href="#!" class="text-reset">Checkout</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Ο λογαργιασμός μου</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Τρόποι πληρωμής</a>
                        </p>
                        <p>
                            <a href="aboutUs.php" class="text-reset">About Us</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Βοήθεια</a>
                        </p>
                    </div>

                    <div class="col-md-3 col-lg-1 col-xl-3 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold mb-4">Επικοινωνία</h6>
                        <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-house" viewBox="0 0 16 16">
                                <path
                                    d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                            </svg> Καραολή και Δημητρίου 80, Πειραιάς 185 34</p>
                        <p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-envelope" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                            </svg>
                            info@jojoscent.com
                        </p>
                        <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                            </svg> + 00 111 222 33</p>
                    </div>
                    <!-- Grid column -->

                    <div class="col-md-6 col-lg-10 col-xl-6 mx-auto mb-md-0 mb-4">
                        <!-- Links -->
                        <iframe width="100%" height="200" frameborder="0" scrolling="no" marginheight="0"
                            marginwidth="0"
                            src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=Karaoli%20ke%20Dimitriou%2080,%20Pireas%20185%2034+(My%20Business%20Name)&amp;t=&amp;z=16&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a
                                href="https://www.maps.ie/population/">Population mapping</a>
                        </iframe>

                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.3);">
            © 2024 Copyright:
            <a class="text-reset fw-bold" href="#">HomeIQ.com</a>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->
</body>

</html>