<?php
session_start();
require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Please fill in both fields.";
    } else {
        try {
            $client = new MongoDB\Client("mongodb://localhost:27017");
            $database = $client->candlesDB;
            $collection = $database->users;

            $user = $collection->findOne(['username' => $username]);

            if ($user && $password === $user['password']) {
                $_SESSION['user_id'] = (string)$user['_id'];
                $_SESSION['username'] = $user['username'];
                if ($user->type == "Διαχειριστής") {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["username"] = $username;
                    $_SESSION["type"] = $user->type;
                    header("location: ../admin/admin_home.php");
                } elseif ($user->type == "Απλός") {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["username"] = $username;
                    $_SESSION["type"] = $user->type;
                    header("location: home.php");
                }
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>
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

<body id="bg">
    <header style="background-color: #cfc8c5;">
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

        <div class="container">
            <div class="row align-items-center justify-content-center my-3">
                <div class="card mb-3" style="max-width: 400px; margin: 8%;">
                    <div class="card-body text-center">
                        <h5 class="card-title">Σύνδεση</h5>
                        <form method="POST" action="login.php">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                                    required>
                                <label for="username">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                                    required>
                                <label for="password">Password</label>
                            </div>
                            <button type="submit" class="btn btn-dark">Σύνδεση</button>
                        </form>
                        <p class="card-text"><small class="text-body-secondary">
                                <a href="register.php" class="card-link link">Κάνε Εγγραφή Τώρα!</a></small></p>
                    </div>
                </div>
            </div>
        </div>

    </main>
</body>

</html>