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
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit User</h1>
        <?php
        require '../../vendor/autoload.php';

        // Σύνδεση στη MongoDB
        $client = new MongoDB\Client("mongodb://localhost:27017");
        $database = $client->candlesDB;
        $collection = $database->users;

        // Λήψη του ID του χρήστη από τη διεύθυνση URL
        $userId = $_GET['id'];

        // Ανάκτηση των στοιχείων του χρήστη
        $user = $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($userId)]);

        // Ενημέρωση στοιχείων χρήστη
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $name_user = $_POST['name_user'];
            $lastname_user = $_POST['lastname_user'];
            $town_user = $_POST['town_user'];
            $address_user = $_POST['address_user'];

            $collection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($userId)],
                ['$set' => [
                    'username' => $username,
                    'email' => $email,
                    'name_user' => $name_user,
                    'lastname_user' => $lastname_user,
                    'town_user' => $town_user,
                    'address_user' => $address_user
                ]]
            );

            echo "<script>alert('User updated successfully!'); window.location.href = 'first_page.php';</script>";
        }
        ?>

        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="name_user" class="form-label">Όνομα</label>
                <input type="text" class="form-control" id="name_user" name="name_user" value="<?php echo htmlspecialchars($user['name_user']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="lastname_user" class="form-label">Επίθετο</label>
                <input type="text" class="form-control" id="lastname_user" name="lastname_user" value="<?php echo htmlspecialchars($user['lastname_user']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="town_user" class="form-label">Πόλη</label>
                <input type="text" class="form-control" id="town_user" name="town_user" value="<?php echo htmlspecialchars($user['town_user']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="address_user" class="form-label">Διεύθυνση</label>
                <input type="text" class="form-control" id="address_user" name="address_user" value="<?php echo htmlspecialchars($user['address_user']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
</body>

</html>