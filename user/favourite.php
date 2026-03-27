<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../vendor/autoload.php';

try {
    // Connect to MongoDB
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $database = $client->candlesDB;
    $productsCollection = $database->products;
    $userCollection = $database->users;

    // Start session
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        header("Location: login.php");
        exit;
    }

    // Fetch user data
    $userId = $_SESSION['user_id'];
    $user = $userCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($userId)]);

    if ($user) {
        if (isset($user->favorites) && $user->favorites instanceof MongoDB\Model\BSONArray) {
            $favoriteProductIds = $user->favorites->getArrayCopy();

            // Convert to MongoDB ObjectId
            $objectIdArray = array_map(function($id) {
                return new MongoDB\BSON\ObjectId((string)$id);
            }, $favoriteProductIds);

            // Fetch products from the collection
            $query = ['_id' => ['$in' => $objectIdArray]];
            $products = $productsCollection->find($query);
            $productArray = iterator_to_array($products);

            if (empty($productArray)) {
                $productArray = []; // Ensure variable is defined
            }
        } else {
            $productArray = [];
        }
    } else {
        $productArray = [];
    }
} catch (Exception $e) {
    // Display error message if needed
    $productArray = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites - JoJoScent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
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
                            <input class="form-control me-2" type="search" placeholder="Αναζήτηση" aria-label="Αναζήτηση">
                            <button class="btn btn-dark me-3" type="submit" data-bs-theme="dark">Αναζήτηση</button>
                            <?php
                                if (session_status() === PHP_SESSION_NONE) {
                                    session_start();
                                }
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
        <h2 style="text-align: center; margin: 2%;">Τα Αγαπημένα Μου Προϊόντα</h2>
        <section id="serv">
            <div class="container">
                <div class="row">
                    <?php if (empty($productArray)): ?>
                        <p style="text-align: center;">No favorite products found.</p>
                    <?php else: ?>
                        <?php foreach ($productArray as $product): ?>
                            <div class="col-lg-3 col-md-6">
                                <a href="product.php?id=<?php echo htmlspecialchars($product->_id); ?>">
                                    <img src="<?php echo htmlspecialchars($product->image); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product->name); ?>">
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="product.php?id=<?php echo htmlspecialchars($product->_id); ?>" class="link">
                                            <?php echo htmlspecialchars($product->name); ?>
                                        </a>
                                    </h5>
                                    <p class="card-text"><?php echo htmlspecialchars($product->price); ?>&euro;</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
