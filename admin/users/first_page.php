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

    <section id="form_tables" class="table-responsive  align-items-center my-3 mx-2">
        <h1 class="text-center">Όλοι οι χρήστες</h1>
        <div>
            <a href="add.php" class="btn btn-success my-2">Προσθήκη Χρήστη</a>
        </div>
        <table class="table table-secondary table-hover caption-top">
            <caption>Λίστα με όλους τους χρήστες</caption>
            <thead>
                <tr class="table-dark">
                    <th scope="col">Τύπος</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Ονομα</th>
                    <th scope="col">Επίθετο</th>
                    <th scope="col">Πόλη</th>
                    <th scope="col">Διεύθυνση</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                require '../../vendor/autoload.php';

                // Connect to MongoDB
                $client = new MongoDB\Client("mongodb://localhost:27017");
                $database = $client->candlesDB;
                $collection = $database->users;

                // Fetch all users from the collection
                $users = $collection->find();

                // Display each user
                foreach ($users as $user) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($user['type']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['name_user']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['lastname_user']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['town_user']) . "</td>";
                    echo "<td>" . htmlspecialchars($user['address_user']) . "</td>";
                    echo "<td>";
                    echo "<a href='edit.php?id=" . $user->_id . "' class='btn btn-dark btn-sm me-2'>Edit</a>";
                    echo "<a href='?action=delete&id=" . $user->_id . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }

                // Handle deletion
                if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
                    $userId = $_GET['id'];

                    // Delete the user from the collection
                    $result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($userId)]);
                }
                ?>
            </tbody>
        </table>
    </section>
</body>

</html>