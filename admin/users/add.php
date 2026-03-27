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
                            <a class="nav-link" href="first_page.php">Χρήστες</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../products/first_page.php">Προϊόντα</a>
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
    <h1 class="text-center my-2">Νέος Χρήστη</h1>
    <div class="col-6 offset-3">
        <form action="" method="POST">
            <input type="hidden" name="formType" value="userCreate" />
            <div class="mb-3">
                <label class="form-label" for="username">Username</label>
                <input class="form-control" type="text" id="username" name="username" required />
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <div class="input-group">
                    <span class="input-group-text" id="email-label">@</span>
                    <input type="text" class="form-control" id="email" aria-label="email" aria-describedby="email-label" name="email" required />
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label" for="name_user">Ονομα</label>
                <input class="form-control" type="text" id="name_user" name="name_user" required />
            </div>
            <div class="mb-3">
                <label class="form-label" for="lastname_user">Επιθετο</label>
                <input class="form-control" type="text" id="lastname_user" name="lastname_user" required />
            </div>
            <div class="mb-3">
                <label class="form-label" for="town_user">Πόλη</label>
                <input class="form-control" type="text" id="town_user" name="town_user" required />
            </div>
            <div class="mb-3">
                <label class="form-label" for="address_user">Διευθυνση</label>
                <input class="form-control" type="text" id="address_user" name="address_user" required />
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input class="form-control" type="password" id="password" name="password" required />
            </div>
            <div class="mb-3">
            </div>
            <div class="mb-3">
                <label class="form-label" for="type">Τύπος</label>
                <select class="form-select" id="type" name="type" required>
                <option selected disabled>Επέλεξε Τύπο</option>
                <option value="Απλός">Απλός</option>
                <option value="Διαχειριστής">Διαχειριστής</option></select>
            </div>
            <div class="my-4">
                <button class="btn btn-info" type="submit">Δημιουργία Χρήστη</button>
            </div>
        </form>
    </div>
    </div>
    <div class="container text-center">
        <a href="first_page.php" class="btn btn-success my-4">Επιστροφή στην Διαχείριση Χρηστών</a>
    </div>
        <?php
            require '../../vendor/autoload.php';

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             // Σύνδεση με τη MongoDB
                $client = new MongoDB\Client("mongodb://localhost:27017");
                $database = $client->candlesDB;
                $collection = $database->users;

    // Λήψη δεδομένων από τη φόρμα
                $type = $_POST['type'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $name_user = $_POST['name_user'];
                $lastname_user = $_POST['lastname_user'];
                $town_user = $_POST['town_user'];
                $address_user = $_POST['address_user'];
                $password = $_POST['password'];

    // Εισαγωγή των δεδομένων στη βάση
                $insertOneResult = $collection->insertOne([
                'type' => $type,
                'username' => $username,
                'email' => $email,
                'name_user' => $name_user,
                'lastname_user' => $lastname_user,
                'town_user' => $town_user,
                'address_user' => $address_user,
                'password' => $password
                ]);

        // Επιβεβαίωση ότι το προϊόν προστέθηκε με επιτυχία
                if ($insertOneResult->getInsertedId()) {
                    echo "<p class='text-success text-center'>Ο χρήστης προστέθηκε επιτυχώς!</p>";
                } else {
                    echo "<p class='text-danger text-center'>Υπήρξε πρόβλημα κατά την προσθήκη του χρήστη.</p>";
                }
            }
        ?>
    </main>
</body>

</html>