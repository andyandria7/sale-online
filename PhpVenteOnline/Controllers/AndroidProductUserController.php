<?php
    require_once("../Models/ProductModel.php");
    require_once("../models/Database.php");
    
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header("Content-Type: application/json");

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if(!isset($data['user_id']) || empty($data['user_id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'ID utilisateur manquant'
        ]);
        exit;
    }   

    $user_id = $data['user_id'];

    $productModel = new ProductModel("", "", "", "", $user_id);

    $products = $productModel->readOne($user_id);

    if($products) {
        echo json_encode(["success" => true, "products" => $products]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Utilisateur non trouvé'
        ]);
    }