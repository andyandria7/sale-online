<?php
require_once("../Models/ProductModel.php");
require_once("../models/Database.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$json = file_get_contents('php://input');
$data = json_decode($json);

$imageBase64 = $data->image;
$title = $data->title;
$description = $data->description;
$price = $data->price;
$user_id = $data->user_id;

if (preg_match('/^data:image\/(\w+);base64,/', $imageBase64, $type)) {
    $imageBase64 = substr($imageBase64, strpos($imageBase64, ',') + 1);
    $extension = strtolower($type[1]);
} else {
    $extension = 'jpg'; 
}

if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
    echo json_encode(["error" => "Format d'image non supporté"]);
    exit;
}

$imageName = uniqid() . '.' . $extension;

$imagePath = __DIR__ . '/../public/images/' . $imageName;

if (!file_exists(dirname($imagePath))) {
    mkdir(dirname($imagePath), 0755, true);
}

if (file_put_contents($imagePath, base64_decode($imageBase64))) {
    
    $product = new ProductModel($imageName, $title, $description, $price, $user_id);
    $userData = $product->createProduct($imageName, $title, $description, $price, $user_id);
    
    echo json_encode(["success" => "Produit ajouté avec succès"]);
    
} else {
    echo json_encode(["error" => "Erreur lors de l'enregistrement de l'image"]);
}
?>
