<?php
require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $userId = $_SESSION['user_id'];
        $productId = $_POST['product_id'];
        $action = $_POST['favorite_action']; // 'add' or 'remove'

        $client = new MongoDB\Client("mongodb://localhost:27017");
        $userCollection = $client->candlesDB->users;

        if ($action === 'add') {
            $userCollection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($userId)],
                ['$addToSet' => ['favorites' => new MongoDB\BSON\ObjectId($productId)]]
            );
        } else {
            $userCollection->updateOne(
                ['_id' => new MongoDB\BSON\ObjectId($userId)],
                ['$pull' => ['favorites' => new MongoDB\BSON\ObjectId($productId)]]
            );
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
    }
}
