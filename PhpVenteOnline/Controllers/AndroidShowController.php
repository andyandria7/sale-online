<?php
require_once("../Models/ProductModel.php");
require_once("../models/Database.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$json = file_get_contents('php://input');
$data = json_decode($json);

$productModel = new ProductModel("", "", "", "", "");


$products = $productModel->readAll();
echo json_encode(["success" => true, "products" => $products]);
