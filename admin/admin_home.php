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
            <a class="navbar-brand" href="admin_home.php">JoJoScent</a>
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
                            <a class="nav-link" aria-current="page" href="admin_home.php">Αρχική</a>
                        </li>
                        <li class=" nav-item">
                            <a class="nav-link" href="users/first_page.php">Χρήστες</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="products/first_page.php">Προϊόντα</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Παραγγελίες</a>
                        </li>
                    </ul>
                    <a href="../user/logout.php" class="y_button btn mb-3 mb-lg-0 btn-dark">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <main>

        <section id="welcome" class="text-center container-fluid">
            <h1 class="text-center my-4">Σελίδα Διαχειρηστή</h1>
            <h2 class="mb-6">Γενικές κατηγορίες διαχείρησης</h2>
            <p class="my-4">Καλώς ορίσατε την σελίδα Διαχείρησης του καταστήματος. Εδώ έχετε πρόσβαση στην διαχείρηση
                των Χρηστών που
                είναι εγγεγραμμένοι στο σύστημα, τα Προϊόντα που διαθέτουμε καθώς και τις Παραγγελίες των πελατών μας.
            </p>
            <div class="list-group list-group-horizontal-lg text-center mb-2">
                <a href="users/first_page.php" class="list-group-item list-group-item-action rounded-end "
                    style="background-color: rgb(25, 25, 25); color: #edede9;">Χρήστες</a>

                <a href="products/first_page.php"
                    class="list-group-item list-group-item-action rounded-end rounded-start"
                    style="background-color: rgb(25, 25, 25); color: #edede9;">Προϊόντα</a>
                <a href="" class="list-group-item list-group-item-action rounded-start"
                    style="background-color: rgb(25, 25, 25); color: #edede9;">Παραγγελίες</a>
            </div>
            <div class="list-group list-group-horizontal-lg text-center">
                <p class="list-group-item">*Εδώ μπορείτε να διαχειρηστείτε όλους τους χρήστες
                    που είναι εγγεγραμμένοι στο σύστημα.</p>
                <p class="list-group-item ">*Εδώ μπορείτε να διαχειρηστείτε όλα τα προϊόντα που διαθέτει
                    το κατάστημα μας.</p>
                <p class="list-group-item">*Εδώ μπορείτε να διαχειρηστείτε όλες τις Παραγγελίες που έχουν γίνει στο
                    κατάστημα.</p>
            </div>
        </section>

    </main>

</body>

</html>