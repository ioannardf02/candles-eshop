<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../vendor/autoload.php';

try {
    // Connect to MongoDB
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $database = $client->candlesDB;
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

    if (!$user) {
        // Redirect if user not found
        header("Location: login.php");
        exit;
    }
} catch (Exception $e) {
    // Display error message if needed
    $user = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - JoJoScent</title>
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
        <div class="container mt-4">
            <h2>Λεπτομέρειες Χρήστη</h2>
            <?php if ($user): ?>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Προσωπικά Στοιχεία</h4>
                        <p><strong>Όνομα:</strong> <?php echo htmlspecialchars($user->name_user); ?></p>
                        <p><strong>Επώνυμο:</strong> <?php echo htmlspecialchars($user->lastname_user); ?></p>
                        <p><strong>Ηλεκτρονικό Ταχυδρομείο:</strong> <?php echo htmlspecialchars($user->email); ?></p>
                        <p><strong>Διεύθυνση:</strong> <?php echo htmlspecialchars($user->address_user); ?>, <?php echo htmlspecialchars($user->town_user); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h4>Στοιχεία Λογαριασμού</h4>
                        <p><strong>Όνομα Χρήστη:</strong> <?php echo htmlspecialchars($user->username); ?></p>
                        <p><strong>Τύπος Λογαριασμού:</strong> <?php echo htmlspecialchars($user->type); ?></p>
                    </div>
                </div>
            <?php else: ?>
                <p>Δεν βρέθηκαν στοιχεία χρήστη.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
