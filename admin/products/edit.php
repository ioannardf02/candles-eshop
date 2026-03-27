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
</head>
<?php
    require '../../vendor/autoload.php'; // Φάκελος με την εγκατάσταση του Composer

    // Σύνδεση με τη MongoDB
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $database = $client->candlesDB;
    $collection = $database->products;

    $product = null;
    $success = null;
    $error = null;

    // Ανάκτηση του προϊόντος αν υπάρχει παράμετρος id
    if (isset($_GET['id'])) {
        $productId = $_GET['id'];
        $product = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($productId)]);

        // Ανάκτηση δεδομένων από τη φόρμα και ενημέρωση του προϊόντος
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $image_product = $_POST['image_product'];
            $name_product = $_POST['name_product'];
            $price_product = $_POST['price_product'];
            $description_product = $_POST['description_product'];
            $stock_product = $_POST['stock_product'];

            $updateResult = $collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($productId)],
                [
                    '$set' => [
                        'image' => $image_product,
                        'name' => $name_product,
                        'price' => (float) $price_product,
                        'description' => $description_product,
                        'stock' => (int) $stock_product
                    ]
                ]
            );

            if ($updateResult->getModifiedCount() > 0) {
                $success = "Οι αλλαγές αποθηκεύτηκαν με επιτυχία!";
            } else {
                $error = "Υπήρξε πρόβλημα κατά την αποθήκευση των αλλαγών.";
            }

            // Επαναφόρτωση του προϊόντος μετά την ενημέρωση
            $product = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($productId)]);
        }
    } else {
        header("Location: first_page.php"); // Επανακατεύθυνση αν δεν υπάρχει id
        exit;
    }
?>

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
            <h1 class="text-center mb-4">Επεξεργασία Προϊόντος</h1>
            <?php if ($success): ?>
                <p class="text-success text-center"><?php echo $success; ?></p>
            <?php elseif ($error): ?>
                <p class="text-danger text-center"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="col-6 offset-3">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label" for="image_product">URL Εικόνας</label>
                        <input class="form-control" type="url" pattern="https://.*" id="image_product"
                            name="image_product" value="<?php echo htmlspecialchars($product->image); ?>" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="name_product">Όνομα Προϊόντος</label>
                        <input class="form-control" type="text" id="name_product" name="name_product"
                            value="<?php echo htmlspecialchars($product->name); ?>" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="price_product">Τιμή</label>
                        <input class="form-control" type="number" id="price_product" name="price_product"
                            value="<?php echo htmlspecialchars($product->price); ?>" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description_product">Περιγραφή</label>
                        <textarea class="form-control" rows="6" type="text" id="description_product"
                            name="description_product" required><?php echo htmlspecialchars($product->description); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="stock_product">Διαθεσιμότητα</label>
                        <input class="form-control" type="number" id="stock_product" name="stock_product"
                            value="<?php echo htmlspecialchars($product->stock); ?>" required />
                    </div>
                    <div class="container text-center">
                        <button type="submit" class="btn btn-primary">Αποθήκευση Αλλαγών</button>
                    </div>
                </form>
            </div>
            <div class="container text-center">
                <a href="first_page.php" class="btn btn-success my-4">Επιστροφή στην Διαχείριση Προϊόντων</a>
            </div>
        </section>
    </main>

</body>

</html>