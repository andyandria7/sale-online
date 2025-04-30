<?php
require_once("../Models/LoginModel.php");
require_once("../models/Database.php");

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!isset($data['user_id']) || empty($data['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'ID utilisateur manquant'
    ]);
    exit;
}

$user_id = $data['user_id'];

$user = new LoginModel("", "", "", "");

$userData = $user->read($user_id);

if ($userData) {
    echo json_encode([
        'success' => true,    
        'user' => $userData
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Utilisateur non trouvé'
    ]);
}