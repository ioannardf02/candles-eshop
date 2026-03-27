<?php
require '../../vendor/autoload.php'; // Include Composer's autoload file

// Connect to MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
$database = $client->candlesDB;
$collection = $database->products;

// Fetch all products
$products = $collection->find();
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Διαγραφή του προϊόντος από τη συλλογή
    $deleteResult = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($productId)]);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JoJoScent - Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</head>

<body style="background-color: #edede9">
    <nav class="navbar navbar-expand-lg" style="background-color: #cfc8c5;">
        <div class="container-fluid">
            <a class="navbar-brand" href="../admin_home.php">JoJoScent</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">JoJoScent Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="../admin_home.php">Αρχική</a>
                        </li>
                        <li class=" nav-item">
                            <a class="nav-link" href="../users/first_page.php">Χρήστες</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="first_page.php">Προϊόντα</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Παραγγελίες</a>
                        </li>
                    </ul>
                    <a href="../../user/logout.php" class="y_button btn mb-3 mb-lg-0 btn-dark">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="d-flex flex-column vh-100">
        <section class="container mt-5">
            <h1 class="text-center mb-4">Όλα τα Προϊόντα</h1>
            <?php foreach ($products as $product): ?>
            <div class='card mb-5'>
                <div class='row align-items-center'>
                    <div class='col-lg-4 col-md-12'>
                        <img src="<?php echo htmlspecialchars($product->image); ?>" alt='<?php echo htmlspecialchars($product->name); ?>' class='img-fluid'>
                    </div>
                    <div class='col-lg-8 col-md-12'>
                        <div class='card-body'>
                            <h2 class='card-title fs-4'><?php echo htmlspecialchars($product->name); ?></h2>
                            <p class='card-text'><?php echo htmlspecialchars($product->description); ?></p>
                            <a href="edit.php?id=<?php echo $product->_id; ?>" class='btn btn-dark'>Επεξεργασία</a>
                            <a href='?action=delete&id=<?php echo $product->_id; ?>' class='btn btn-danger' onclick='return confirm("Είστε σίγουροι ότι θέλετε να διαγράψετε αυτό το προϊόν;")'>Διαγραφή</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <div>
                <a href="add.php" class="btn btn-dark my-3">Προσθήκη Προϊόντος</a>
            </div>
        </section>
    </main>

</body>
</html>