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
    <link rel="stylesheet" href="../styles/ratingStars.css">
    <link rel="stylesheet" href="../styles/heart.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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
        <?php
          require '../vendor/autoload.php';

          // Connect to MongoDB
          $client = new MongoDB\Client("mongodb://localhost:27017");
          $database = $client->candlesDB;
          $collection = $database->products;
          $userCollection = $database->users;
          
          // Check if the `id` is provided in the URL
          if (isset($_GET['id'])) {
              $productId = $_GET['id'];
          
              // Fetch the product from the database
              $product = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($productId)]);
          
              // Determine if the user has already favorited the product
              if (session_status() === PHP_SESSION_NONE) {
                  session_start();
              }
          
              if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                  $userId = $_SESSION['user_id'];
                  $user = $userCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($userId)]);
                  $favorites = isset($user['favorites']) ? $user['favorites'] : [];
          
                  // Ensure $favorites is an array
                  if (!is_array($favorites)) {
                      $favorites = iterator_to_array($favorites);
                  }
          
                  // Check if the product is already in favorites
                  $isFavorite = in_array(new MongoDB\BSON\ObjectId($productId), $favorites);
              } else {
                  $isFavorite = false;
              }
          }  
        ?>
        <div class="container light-style flex-grow-1">
            <div class="row gx-0 py-5">
                <div class="col-lg-6 col-md-20">
                    <div class="mb-3">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-account_general" role="tabpanel"
                             aria-labelledby="v-pills-account_general-tab" tabindex="0">
                            <div class="card-body">
                                <form style="margin-left: 10%;">
                                    <div class=" mb-3">
                                        <h3><?php echo htmlspecialchars($product['name']); ?> <i class="bi heart-icon <?php echo $isFavorite ? 'bi-heart-fill' : 'bi-heart'; ?>" data-product-id="<?php echo $product['_id']; ?>"></i></h3>                                        
                                    </div>
                                    <div class=" mb-5">
                                        <h4><?php echo htmlspecialchars($product['price']); ?>&euro;</h4>
                                    </div>
                                    <div class=" mb-5">
                                        <p>Διαθεσιμότητα: <?php echo htmlspecialchars($product['stock']); ?></p>
                                    </div>
                                    <div class=" mb-5">
                                        <h5>Περιγραφή Προϊόντος</h5>
                                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                                    </div>
                                    <button class="btn btn-dark" type="submit">Προσθήκη στο καλάθι</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
                     document.addEventListener('DOMContentLoaded', function() {
                const heartIcons = document.querySelectorAll('.heart-icon');

                heartIcons.forEach(icon => {
                    icon.addEventListener('click', function() {
                        const productId = this.dataset.productId;
                        const isFavorite = this.classList.contains('bi-heart-fill');

                        if (isFavorite) {
                            this.classList.remove('bi-heart-fill');
                            this.classList.add('bi-heart');
                            this.style.color = '#000';
                            
                        } else {
                            this.classList.remove('bi-heart');
                            this.classList.add('bi-heart-fill');
                            this.style.color = '#f00';
                        }

                        fetch('update_favorite.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: new URLSearchParams({
                                'product_id': productId,
                                'favorite_action': isFavorite ? 'remove' : 'add'
                            })
                        }).then(response => response.json()).then(data => {
                            if (!data.success) {
                                alert('Failed to update favorite status');
                                // Revert the icon state if failed
                                if (isFavorite) {
                                    this.classList.remove('bi-heart');
                                    this.classList.add('bi-heart-fill');
                                    this.style.color = '#f00';
                                } else {
                                    this.classList.remove('bi-heart-fill');
                                    this.classList.add('bi-heart');
                                    this.style.color = '#000';
                                }
                            }
                        }).catch(error => {
                            console.error('Error:', error);
                        });
                    });
                });
            });
        </script>

</body>

</html>