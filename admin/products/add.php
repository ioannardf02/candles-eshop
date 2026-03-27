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
    <main>
        <div class="row gx-0 my-3">
            <h1 class="text-center my-2">Νέο Προϊόν</h1>
            <div class="col-6 offset-3">
                <form action="" method="POST">
                    <input type="hidden" name="formType" value="programCreate">
                    <div class="mb-3">
                        <label class="form-label" for="image_product">URL Εικόνας</label>
                        <input class="form-control" type="url" pattern="https://.*" id="image_product"
                            name="image_product" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="name_product">Όνομα Προϊόντος</label>
                        <input class="form-control" type="text" id="name_product" name="name_product" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="price_product">Τιμή</label>
                        <input class="form-control" type="number" id="price_product" name="price_product"
                            required></input>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description_product">Περιγραφή</label>
                        <textarea class="form-control" rows="6" type="text" id="description_product"
                            name="description_product" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="stock_product">Διαθεσιμότητα</label>
                        <input class="form-control" type="number" id="stock_product" name="stock_product" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="favorite">Αγαπημένα</label>
                        <select class="form-select" id="favorite" name="favorite" required>
                        <option selected disabled>Επέλεξε Τύπο</option>
                        <option value="true">true</option>
                        <option value="false">false</option></select>
                    </div>
                    <div class="container text-center">
                        <button type="submit" class="btn btn-primary">Υποβολή</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="container text-center">
            <a href="first_page.php" class="btn btn-success my-4">Επιστροφή στην Διαχείριση Προϊόντων</a>
        </div>

        <?php
            require '../../vendor/autoload.php';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             // Σύνδεση με τη MongoDB
                $client = new MongoDB\Client("mongodb://localhost:27017");
                $database = $client->candlesDB;
                $collection = $database->products;

    // Λήψη δεδομένων από τη φόρμα
                $image_product = $_POST['image_product'];
                $name_product = $_POST['name_product'];
                $price_product = $_POST['price_product'];
                $description_product = $_POST['description_product'];
                $stock_product = $_POST['stock_product'];
                $favorite = $_POST['favorite'];

    // Εισαγωγή των δεδομένων στη βάση
                $insertOneResult = $collection->insertOne([
                'image' => $image_product,
                'name' => $name_product,
                'price' => (float) $price_product,
                'description' => $description_product,
                'stock' => (int) $stock_product,
                'favorite' => (bool) $favorite,
                ]);

        // Επιβεβαίωση ότι το προϊόν προστέθηκε με επιτυχία
                if ($insertOneResult->getInsertedId()) {
                    echo "<p class='text-success text-center'>Το προϊόν προστέθηκε επιτυχώς!</p>";
                } else {
                    echo "<p class='text-danger text-center'>Υπήρξε πρόβλημα κατά την προσθήκη του προϊόντος.</p>";
                }
            }
        ?>

    </main>

</body>