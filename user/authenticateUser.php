<?php
    session_start();
    if (!isset($_SESSION["loggedin"])) {
        $_SESSION["notLoggedIn"] = true;
        header("Location: home.php");
    }
?>