<?php 

require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb://localhost:27017");

$candlesDB = $client ->candlesDB;

$products = $candlesDB -> createCollection('products');
$users = $candlesDB -> createCollection('users');
$reviews = $candlesDB -> createCollection('reviews');

var_dump($products);
var_dump($users);
var_dump($reviews);

?>